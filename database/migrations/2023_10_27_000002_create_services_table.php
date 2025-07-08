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
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade'); // Foreign key to vendors table
            $table->string('category'); // e.g., 'photography', 'catering', 'venue'
            $table->string('title');
            $table->string('slug')->unique(); // URL-friendly version of the title
            $table->text('short_desc')->nullable(); // A brief summary of the service
            $table->longText('long_desc')->nullable(); // Detailed description
            $table->decimal('price_from', 10, 2)->nullable(); // Example: 10 total digits, 2 decimal places
            $table->decimal('price_to', 10, 2)->nullable(); // For price ranges
            $table->string('unit')->nullable(); // e.g., 'per hour', 'per event', 'per item'
            $table->boolean('is_active')->default(true); // To easily enable/disable services
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
