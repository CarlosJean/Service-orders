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
            $table->bigInteger('created_by')
                ->unsigned();
            $table->bigInteger('order_id')
                ->unsigned()
                ->nullable();
            $table->boolean('retrieved');
            $table->float('total');

            //Foreign keys
            $table->foreign('created_by')
                ->references('id')
                ->on('users');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
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
