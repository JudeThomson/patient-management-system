<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SettingsController extends Controller
{
    public function index()
    {
        $dbName = config('database.connections.mysql.database');
        return view('settings.index', compact('dbName'));
    }

    public function downloadBackup()
    {
        $dbHost = config('database.connections.mysql.host');
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        
        $filename = "patient_info_backup_" . date('Y_m_d_Hi') . ".sql";
        $tempPath = storage_path('app/' . $filename);

        // Path to mysqldump on XAMPP
        $mysqldumpPath = 'C:\xampp\mysql\bin\mysqldump.exe';
        
        $command = sprintf(
            '"%s" --user=%s %s --host=%s %s > "%s"',
            $mysqldumpPath,
            $dbUser,
            $dbPass ? "--password=" . $dbPass : "",
            $dbHost,
            $dbName,
            $tempPath
        );

        // Execute the command using shell_exec
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            return back()->with('error', 'Failed to generate database backup. Please ensure mysqldump is properly configured.');
        }

        if (!file_exists($tempPath)) {
            return back()->with('error', 'Backup file was not created.');
        }

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
