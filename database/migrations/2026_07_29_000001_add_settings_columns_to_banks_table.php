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
        Schema::table('banks', function (Blueprint $table) {
            $table->json('check_sequences')->nullable()->after('invoice_remark');
            $table->json('clear_check_config')->nullable()->after('check_sequences');
            $table->text('display_information')->nullable()->after('clear_check_config');
            $table->json('invoice_settings')->nullable()->after('display_information');
            $table->boolean('is_default_invoice_bank')->default(false)->after('invoice_settings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn([
                'check_sequences',
                'clear_check_config',
                'display_information',
                'invoice_settings',
                'is_default_invoice_bank'
            ]);
        });
    }
};
