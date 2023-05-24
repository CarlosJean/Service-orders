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
        Schema::create('quote_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('quote_id')
                ->unsigned();
            $table->bigInteger('item_id')
                ->unsigned()
                ->nullable();
            $table->bigInteger('supplier_id')
                ->unsigned();
            $table->string('item');
            $table->string('reference')->nullable();
            $table->float('quantity');
            $table->float('price');

            //Foreign keys
            $table->foreign('quote_id')
                ->references('id')
                ->on('quotes')
                ->onDelete('cascade');
            $table->foreign('item_id')
                ->references('id')
                ->on('items');
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_details');
    }
};
