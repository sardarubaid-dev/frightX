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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('gl_no')->nullable();
            $table->decimal('initial_amount', 12, 2)->default(0);
            $table->string('currency', 10)->default('CAD');
            $table->boolean('revenue_default')->default(false);
            $table->boolean('cost_default')->default(false);
            $table->string('notes_receivable')->nullable();
            $table->string('notes_payable')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('inactive_date')->nullable();
            $table->boolean('check_by_sequence')->default(false);
            $table->boolean('clear_check_by_cycle')->default(false);
            $table->boolean('display_remark')->default(false);
            $table->boolean('invoice_remark')->default(false);
            $table->timestamps();

            // Indexes
            $table->index('bank_name');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
