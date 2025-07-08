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
        Schema::create('service_meta', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Foreign key to services table
            $table->string('meta_key');
            $table->text('meta_value')->nullable();
            // No timestamps for this table as per the model definition ($public $timestamps = false;)
            // If you need timestamps, uncomment the line below:
            // $table->timestamps();

            $table->unique(['service_id', 'meta_key']); // Ensures a meta key is unique per service
            $table->index('meta_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_meta');
    }
};
