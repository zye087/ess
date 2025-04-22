<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ChildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1
        DB::table('children')->insert(
            [
                'parent_id' => '1',
                'stud_id'=> 'FASDS-K1-A-25-938429',
                'name' => 'Liam Santos',
                'birth_date'=> '2019-05-12',
                'gender'=> 'male',
                'class_name'=> 'Kinder 1A',
                'photo'=> 'photo/5MgK06iEsE.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2
        DB::table('children')->insert(
            [
                'parent_id' => '2',
                'stud_id'=> 'FASDS-K1-B-25-396485',
                'name' => 'Althea Dela Cruz',
                'birth_date'=> '2019-08-23',
                'gender'=> 'female',
                'class_name'=> 'Kinder 1B',
                'photo'=> 'photo/FJ3nxBHQUH.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 3
        DB::table('children')->insert(
            [
                'parent_id' => '3',
                'stud_id'=> 'FASDS-K2-A-25-190078',
                'name' => 'Miguel Reyes',
                'birth_date'=> '2019-11-03',
                'gender'=> 'male',
                'class_name'=> 'Kinder 2A',
                'photo'=> 'photo/G3upHj50OP.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 4
        DB::table('children')->insert(
            [
                'parent_id' => '4',
                'stud_id'=> 'FASDS-K2-B-25-990833',
                'name' => 'Sophia Mendoza',
                'birth_date'=> '2019-04-17',
                'gender'=> 'female',
                'class_name'=> 'Kinder 2B',
                'photo'=> 'photo/HE0MD0mIj5.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 5
        DB::table('children')->insert(
            [
                'parent_id' => '5',
                'stud_id'=> 'FASDS-K1-A-25-396485',
                'name' => 'Ethan Garcia',
                'birth_date'=> '2019-07-29',
                'gender'=> 'male',
                'class_name'=> 'Kinder 1A',
                'photo'=> 'photo/HO5YymkriH.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
