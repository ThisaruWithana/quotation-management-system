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
        Schema::create('stock_take_items', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_take_id');
            $table->integer('item_id');
            $table->integer('book_stock');
            $table->integer('physical_stock');
            $table->integer('diff');
            $table->double('item_cost')->nullable();
            $table->double('item_retail')->nullable();
            $table->double('total_cost')->nullable();
            $table->double('total_cost_diff')->nullable();
            $table->double('total_retail')->nullable();
            $table->double('total_retail_diff')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1-active,0-deactive');
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
        Schema::dropIfExists('stock_take_items');
    }
};
