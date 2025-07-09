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
            // 1. Rename is_active to is_live and change default
            if (Schema::hasColumn('services', 'is_active')) {
                $table->renameColumn('is_active', 'is_live');
            }
            // Ensure is_live column exists if renameColumn did not run (e.g. fresh install)
            // and set its default after renaming or if it's a new addition.
            if (!Schema::hasColumn('services', 'is_live')) {
                 $table->boolean('is_live')->default(false)->after('status');
            } else {
                // Change existing column's default if necessary, though default usually applies on insert.
                // For existing rows, an update query would be needed if their current true value is problematic.
                // $table->boolean('is_live')->default(false)->change(); // This changes the column definition
            }


            // 2. Rename long_desc to description
            if (Schema::hasColumn('services', 'long_desc') && !Schema::hasColumn('services', 'description')) {
                $table->renameColumn('long_desc', 'description');
            } elseif (!Schema::hasColumn('services', 'description')) {
                $table->longText('description')->nullable()->after('short_desc');
            }


            // 3. Rename price_from to price
            if (Schema::hasColumn('services', 'price_from') && !Schema::hasColumn('services', 'price')) {
                $table->renameColumn('price_from', 'price');
            } elseif (!Schema::hasColumn('services', 'price')) {
                $table->decimal('price', 10, 2)->nullable()->after('description');
            }


            // 4. Drop price_to
            if (Schema::hasColumn('services', 'price_to')) {
                $table->dropColumn('price_to');
            }

            // 5. Rename unit to price_unit
            if (Schema::hasColumn('services', 'unit') && !Schema::hasColumn('services', 'price_unit')) {
                $table->renameColumn('unit', 'price_unit');
            } elseif (!Schema::hasColumn('services', 'price_unit')) {
                 $table->string('price_unit')->nullable()->after('price');
            }

            // 6. Add category_id and drop old category column
            // Ensure categories table exists or handle appropriately
            if (!Schema::hasColumn('services', 'category_id')) {
                // Add it after vendor_id. If vendor_id is not present, this will fail.
                // Assuming vendor_id is always there from the first migration.
                $table->foreignId('category_id')->nullable()->after('vendor_id')->constrained('categories')->nullOnDelete();
            }
            if (Schema::hasColumn('services', 'category')) {
                $table->dropColumn('category');
            }


            // 7. Add featured_image_path
            if (!Schema::hasColumn('services', 'featured_image_path')) {
                $table->string('featured_image_path')->nullable()->after('tags');
            }

            // 8. Add rejection_reason
            if (!Schema::hasColumn('services', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('status');
            }

            // Update existing is_live records if necessary based on status
            // This is an operation, not a schema change, typically done via seeder or separate command
            // For now, ensuring the column default is false. If 'is_active' was true, and now 'is_live'
            // should be false unless 'status' is 'approved', an update query would be needed.
            // DB::table('services')->where('status', '!=', 'approved')->update(['is_live' => false]);
            // DB::table('services')->where('status', 'approved')->update(['is_live' => true]); // Or handle based on previous is_active
        });

        // Set default for is_live on existing column after rename, if it was not set correctly
        // This is tricky with migrations as `change()` needs doctrine/dbal
        // It's often easier to handle default values for existing rows with a separate update statement
        // or ensure the application logic correctly interprets the old `is_active` values as `is_live`.
        // For now, the model sets default to false for new entries.
        // If `is_active` was `true` by default, and `is_live` should be `false` by default,
        // this needs careful handling for existing data.
        // The default(false) in `boolean('is_live')->default(false)` will apply for new rows.
        // For existing rows, their current `is_active` value will be carried over to `is_live`.
        // A manual data migration might be needed if the default logic must change for existing rows.
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'is_live')) {
                 // If the column was just renamed from is_active (which defaulted to true),
                 // and we want is_live to default to false for *new* records,
                 // the default(false) on addColumn is enough.
                 // If we need to change the default constraint on an *existing* column:
                 // $table->boolean('is_live')->default(false)->change(); // Requires doctrine/dbal
                 // For existing rows, if status is not 'approved', set is_live to false.
                 \Illuminate\Support\Facades\DB::statement("UPDATE services SET is_live = 0 WHERE status != 'approved'");
                 \Illuminate\Support\Facades\DB::statement("UPDATE services SET is_live = 1 WHERE status = 'approved' AND is_live IS NULL"); // If is_live was newly added and is_active was true
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'is_live') && !Schema::hasColumn('services', 'is_active')) {
                $table->renameColumn('is_live', 'is_active');
                // Potentially change default back if it was different
                // $table->boolean('is_active')->default(true)->change();
            } elseif (!Schema::hasColumn('services', 'is_active') && !Schema::hasColumn('services', 'is_live')) {
                // If neither exists (e.g. if up() failed midway or columns were different)
                $table->boolean('is_active')->default(true);
            }


            if (Schema::hasColumn('services', 'description') && !Schema::hasColumn('services', 'long_desc')) {
                $table->renameColumn('description', 'long_desc');
            } elseif(!Schema::hasColumn('services', 'long_desc')) {
                $table->longText('long_desc')->nullable();
            }


            if (Schema::hasColumn('services', 'price') && !Schema::hasColumn('services', 'price_from')) {
                $table->renameColumn('price', 'price_from');
            } elseif(!Schema::hasColumn('services', 'price_from')) {
                 $table->decimal('price_from', 10, 2)->nullable();
            }


            if (!Schema::hasColumn('services', 'price_to')) {
                $table->decimal('price_to', 10, 2)->nullable()->after('price_from'); // or after 'price' if rename happened
            }

            if (Schema::hasColumn('services', 'price_unit') && !Schema::hasColumn('services', 'unit')) {
                $table->renameColumn('price_unit', 'unit');
            } elseif(!Schema::hasColumn('services', 'unit')) {
                $table->string('unit')->nullable();
            }

            if (Schema::hasColumn('services', 'category_id')) {
                 // Need to be careful with foreign key constraints if table was dropped and recreated
                if (DB::getDriverName() !== 'sqlite') { // SQLite doesn't support dropping foreign keys easily by name like this
                    $table->dropForeign(['category_id']);
                }
                $table->dropColumn('category_id');
            }
            if (!Schema::hasColumn('services', 'category')) {
                $table->string('category')->after('vendor_id');
            }


            if (Schema::hasColumn('services', 'featured_image_path')) {
                $table->dropColumn('featured_image_path');
            }
            if (Schema::hasColumn('services', 'rejection_reason')) {
                $table->dropColumn('rejection_reason');
            }
        });
    }
};
