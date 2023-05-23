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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('number');
            $table->integer('created_by')
                ->foreign('created_by')
                ->references('id')
                ->on('employees');
            $table->integer('order_id')
                ->nullable()
                ->foreign('order_id')
                ->references('id')
                ->on('orders');
            $table->boolean('retrieved')
                ->nullable();
            $table->float('total');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
