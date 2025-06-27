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
        Schema::create('daily_consumptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('consumption_date');
            $table->integer('juice_count')->default(0);
            $table->integer('meal_count')->default(0);
            $table->integer('snack_count')->default(0);
            $table->integer('points_used')->default(0);
            $table->timestamps();
            
            $table->unique(['employee_id', 'consumption_date']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_consumptions');
    }
};
