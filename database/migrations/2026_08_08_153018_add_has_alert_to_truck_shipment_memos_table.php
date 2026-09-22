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
        if (!Schema::hasColumn('truck_shipment_memos', 'has_alert')) {
            Schema::table('truck_shipment_memos', function (Blueprint $table) {
                $table->boolean('has_alert')->default(false)->after('content');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('truck_shipment_memos', 'has_alert')) {
            Schema::table('truck_shipment_memos', function (Blueprint $table) {
                $table->dropColumn('has_alert');
            });
        }
    }
};
