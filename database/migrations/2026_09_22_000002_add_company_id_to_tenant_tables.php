<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tables to equip with company_id for multi-tenancy.
     */
    protected array $tables = [
        'users',
        'ocean_imports',
        'ocean_exports',
        'air_imports',
        'air_exports',
        'truck_shipments',
        'trade_partners',
        'invoices',
        'payments',
        'quotations',
        'vessel_schedules',
        'warehouse_receipts',
        'warehouse_receivings',
        'warehouse_shippings',
        'gl_codes',
        'billing_codes',
        'banks',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                if (!Schema::hasColumn($tableName, 'company_id')) {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->unsignedBigInteger('company_id')->nullable()->default(1)->after('id')->index();
                    });

                    // Assign existing records to default company ID 1
                    DB::table($tableName)->whereNull('company_id')->update(['company_id' => 1]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'company_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('company_id');
                });
            }
        }
    }
};
