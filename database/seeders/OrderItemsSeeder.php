<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('order_items')->insert([
        //     'service_order_id' => 1,
        //     'requestor' => 1,
        //     'status' => 'en espera de entrega'
        // ]);
    }
}
