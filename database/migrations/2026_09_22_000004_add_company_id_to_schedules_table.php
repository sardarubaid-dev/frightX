<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('schedules') && !Schema::hasColumn('schedules', 'company_id')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id')->nullable()->default(1)->after('id')->index();
            });

            DB::table('schedules')->whereNull('company_id')->update(['company_id' => 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('schedules') && Schema::hasColumn('schedules', 'company_id')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->dropColumn('company_id');
            });
        }
    }
};
