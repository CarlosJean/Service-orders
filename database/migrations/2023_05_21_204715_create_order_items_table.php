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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('service_order_id')
                ->foreign()
                ->references('service_orders')
                ->on('id')
                ->unique();
            $table->integer('requestor')
                ->foreign()
                ->references('employees')
                ->on('id');
            $table->integer('dispatched_by')
                ->foreign()
                ->references('employees')
                ->on('id')
            ->nullable();
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
