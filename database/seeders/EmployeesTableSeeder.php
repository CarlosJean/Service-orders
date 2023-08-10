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
            'names' => 'Robert',
            'last_names' => 'Ness',
            'identification' => '40225628558',
            'email' => 'robertness@gmail.com',
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
            'names' => 'Jane',
            'last_names' => 'Doe',
            'identification' => '00154675782',
            'email' => 'janedoe@gmail.com',
            'department_id' => 2,
            'role_id' => 3,
            'user_id' => 5,
        ]);
        DB::table('employees')->insert([
            'names' => 'Yhoel',
            'last_names' => 'Yhoel',
            'identification' => '00154678948',
            'email' => 'yhoel@gmail.com',
            'department_id' => 4,
            'role_id' => 4,
            'user_id' => 3,
        ]);
        DB::table('employees')->insert([
            'names' => 'Stan',
            'last_names' => 'Mason',
            'identification' => '00154678945',
            'email' => 'stanmason@gmail.com',
            'department_id' => 2,
            'role_id' => 6,
            'user_id' => 4,
        ]);
        DB::table('employees')->insert([
            'names' => 'John',
            'last_names' => 'Doe',
            'identification' => '00154674123',
            'email' => 'johndoe@gmail.com',
            'department_id' => 3,
            'role_id' => 7,
            'user_id' => 6,
        ]);
    }
}
