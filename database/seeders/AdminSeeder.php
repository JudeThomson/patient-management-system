<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Staff 1',
            'username' => 'staff',
            'email' => 'staff@patientinfo.com',
            'password' => Hash::make('password'),
            'role' => 'Staff',
        ]);
    }
}
