<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('admin1234!'),
                'role' => 'admin',
                'status' => 'active',
                'profile' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        
    }
}
