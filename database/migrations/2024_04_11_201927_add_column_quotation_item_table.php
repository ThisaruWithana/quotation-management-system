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
        Schema::table('quotation_item', function (Blueprint $table) {
            $table->double('actual_cost')->default(0);
            $table->double('actual_retail')->default(0);
            $table->double('vat')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation_item', function (Blueprint $table) {
            $table->dropColumn('actual_cost');
            $table->dropColumn('actual_retail');
            $table->dropColumn('vat');
        });
    }
};
