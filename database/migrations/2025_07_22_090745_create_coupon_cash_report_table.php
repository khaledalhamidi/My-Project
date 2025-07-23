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
        Schema::create('coupon_cash_report', function (Blueprint $table) {
            $table->integer('order_id')->primary();
            $table->timestamp('order_date');
            $table->string('coupon_code')->nullable();
            $table->decimal('sub_total', 12, 2);
            $table->decimal('total', 12, 2);
            $table->decimal('discount_amount', 12, 2);
            $table->decimal('discount_percentage', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_cash_report');
    }
};
