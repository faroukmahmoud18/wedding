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
        Schema::table('services', function (Blueprint $table) {
            $table->string('location_text')->nullable()->after('unit');
            $table->json('tags')->nullable()->after('location_text'); // Storing tags as JSON array
            $table->string('status')->default('pending_approval')->after('tags'); // e.g., draft, pending_approval, approved, rejected, inactive

            // Modify is_active: it can be derived from status or kept for quick toggling by vendor/admin
            // If is_active is purely derived from status = 'approved', then it might be redundant.
            // For now, let's assume is_active is a manual toggle by vendor/admin,
            // but a service must also be 'approved' to be truly live.
            // No change to is_active column definition itself here, just noting its interplay with 'status'.

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn(['location_text', 'tags', 'status']);
        });
    }
};
