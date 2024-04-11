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
        Schema::create('quotation', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->text('description')->nullable();
            $table->string('ref')->nullable();
            $table->double('price')->default(0);
            $table->double('margin')->nullable();
            $table->double('discount')->default(0);
            $table->double('item_cost')->nullable();
            $table->double('item_retail')->nullable();
            $table->double('vat')->nullable();
            $table->double('total_vat')->nullable();
            $table->double('item_retail_margin')->nullable();
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
        Schema::dropIfExists('quotation');
    }
};
