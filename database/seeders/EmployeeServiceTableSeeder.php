<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users_technician_services')->insert([
            'employee_id' => 5,
            'service_id' => 1,
        ]);
        DB::table('users_technician_services')->insert([
            'employee_id' => 5,
            'service_id' => 2,
        ]);
    }
}
