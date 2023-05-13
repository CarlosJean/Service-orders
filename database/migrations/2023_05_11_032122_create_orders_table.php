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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('requestor')
                ->foreign('requestor')
                ->references('id')
                ->on('users');
            $table->integer('technician')
                ->nullable()
                ->foreign('technician')
                ->references('id')
                ->on('users');
            $table->integer('assigned_by')
                ->nullable()
                ->foreign('assigned_by')
                ->references('id')
                ->on('users');
            // $table->integer('service')
            //     ->nullable();
            $table->string('status');
            $table->string('number')
                ->unique();
            $table->datetime('start_date')
                ->nullable();
            $table->datetime('end_date')
                ->nullable();
            $table->string('issue');
            $table->string('diagnosis')
                ->nullable();
            $table->datetime('assignation_date')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
