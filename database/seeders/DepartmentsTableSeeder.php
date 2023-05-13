<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            'name' => 'Administración de sistema',
            'description' => 'Departamento donde pertenecen los usuarios administradores de sistema.',
        ]);
        DB::table('departments')->insert([
            'name' => 'Mantenimiento',
            'description' => 'Departamento de mantenimiento',
        ]);
        DB::table('departments')->insert([
            'name' => 'Rodeun',
            'description' => 'Departamento de rodeun',
        ]);
    }
}
