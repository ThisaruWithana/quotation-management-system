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
        Schema::create('opf', function (Blueprint $table) {
            $table->id();
            $table->integer('quotation_id');
            $table->double('cost')->nullable();
            $table->double('discount')->default(0);
            $table->double('margin')->nullable();
            $table->string('symbol_group')->nullable();
            $table->datetime('installation_date')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1-active,0-deactive, 2-intalled');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();

            $table->index(['quotation_id', 'symbol_group']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opf');
    }
};
