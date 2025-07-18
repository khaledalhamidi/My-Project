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
        Schema::create('department_work', function (Blueprint $table) {
            //         $table->id();
            //         $table->timestamps();


            // $table->foreignId('department_id')->constrained()->onDelete('cascade');
            // $table->foreignId('work_id')->constrained()->onDelete('cascade');

            $table->id();
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('work_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_work');
    }
};
