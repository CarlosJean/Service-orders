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
            $table->bigInteger('department_id')
                ->unsigned();
            $table->bigInteger('role_id')
                ->unsigned();
            $table->bigInteger('user_id')
                ->unsigned()
                ->nullable();
            $table->string('names');
            $table->string('last_names');
            $table->string('identification')->unique();
            $table->string('email')
                ->nullable()
                ->unique();

            //Foreign keys
            $table->foreign('department_id')
                ->references('id')->on('departments');
            $table->foreign('role_id')
                ->references('id')->on('roles');
            $table->foreign('user_id')
                ->references('id')->on('users');
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
