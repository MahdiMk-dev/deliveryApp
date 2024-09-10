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
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('first_name'); // First name of the client
            $table->string('last_name'); // Last name of the client
            $table->string('address'); // Client's address
            $table->string('phone_number')->unique(); // Client's phone number (unique)
            $table->integer('number_of_orders')->default(0); // Number of orders (default to 0)
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
