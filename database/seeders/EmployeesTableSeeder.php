<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            'names' => 'Jean Carlos',
            'last_names' => 'Holguin Berihuete',
            'identification' => '40225628558',
            'email' => 'holguinjean1@gmail.com',
            'department_id' => 1,
            'role_id' => 1,
            'user_id' => 1,
        ]);
        DB::table('employees')->insert([
            'names' => 'Jhosua',
            'last_names' => 'Brown',
            'identification' => '00154678949',
            'email' => 'jhosuabrown@gmail.com',
            'department_id' => 2,
            'role_id' => 2,
            'user_id' => 2,
        ]);
        DB::table('employees')->insert([
            'names' => 'Yhoel',
            'last_names' => 'Yhoel',
            'identification' => '00154678948',
            'email' => 'yhoel@gmail.com',
            'department_id' => 4,
            'role_id' => 3,
            'user_id' => 3,
        ]);
        DB::table('employees')->insert([
            'names' => 'Xavier',
            'last_names' => 'Vasquez',
            'identification' => '00154678945',
            'email' => 'xavier@gmail.com',
            'department_id' => 2,
            'role_id' => 3,
            'user_id' => 4,
        ]);
    }
}
