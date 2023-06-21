<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'name' => 'Admin',
            'description' => 'Administrador de sistema.',
        ]);
        DB::table('roles')->insert([
            'name' => 'Supervisor',
            'description' => 'Supervisor de cualquier departamento.',
        ]);
        DB::table('roles')->insert([
            'name' => 'Gerente',
            'description' => 'Gerente de cualquier departamento.',
        ]);
        DB::table('roles')->insert([
            'name' => 'Tecnico',
            'description' => 'Técnico del departamento de mantenimiento.',
        ]);
    }
}
