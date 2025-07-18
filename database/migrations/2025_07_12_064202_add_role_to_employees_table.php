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
        Schema::table('employees', function (Blueprint $table) {
            //
            Schema::table('employees', function (Blueprint $table) {
                $table->string('role')->default('employee')->after('password');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            //
            Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        });
    }
};
