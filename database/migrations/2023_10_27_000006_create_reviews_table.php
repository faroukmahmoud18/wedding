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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Link to the reviewed service
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Link to the user who wrote the review
            $table->unsignedTinyInteger('rating'); // Rating, e.g., 1-5. UnsignedTinyInteger is 0-255.
            $table->text('comment')->nullable(); // The review text
            $table->boolean('approved')->default(false); // Whether the review is approved and visible
            $table->timestamps(); // created_at and updated_at

            $table->index('approved');
            $table->index(['service_id', 'user_id']); // A user might review a service only once
            // If a user can review multiple times, remove the unique constraint idea from the model or here.
            // For now, just an index. A unique constraint would be:
            // $table->unique(['service_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
