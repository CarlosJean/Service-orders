<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSubmenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 1,
        ]);
        
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 2,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 3,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 4,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 5,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 6,
        ]);

        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 14,
        ]);
        
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 14,
        ]);
        
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 17,
        ]);
    }
}
