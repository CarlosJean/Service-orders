<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            'requestor' => 3,
            'status'  => 'pendiente de asignar tecnico',
            'number'  => '546646',
            'issue'  => 'Problemas con el aire acondicionado del departamento.',
        ]);
    }
}
