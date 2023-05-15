<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            'name' => 'Refrigeración',
            'description' => 'Servicios de refrigeración.',
        ]);
        DB::table('services')->insert([
            'name' => 'Electricidad',
            'description' => 'Servicios de electricidad.',
        ]);
        DB::table('services')->insert([
            'name' => 'Herrería',
            'description' => 'Servicios de herrería.',
        ]);
        DB::table('services')->insert([
            'name' => 'Ebanistería',
            'description' => 'Servicios de ebanistería.',
        ]);
    }
}
