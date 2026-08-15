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
        Schema::table('product_databases', function (Blueprint $table) {
            $table->renameColumn('price', 'selling_price');
            $table->integer('buying_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_databases', function (Blueprint $table) {
            $table->dropColumn('buying_price');
            $table->renameColumn('selling_price', 'price');
        });
    }
};
