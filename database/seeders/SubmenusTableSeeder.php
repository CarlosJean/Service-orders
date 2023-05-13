<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('submenus')->insert([
            'name' => 'Dashboard',
            'order' => 1,
            'menu_id' => null,
            'icon' => 'typcn typcn-chart-bar-outline',
            'URL' => 'orders'
        ]);
        
        //Menú de personas
        DB::table('submenus')->insert([
            'name' => 'Tecnicos',
            'order' => 1,
            'menu_id' => 2
        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Usuarios',
            'order' => 2,
            'menu_id' => 2
        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Roles',
            'order' => 3,
            'menu_id' => 2
        ]);
        
        //Menú de compras
        DB::table('submenus')->insert([
            'name' => 'Órdenes de compra',
            'order' => 1,
            'menu_id' => 3
        ]);

        DB::table('submenus')->insert([
            'name' => 'Cotizaciones',
            'order' => 2,
            'menu_id' => 3
        ]);

        DB::table('submenus')->insert([
            'name' => 'Suplidor',
            'order' => 3,
            'menu_id' => 3
        ]);
        
        //Menú de inventarios
        DB::table('submenus')->insert([
            'name' => 'Artículos',
            'order' => 1,
            'menu_id' => 4
        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Valor de inventario',
            'order' => 2,
            'menu_id' => 4
        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Ajustes de inventario',
            'order' => 3,
            'menu_id' => 4
        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Categorías',
            'order' => 4,
            'menu_id' => 4
        ]);
        
        //Menú de órdenes
        DB::table('submenus')->insert([
            'name' => 'Servicios',
            'order' => 1,
            'menu_id' => 5
        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Departamentos',
            'order' => 2,
            'menu_id' => 5
        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Órdenes de servicios',
            'order' => 3,
            'menu_id' => 5,
            'URL' => 'ordenes-servicio'
        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Gestión de materiales',
            'order' => 4,
            'menu_id' => 5
        ]);
        
        //Menú de reportes
        DB::table('submenus')->insert([
            'name' => 'Reportes',
            'order' => 1,
            'menu_id' => 6
        ]);

        //Menú de administración
        DB::table('submenus')->insert([
            'name' => 'Empleados',
            'order' => 1,
            'menu_id' => 7,
            'url' => 'empleados'
        ]);
    }
}
