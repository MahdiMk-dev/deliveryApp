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
        Schema::create('shops', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('owner'); // Shop owner's name
            $table->string('name'); // Shop name
            $table->string('phone_number')->unique(); // Shop's phone number (unique)
            $table->integer('number_of_orders')->default(0); // Number of orders (default to 0)
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
