<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UsersTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(SubmenusTableSeeder::class);
        $this->call(RolesSubmenusTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(EmployeeServiceTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(OrderItemsSeeder::class);
        $this->call(OrderItemsDetailSeeder::class);
        $this->call(SupplierSeed::class);
    }
}
