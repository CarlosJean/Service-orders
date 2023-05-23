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
        Schema::create('role_submenu', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('role_id')
                ->unsigned();
            $table->bigInteger('submenu_id')
                ->unsigned();

            //Foreign keys            
            $table->foreign('role_id')
                ->foreign('role_id')
                ->references('id')
                ->on('roles');
            $table->foreign('submenu_id')
                ->foreign('submenu_id')
                ->references('id')
                ->on('submenus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_submenu');
    }
};
