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
        Schema::table('container_types', function (Blueprint $table) {
            if (!Schema::hasColumn('container_types', 'description')) {
                $table->string('description', 255)->after('code')->nullable();
            }
            if (!Schema::hasColumn('container_types', 'ams_type_code')) {
                $table->string('ams_type_code', 50)->after('description')->nullable();
            }
            if (!Schema::hasColumn('container_types', 'type')) {
                $table->string('type', 50)->after('ams_type_code')->nullable();
            }
            if (!Schema::hasColumn('container_types', 'teu')) {
                $table->decimal('teu', 4, 2)->after('type')->default(1.00);
            }
            if (!Schema::hasColumn('container_types', 'is_active')) {
                $table->boolean('is_active')->after('teu')->default(true);
            }
        });
        
        // Update name to description for existing records (after columns are added)
        if (Schema::hasColumn('container_types', 'name') && Schema::hasColumn('container_types', 'description')) {
            \DB::statement('UPDATE container_types SET description = name WHERE description IS NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('container_types', function (Blueprint $table) {
            $table->dropColumn(['description', 'ams_type_code', 'type', 'teu', 'is_active']);
        });
    }
};
