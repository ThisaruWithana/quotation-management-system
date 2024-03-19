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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id');
            $table->integer('sub_department_id');
            $table->integer('vat_id');
            $table->integer('location_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('margin_type', ['Floating', 'Fixed '])->default('Floating');
            $table->string('item_size')->default('SNG');
            $table->string('account_no')->nullable();
            $table->integer('min_order_qty')->nullable();
            $table->double('min_order_value')->nullable();
            $table->double('surcharge')->nullable();
            $table->tinyInteger('auto_order')->default(1)->comment('1-active,0-deactive');
            $table->integer('order_days')->nullable();
            $table->timestamp('last_order_date')->nullable();
            $table->integer('delivery_days')->nullable();
            $table->double('cost_price');
            $table->double('retail_price');
            $table->double('margin')->nullable();
            $table->integer('min_stock')->nullable();
            $table->tinyInteger('exclude_from_stock')->default(0)->comment('1-active,0-deactive');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('items');
    }
};
