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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('department_id')
            ->foreign('department_id')
            ->references('id')
            ->on('departments');

            $table->integer('role_id')
            ->foreign('role_id')
            ->references('id')
            ->on('roles');

            $table->integer('user_id')
            ->foreign('user_id')
            ->references('id')
            ->on('users');

            $table->string('names');
            $table->string('last_names');
            $table->string('identification');
            
            $table->string('email')
            ->nullable()
            ->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
