<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                'name' => 'holguinjean1@gmail.com',
                'email' => 'holguinjean1@gmail.com',
                'password' => Hash::make('holguinjean1@gmail.com'),
            ]
        );
        DB::table('users')->insert(
            [
                'name' => 'jhosuabrown@gmail.com',
                'email' => 'jhosuabrown@gmail.com',
                'password' => Hash::make('jhosuabrown@gmail.com'),
            ]
        );        
        DB::table('users')->insert([
            'name' => 'yoel@gmail.com',
            'email' => 'yoel@gmail.com',
            'password' => Hash::make('yoel@gmail.com'),
        ]);
        DB::table('users')->insert([
            'name' => 'Xavier Vasquez',
            'email' => 'xavier@gmail.com',
            'password' => Hash::make('xavier@gmail.com'),
        ]);
    }
}
