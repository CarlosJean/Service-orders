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
        DB::table('users')->insert([
            'name' => 'Jean Holguin',
            'email' => 'holguinjean1@gmail.com',
            'password' => Hash::make('holguinjean1@gmail.com'),
        ]);
        DB::table('users')->insert([
            'name' => 'Jhosua Brown',
            'email' => 'jhosuabrown@gmail.com',
            'password' => Hash::make('jhosuabrown@gmail.com'),
        ]);
        DB::table('users')->insert([
            'name' => 'yhoel',
            'email' => 'yhoel@gmail.com',
            'password' => Hash::make('yhoel@gmail.com'),
        ]);
        DB::table('users')->insert([
            'name' => 'Xavier Vasquez',
            'email' => 'xavier@gmail.com',
            'password' => Hash::make('xavier@gmail.com'),
        ]);
        DB::table('users')->insert([
            'name' => 'Jane Doe',
            'email' => 'janedoe@gmail.com',
            'password' => Hash::make('janedoe@gmail.com'),
        ]);
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => Hash::make('johndoe@gmail.com'),
        ]);
    }
}
