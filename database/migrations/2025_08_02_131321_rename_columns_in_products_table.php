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
        Schema::table('products', function (Blueprint $table) {
            //
            $table->renameColumn('product_code', 'sku');
            $table->renameColumn('current_quantity', 'quantity');
            $table->renameColumn('location', 'mpn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->renameColumn('sku', 'product_code');
            $table->renameColumn('quantity', 'current_quantity');
            $table->renameColumn('mpn', 'location');
        });
    }
};
