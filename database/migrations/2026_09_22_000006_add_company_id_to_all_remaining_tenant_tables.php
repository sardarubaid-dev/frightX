<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Remaining operational and transactional tables to equip with company_id.
     */
    protected array $tables = [
        'ocean_bookings',
        'air_bookings',
        'ocean_import_hbls',
        'ocean_export_hbls',
        'air_import_hbls',
        'air_export_hbls',
        'house_bill_of_ladings',
        'bill_of_ladings',
        'delivery_orders',
        'work_orders',
        'packing_lists',
        'activity_logs',
        'todo_tasks',
        'customer_rates',
        'awb_numbers',
        'hbl_templates',
        'shipment_profit_losses',
        'warehouse_inventory_items',
        'warehouse_automobiles',
        'warehouse_receipt_items',
        'warehouse_receiving_items',
        'aci_filings',
        'afr_filings',
        'ams_filings',
        'isf_filings',
        'ics2_filings',
        'shipments',
        'cargo_trackings',
        'leads',
        'arrival_notices',
        'ocean_import_containers',
        'ocean_export_containers',
        'air_import_containers',
        'truck_shipment_containers',
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
