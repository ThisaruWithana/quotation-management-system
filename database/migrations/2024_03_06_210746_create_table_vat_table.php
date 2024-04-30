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
        Schema::create('vat', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('value');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->tinyInteger('status')->default(1)->comment('1-active,0-deactive');
            $table->timestamps();

            $table->index(['name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vat');
    }
};
