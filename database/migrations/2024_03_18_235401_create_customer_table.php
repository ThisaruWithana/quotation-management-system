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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('contact_person');
            $table->string('address');
            $table->string('postal_code', 20)->nullable();
            $table->string('tel', 15)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('symbol_group');
            $table->enum('type', ['Prospective', 'Installed'])->default('Prospective');
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
        Schema::dropIfExists('customer');
    }
};
