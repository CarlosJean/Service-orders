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
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->string('reference')->nullable();
            $table->float('price');
            $table->float('quantity');
            $table->double('total_price');

            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_details');
    }
};
