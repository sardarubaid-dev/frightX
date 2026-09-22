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
        Schema::table('ocean_export_hbls', function (Blueprint $table) {
            if (!Schema::hasColumn('ocean_export_hbls', 'pol_id')) {
                $table->unsignedBigInteger('pol_id')->nullable()->after('receipt_id');
            }
            if (!Schema::hasColumn('ocean_export_hbls', 'is_rail')) {
                $table->boolean('is_rail')->default(false)->after('pre_carriage_by');
            }
            if (!Schema::hasColumn('ocean_export_hbls', 'po_no')) {
                $table->string('po_no')->nullable()->after('hbl_remark');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ocean_export_hbls', function (Blueprint $table) {
            $table->dropColumn(['pol_id', 'is_rail', 'po_no']);
        });
    }
};
