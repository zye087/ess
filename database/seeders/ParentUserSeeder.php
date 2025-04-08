<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ParentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('parent_users')->insert(
        //     [
        //         'qr_code' => 'QR-PARENT-' . rand(100000, 999999),
        //         'name' => 'John Doe',
        //         'email' => 'john.doe@example.com',
        //         'password' => Hash::make('password'),
        //         'phone_number' => '09123456789',
        //         'parent_type'   => 'father',
        //         'address'   => '643 Kuphal Plains, North Otiliafield, North Carolina - 55451, Chile',
        //         'id_type' => 'passport',
        //     ]
        // );
    }
}
