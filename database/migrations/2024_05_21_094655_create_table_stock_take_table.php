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
        Schema::create('stock_take', function (Blueprint $table) {
            $table->id();
            $table->string('comment')->nullable();
            $table->double('total_cost')->nullable();
            $table->double('total_cost_diff')->nullable();
            $table->double('total_retail')->nullable();
            $table->double('total_retail_diff')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1-active,0-suspended, 2-delete');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_take');
    }
};
