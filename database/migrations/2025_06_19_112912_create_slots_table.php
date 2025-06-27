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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained('vending_machines')->onDelete('cascade');
            $table->integer('slot_number');
            $table->enum('category', ['juice', 'meal', 'snack']);
            $table->integer('price');
            $table->string('product_name')->nullable();
            $table->timestamps();

            $table->unique(['machine_id' , 'slot_number']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
