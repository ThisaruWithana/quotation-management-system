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
        Schema::table('quotation', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('item_retail_margin');
            $table->dropColumn('item_cost');
            $table->dropColumn('item_retail');
            $table->double('final_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation', function (Blueprint $table) {
            $table->tinyInteger('status');
            $table->double('item_retail_margin');
            $table->double('item_cost');
            $table->double('item_retail');
            $table->dropColumn('final_price');
        });
    }
};
