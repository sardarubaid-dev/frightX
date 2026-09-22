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
            $table->unsignedBigInteger('hbl_template_id')->nullable()->after('ocean_export_id');
            $table->foreign('hbl_template_id')
                  ->references('id')
                  ->on('hbl_templates')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ocean_export_hbls', function (Blueprint $table) {
            $table->dropForeign(['hbl_template_id']);
            $table->dropColumn('hbl_template_id');
        });
    }
};
