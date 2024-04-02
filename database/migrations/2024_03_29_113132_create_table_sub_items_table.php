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
        Schema::create('sub_items', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id');
            $table->integer('sub_item_id');
            $table->tinyInteger('is_mandatory')->default(0)->comment('1-yes,0-no');
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
        Schema::dropIfExists('sub_items');
    }
};
