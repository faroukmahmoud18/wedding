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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable(); // Path to logo image
            $table->text('about')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->text('address')->nullable();
            // $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // If vendor is linked to a user
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
