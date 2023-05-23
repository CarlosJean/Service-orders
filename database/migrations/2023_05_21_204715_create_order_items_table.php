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
            $table->bigInteger('service_order_id')
                ->unsigned()
                ->unique();
            $table->bigInteger('requestor')
                ->unsigned();
            $table->bigInteger('dispatched_by')
                ->unsigned()
                ->nullable();
            $table->string('status');

            //Foreign keys
            $table->foreign('service_order_id')
                ->references('id')
                ->on('orders');
            $table->foreign('requestor')
                ->references('id')
                ->on('employees');
            $table->foreign('dispatched_by')
                ->references('id')
                ->on('employees');
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
