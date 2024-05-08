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
        Schema::table('opf_items', function (Blueprint $table) {
            $table->string('on_order')->default('yes');
            $table->integer('order_qty')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opf_items', function (Blueprint $table) {
            $table->dropColumn('on_order');
            $table->dropColumn('order_qty');
        });
    }
};
