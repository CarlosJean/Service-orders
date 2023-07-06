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
            'URL' => '/'
        ]);
        
        //Menú de personas
        DB::table('submenus')->insert([
            'name' => 'Empleados',
            'order' => 1,
            'menu_id' => 2,
            'url' => 'empleados'
        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Roles',
            'order' => 3,
            'menu_id' => 2,
            'URL' => 'roles'

        ]);
        
        //Menú de compras
        DB::table('submenus')->insert([
            'name' => 'Ordenes de compra',
            'order' => 1,
            'menu_id' => 3,
            'url' => 'ordenes-compra/crear'
        ]);

        DB::table('submenus')->insert([
            'name' => 'Cotizaciones',
            'order' => 2,
            'menu_id' => 3,
            'url' => 'cotizaciones/crear'
        ]);

        DB::table('submenus')->insert([
            'name' => 'Suplidor',
            'order' => 3,
            'menu_id' => 3,
            'URL' => 'suppliers'            
        ]);
        
        //Menú de inventarios
        DB::table('submenus')->insert([
            'name' => 'Artículos',
            'order' => 1,
            'menu_id' => 4,
            'URL' => 'items'

        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Valor de inventario',
            'order' => 2,
            'menu_id' => 4,
            'URL' => 'inventory_value'

        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Categorías',
            'order' => 4,
            'menu_id' => 4,
            'URL' => 'categories'

        ]);
        
        //Menú de Ordenes
        DB::table('submenus')->insert([
            'name' => 'Servicios',
            'order' => 1,
            'menu_id' => 5,
            'URL' => 'services'

        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Departamentos',
            'order' => 2,
            'menu_id' => 5,
            'URL' => 'departments'

        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Ordenes de servicios',
            'order' => 3,
            'menu_id' => 5,
            'URL' => 'ordenes-servicio'
        ]);
        
        DB::table('submenus')->insert([
            'name' => 'Gestión de materiales',
            'order' => 4,
            'menu_id' => 5,
            'url' => 'articulos/despachar',
        ]);
        
        //Menú de reportes
        DB::table('submenus')->insert([
            'name' => 'Reportes',
            'order' => 1,
            'menu_id' => 6,
            'URL' => 'reports'
        ]);
    }
}
