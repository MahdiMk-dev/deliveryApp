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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('order_number')->unique(); // Unique order number
            $table->decimal('amount', 10, 2); // Amount for the order (precision: 10 digits, 2 decimal points)
            $table->foreignId('shop_id')->constrained()->onDelete('cascade'); // Foreign key to shops table
            $table->foreignId('driver_id')->nullable()->constrained()->onDelete('set null'); // Foreign key to drivers table
            $table->date('date'); // Date of the order
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Foreign key to clients table
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
