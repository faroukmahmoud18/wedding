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
        Schema::table('vendors', function (Blueprint $table) {
            // user_id for linking to a User account that owns/manages this vendor profile.
            // This assumes a User can be a Vendor. If a Vendor *is* a User, users.vendor_id is the primary link.
            // If a User can *own* a Vendor entry, this foreignId is useful.
            // Let's assume the User model's vendor_id is the primary link for now,
            // and this user_id on vendors table is for cases where a vendor entity might be managed by a specific user.
            // This can be redundant if users.vendor_id is always set for vendor users.
            // For clarity, let's add it if it's intended that a User *has one* Vendor profile they manage.
            // This was commented out in the original migration, let's make it explicit.
            if (!Schema::hasColumn('vendors', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            }

            $table->boolean('is_approved')->default(false)->after('address');
            $table->boolean('is_suspended')->default(false)->after('is_approved');
            $table->string('city')->nullable()->after('is_suspended');
            $table->string('country')->nullable()->after('city');

            $table->index('is_approved');
            $table->index('is_suspended');
            $table->index('city');
            $table->index('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['is_approved']);
            $table->dropIndex(['is_suspended']);
            $table->dropIndex(['city']);
            $table->dropIndex(['country']);

            // Drop foreign key if it was added by this migration
            // Note: This check is simplistic. If user_id was added by *this* migration, it's safe.
            // If it could exist from elsewhere, more careful checks are needed.
            // Based on plan, we are adding it here if it doesn't exist.
            if (Schema::hasColumn('vendors', 'user_id')) {
                 // Check if the constraint exists before trying to drop it.
                 // The name of the foreign key constraint. Laravel's default is vendors_user_id_foreign.
                $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('vendors');
                $hasUserForeignKey = false;
                foreach ($foreignKeys as $foreignKey) {
                    if ($foreignKey->getForeignColumns() == ['user_id']) {
                        $hasUserForeignKey = true;
                        break;
                    }
                }
                if ($hasUserForeignKey) {
                    $table->dropForeign(['user_id']);
                }
            }

            $columnsToDrop = ['is_approved', 'is_suspended', 'city', 'country'];
            // Conditionally drop user_id only if we are certain this migration added it
            // For now, assuming user_id might exist from create_vendors_table if uncommented there.
            // So, only drop columns defined for sure in this migration's `up` method.
            // If user_id was added by this migration (e.g. if the hasColumn check in up() was false), then add 'user_id' here.
            // To be safe, we will only drop columns explicitly added by this migration's `up()` that are not user_id.
            // If user_id was added here, it should be in $columnsToDrop. For now, it is not.

            $table->dropColumn($columnsToDrop);

            // If user_id was added by this specific migration (because it didn't exist before):
            // This part is tricky without knowing the exact state. If the initial vendor migration
            // did NOT have user_id, and this one added it, then it should be dropped here.
            // If (!Schema::hasColumn('vendors', 'user_id')) { // This check is for *before* this migration ran.
            //    $table->dropColumn('user_id');
            // }
            // Given the `if (!Schema::hasColumn('vendors', 'user_id'))` in up(), user_id is only added if not present.
            // So, we probably shouldn't drop it here unless we are sure it was added by *this* migration.
            // For now, let's assume user_id might have been part of the original table or added by this migration.
            // The safest down for user_id is to only drop it if this migration *unconditionally* added it.
            // Since it's conditional, we'll leave its drop out of this specific migration's down method
            // to avoid errors if it was part of the original `create_vendors_table`.
            // The `users` table migration handles its `vendor_id` foreign key.
        });
    }
};
