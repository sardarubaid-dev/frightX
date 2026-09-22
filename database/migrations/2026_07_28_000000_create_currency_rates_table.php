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
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->string('from_currency', 10); // e.g., CAD, USD
            $table->string('to_currency', 10);   // e.g., USD, EUR
            $table->date('as_of_date');
            $table->decimal('rate_internal', 12, 6)->default(0);
            $table->decimal('rate_external', 12, 6)->default(0);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->string('generated_by')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['from_currency', 'to_currency', 'as_of_date']);
            $table->index('as_of_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_rates');
    }
};
