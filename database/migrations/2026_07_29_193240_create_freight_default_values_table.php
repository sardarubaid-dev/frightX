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
        Schema::create('freight_default_values', function (Blueprint $table) {
            $table->id();
            $table->string('office_type', 10)->default('Office'); // Office or NEO
            $table->string('module', 50); // ocean-import, ocean-export, air-import, air-export
            $table->string('section', 20); // invoice, ap, dc_note
            $table->string('ship_mode', 100)->nullable(); // Only for ocean modules
            $table->string('freight_code', 100)->nullable();
            $table->string('pc', 50)->nullable(); // Prepaid/Collect
            $table->string('type', 100)->nullable();
            $table->string('unit', 50)->nullable();
            $table->string('currency', 10)->nullable();
            $table->decimal('volume', 10, 2)->nullable();
            $table->decimal('rate', 10, 2)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('agent_amount', 10, 2)->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['office_type', 'module', 'section']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freight_default_values');
    }
};
