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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_show')->default(1);
            $table->string('menu_name');
            $table->integer('parent_menu')->default(0);
            $table->integer('parent_menu_id')->default(0);
            $table->integer('module')->default(0);
            $table->string('base_url');
            $table->string('route');
            $table->integer('active')->default(1);
            $table->integer('serial')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
