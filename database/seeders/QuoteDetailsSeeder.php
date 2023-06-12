<?php

namespace Database\Seeders;

use App\Models\QuoteDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuoteDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QuoteDetail::factory()
            ->count(3)
            ->create();
    }
}
