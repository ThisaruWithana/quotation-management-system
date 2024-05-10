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
        Schema::create('price_change_log', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->double('old_cost_price')->nullable();
            $table->double('new_cost_price')->nullable();
            $table->double('old_retail_price')->nullable();
            $table->double('new_retail_price')->nullable();
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
        Schema::dropIfExists('price_change_log');
    }
};
