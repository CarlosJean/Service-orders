<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            'name' => 'Dashboard',
            'icon' => 'typcn typcn-chart-bar-outline',
            'order' => 1,
        ]);

        DB::table('menus')->insert([
            'name' => 'Personas',
            'icon' => 'typcn typcn-user-add-outline',
            'order' => 2,
        ]);

        DB::table('menus')->insert([
            'name' => 'Compras',
            'icon' => 'typcn typcn-shopping-cart',
            'order' => 3,
        ]);

        DB::table('menus')->insert([
            'name' => 'Inventario',
            'icon' => 'typcn typcn-book',
            'order' => 4,
        ]);

        DB::table('menus')->insert([
            'name' => 'Ordenes',
            'icon' => 'typcn typcn-book',
            'order' => 5,
        ]);

        DB::table('menus')->insert([
            'name' => 'Reportes',
            'icon' => 'typcn typcn-bookmark',
            'order' => 6,
        ]);
    }
}
