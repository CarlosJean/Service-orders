<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

        /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_technician_services');
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_technician_services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('employee_id')
                ->unsigned();
            $table->bigInteger('service_id')
                ->unsigned();

            //Foreign keys
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees');
            $table->foreign('service_id')
                ->references('id')
                ->on('services');
        });
    }


};
