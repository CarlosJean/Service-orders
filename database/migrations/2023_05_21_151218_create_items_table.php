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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
            $table->float('quantity');
            $table->string('reference')->nullable();
            $table->string('measurement_unit');
            $table->string('description')->nullable();
            $table->boolean('active')->default(true);
            $table->double('price');
            $table->unsignedBigInteger('id_category')->nullable();

            $table->foreign('id_category')
            ->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
