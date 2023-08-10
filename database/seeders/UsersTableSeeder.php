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
            'name' => 'Robert Ness',
            'email' => 'robertness@gmail.com',
            'password' => Hash::make('robertness@gmail.com'),
        ]);
        DB::table('users')->insert([
            'name' => 'Jhosua Brown',
            'email' => 'jhosuabrown@gmail.com',
            'password' => Hash::make('jhosuabrown@gmail.com'),
        ]);
        DB::table('users')->insert([
            'name' => 'Yhoel',
            'email' => 'yhoel@gmail.com',
            'password' => Hash::make('yhoel@gmail.com'),
        ]);
        DB::table('users')->insert([
            'name' => 'Stan Mason',
            'email' => 'stanmason@gmail.com',
            'password' => Hash::make('stanmason@gmail.com'),
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
