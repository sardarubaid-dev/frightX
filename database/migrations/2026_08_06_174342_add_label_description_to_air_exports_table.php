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
        Schema::table('air_exports', function (Blueprint $table) {
            $table->text('label_description')->nullable()->after('internal_remark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('air_exports', function (Blueprint $table) {
            $table->dropColumn('label_description');
        });
    }
};
