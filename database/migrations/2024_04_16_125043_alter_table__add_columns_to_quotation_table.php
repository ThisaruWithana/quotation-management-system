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
            $table->double('total_cost')->default(0);
            $table->double('total_retail')->default(0);
            $table->double('quotation_vat')->default(0);
            $table->double('quotation_margin')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation', function (Blueprint $table) {
            $table->dropColumn('total_cost');
            $table->dropColumn('total_retail');
            $table->dropColumn('quotation_vat');
            $table->dropColumn('quotation_margin');
        });
    }
};
