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
            'department_id'=> 1,
            'role_id'=> 1,
            'user_id'=> 1,
        ]);
    }
}
