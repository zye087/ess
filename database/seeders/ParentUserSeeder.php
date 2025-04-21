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
        //         'name' => 'Maria Garcia',
        //         'email' => 'emily.garcia1234@gmail.com',
        //         'email_verified_at'=> now(),
        //         'password' => Hash::make('12345678'),
        //         'phone_number' => '09171234567',
        //         'parent_type'   => 'mother',
        //         'address'   => '101 Maple Street, Quezon City',
        //         'id_type' => 'driver_license',
        //         'created_at'=> now(),
        //         'updated_at'=> now(),
        //     ]
        // );
    }
}