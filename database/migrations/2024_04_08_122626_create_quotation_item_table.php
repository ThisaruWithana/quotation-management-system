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
        Schema::create('quotation_item', function (Blueprint $table) {
            $table->id();
            $table->integer('quotation_id');
            $table->integer('item_id');
            $table->double('item_cost')->nullable();
            $table->double('retail')->nullable();
            $table->integer('qty');
            $table->double('total_cost')->nullable();
            $table->double('total_retail')->nullable();
            $table->integer('order');
            $table->tinyInteger('display_report')->default(1)->comment('1-yes,0-no');
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
        Schema::dropIfExists('quotation_item');
    }
};
