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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->text('reference')->nullable();
            $table->double('total_cost')->nullable();
            $table->double('total_retail')->nullable();
            $table->enum('type', ['Manual', 'Import']);
            $table->datetime('delivery_date')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1-active,0-suspended, 2-delete, 3-part delivery, 4-full delivery, 5-accepted');
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
        Schema::dropIfExists('deliveries');
    }
};
