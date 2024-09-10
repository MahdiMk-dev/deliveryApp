<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
Schema::defaultStringLength(191);


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('first_name'); // First name
            $table->string('last_name'); // Last name
            $table->string('address')->nullable(); // Address (nullable if not required)
            $table->string('phone_number'); 
            $table->string('type'); 
            $table->integer('number_of_orders')->default(0); // Number of orders (default to 0)
            $table->string('username')->unique(); // Phone number (unique constraint)
            $table->string('password'); 

            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
