<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('item_id')
                ->unsigned();                                              
            $table->bigInteger('order_item_id')
                ->unsigned();                
            $table->float('quantity');

            //Foreign keys
            $table->foreign('item_id')
            ->references('id')
            ->on('items');
            $table->foreign('order_item_id')
            ->references('id')
            ->on('order_items')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items_details');
    }
};
