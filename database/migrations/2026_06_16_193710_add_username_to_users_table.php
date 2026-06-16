<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 30)->nullable()->unique()->after('name');
        });

        // Generate usernames for existing users
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $baseUsername = Str::slug($user->name, '_');
            if (empty($baseUsername)) {
                $baseUsername = explode('@', $user->email)[0];
            }
            $baseUsername = substr($baseUsername, 0, 25);
            
            $username = $baseUsername;
            $counter = 1;
            
            while (DB::table('users')->where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }
            
            DB::table('users')->where('id', $user->id)->update(['username' => $username]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 30)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
