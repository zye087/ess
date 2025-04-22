<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1
        DB::table('guardians')->insert(
            [
                'qr_code' => 'QR-GUARDIAN-334477',
                'parent_id'=> '1',
                'name' => 'Rosa Villanueva',
                'phone_number' => '09123411111',
                'address' => '56 P. Guevarra St., San Juan City',
                'id_type' => 'driver_license',
                'id_number'=> 'G1-p1-s1',
                'photo'=> 'guardian/4XxDLWfg1w.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 1
        DB::table('guardians')->insert(
            [
                'qr_code' => 'QR-GUARDIAN-909878',
                'parent_id'=> '1',
                'name' => 'Juan Villanueva',
                'phone_number' => '09123411144',
                'address' => '56 P. Guevarra St., San Juan City',
                'id_type' => 'driver_license',
                'id_number'=> 'G2-p1-s1',
                'photo'=> 'guardian/6HOJ87D4kq.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2
        DB::table('guardians')->insert(
            [
                'qr_code' => 'QR-GUARDIAN-467567',
                'parent_id'=> '2',
                'name' => 'Luz Ramirez',
                'phone_number' => '09123422222',
                'address' => '12 M. H. Del Pilar St., Quezon City',
                'id_type' => 'driver_license',
                'id_number'=> 'G1-p2-s2',
                'photo'=> 'guardian/erZmlAAc2B.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 3
        DB::table('guardians')->insert(
            [
                'qr_code' => 'QR-GUARDIAN-987098',
                'parent_id'=> '3',
                'name' => 'Jenny Alcaraz',
                'phone_number' => '09123433333',
                'address' => '89 Gen. Luna St., Pasig City',
                'id_type' => 'driver_license',
                'id_number'=> 'G1-p3-s3',
                'photo'=> 'guardian/Gjqcl2BAM3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 4
        DB::table('guardians')->insert(
            [
                'qr_code' => 'QR-GUARDIAN-237594',
                'parent_id'=> '4',
                'name' => 'Marites Soriano',
                'phone_number' => '09123444444',
                'address' => '23 E. Rodriguez Ave., Marikina City',
                'id_type' => 'driver_license',
                'id_number'=> 'G1-p4-s4',
                'photo'=> 'guardian/inFinGQIpJ.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 5
        DB::table('guardians')->insert(
            [
                'qr_code' => 'QR-GUARDIAN-227689',
                'parent_id'=> '5',
                'name' => 'Norma Cruz',
                'phone_number' => '09123455555',
                'address' => '77 J.P. Rizal St., Caloocan City',
                'id_type' => 'driver_license',
                'id_number'=> 'G1-p5-s5',
                'photo'=> 'guardian/SnZ6ntOUFj.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
