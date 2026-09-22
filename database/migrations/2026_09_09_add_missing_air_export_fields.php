<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Add missing Air Export fields
     */
    public function up(): void
    {
        Schema::table('air_exports', function (Blueprint $table) {
            // Missing fields from frontend
            $table->json('route_data')->nullable()->after('internal_remark'); // Connecting flight route
            $table->string('itn_no')->nullable()->after('route_data');
            $table->string('cers_no')->nullable()->after('itn_no');
            $table->string('reference_no')->nullable()->after('cers_no');
            $table->date('awb_date')->nullable()->after('reference_no');
            $table->date('cargo_ready_date')->nullable()->after('awb_date');
            $table->string('issuing_carrier')->nullable()->after('cargo_ready_date');
            $table->string('awb_type')->nullable()->after('issuing_carrier');
            $table->string('dv_carriage')->nullable()->after('awb_type');
            $table->string('dv_customs')->nullable()->after('dv_carriage');
            $table->string('insurance')->nullable()->after('dv_customs');
            $table->string('wt_val')->nullable()->after('insurance');
            $table->string('other_term')->nullable()->after('wt_val');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('air_exports', function (Blueprint $table) {
            $table->dropColumn([
                'route_data', 'itn_no', 'cers_no', 'reference_no',
                'awb_date', 'cargo_ready_date', 'issuing_carrier', 'awb_type',
                'dv_carriage', 'dv_customs', 'insurance', 'wt_val', 'other_term'
            ]);
        });
    }
};
