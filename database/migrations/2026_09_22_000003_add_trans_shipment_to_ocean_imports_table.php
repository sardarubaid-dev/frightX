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
        Schema::table('ocean_imports', function (Blueprint $table) {
            if (!Schema::hasColumn('ocean_imports', 'trans_shipment_id')) {
                $table->unsignedBigInteger('trans_shipment_id')->nullable()->after('del_id');
            }
            if (!Schema::hasColumn('ocean_imports', 'trans_shipments')) {
                $table->json('trans_shipments')->nullable()->after('trans_shipment_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ocean_imports', function (Blueprint $table) {
            if (Schema::hasColumn('ocean_imports', 'trans_shipments')) {
                $table->dropColumn('trans_shipments');
            }
            if (Schema::hasColumn('ocean_imports', 'trans_shipment_id')) {
                $table->dropColumn('trans_shipment_id');
            }
        });
    }
};
