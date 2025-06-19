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
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); //senior , med , junior , fresh , ceo , manager
            $table->integer('daily_juice_limit')->default(0);
            $table->integer('daily_meal_limit')->default(0);
            $table->integer('daily_snack_limit')->default(0);
            $table->integer('daily_point_limit')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classifications');
    }
};
