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
        // 1
        DB::table('parent_users')->insert(
            [
                'qr_code' => 'QR-PARENT-393853',
                'name' => 'Maria Santos',
                'email' => 'mariasantos@gmail.com',
                'email_verified_at'=> now(),
                'password' => Hash::make('12345678'),
                'phone_number' => '09123456789',
                'parent_type' => 'mother',
                'address' => '123 Mabini St., Manila',
                'id_type' => 'driver_license',
                'id_photo'=> 'id_photos/HjUQ58MANTJ4DIUeNe2Rwu5A1OGOuvluiz5JWvlY.jpg',
                'profile_picture'=> 'profiles/C0uIpi1Qh8.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2
        DB::table('parent_users')->insert(
            [
                'qr_code' => 'QR-PARENT-522212',
                'name' => 'Joseph Dela Cruz',
                'email' => 'josephdelacruz@gmail.com',
                'email_verified_at'=> now(),
                'password' => Hash::make('12345678'),
                'phone_number' => '09129876543',
                'parent_type' => 'father',
                'address' => '45 Rizal Ave., Quezon City',
                'id_type' => 'driver_license',
                'id_photo'=> 'id_photos/OAqhCMzwQxNRTAm09Yx4Wh9pr5WsvUJMvlUpJj4a.jpg',
                'profile_picture'=> 'profiles/KgOqocSBr9.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 3
        DB::table('parent_users')->insert(
            [
                'qr_code' => 'QR-PARENT-876345',
                'name' => 'Carla Reyes',
                'email' => 'carlareyes@gmail.com',
                'email_verified_at'=> now(),
                'password' => Hash::make('12345678'),
                'phone_number' => '09127654321',
                'parent_type' => 'mother',
                'address' => '78 Bonifacio St., Pasig',
                'id_type' => 'driver_license',
                'id_photo'=> 'id_photos/ToUEfdZfvZ6stYeQiTrppODERgfqUERASINPv8QH.jpg',
                'profile_picture'=> 'profiles/NziYING89x.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 4
        DB::table('parent_users')->insert(
            [
                'qr_code' => 'QR-PARENT-968254',
                'name' => 'Daniel Mendoza',
                'email' => 'danielmendoza@gmail.com',
                'email_verified_at'=> now(),
                'password' => Hash::make('12345678'),
                'phone_number' => '09126789012',
                'parent_type' => 'father',
                'address' => '10 Katipunan Rd., Marikina',
                'id_type' => 'driver_license',
                'id_photo'=> 'id_photos/UPbTL2A0QMyFP1jKiL017lfbXjLlhhUPBGFePbxC.jpg',
                'profile_picture'=> 'profiles/T8by5VWfh5.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 5
        DB::table('parent_users')->insert(
            [
                'qr_code' => 'QR-PARENT-654098',
                'name' => 'Angela Garcia',
                'email' => 'angelagarcia@gmail.com',
                'email_verified_at'=> now(),
                'password' => Hash::make('12345678'),
                'phone_number' => '09124567890',
                'parent_type' => 'mother',
                'address' => '32 Aurora Blvd., Caloocan',
                'id_type' => 'driver_license',
                'id_photo'=> 'id_photos/zHDt6msLFeoCCSSFNR5wRw4NEOUK5woYsxu6bFMz.jpg',
                'profile_picture'=> 'profiles/ukaaFbm1ZZ.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}