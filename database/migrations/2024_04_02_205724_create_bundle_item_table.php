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
        Schema::create('bundle_item', function (Blueprint $table) {
            $table->id();
            $table->integer('bundle_id');
            $table->integer('item_id');
            $table->double('actual_cost')->nullable();
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

            $table->index(['item_id', 'bundle_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundle_item');
    }
};
