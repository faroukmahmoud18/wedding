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
        Schema::table('users', function (Blueprint $table) {
            // Add role column: 'admin', 'vendor', 'customer'
            $table->string('role')->default('customer')->after('email');
            // Add nullable vendor_id foreign key.
            // A user with role 'vendor' should typically have a corresponding vendor_id.
            $table->foreignId('vendor_id')->nullable()->after('role')->constrained('vendors')->onDelete('set null');

            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']); // Explicitly drop index if named by convention or manually
            // $table->dropForeign(['vendor_id']); // Drop foreign key constraint first
            // If your Laravel version/DB setup doesn't automatically name the foreign key constraint like users_vendor_id_foreign,
            // you might need to specify the constraint name or use dropConstrainedForeignId.
            // For simplicity, dropConstrainedForeignId is safer if it was created with constrained().
            if (Schema::hasColumn('users', 'vendor_id')) { // Check if column exists before trying to drop constraint
                 // Attempt to drop by convention first, then be more specific if needed.
                try {
                    $table->dropForeign(['vendor_id']);
                } catch (\Exception $e) {
                    // Log error or handle if specific constraint name is needed.
                    // This is a fallback; ideally, you know the constraint name.
                    // For now, we assume it can be dropped by column name convention.
                }
            }
            $table->dropColumn(['role', 'vendor_id']);
        });
    }
};
