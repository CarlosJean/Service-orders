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
            $table->bigInteger('requestor')
                ->unsigned();
            $table->bigInteger('technician')
                ->unsigned()
                ->nullable();
            $table->bigInteger('assigned_by')
                ->unsigned()
                ->nullable();
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
            $table->string('observations')
                ->nullable();

            //Foreign keys
            $table->foreign('requestor')
                ->references('id')
                ->on('users');
            $table->foreign('technician')
                ->references('id')
                ->on('users');
            $table->foreign('assigned_by')
                ->references('id')
                ->on('users');
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
