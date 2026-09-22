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
        Schema::create('awb_numbers', function (Blueprint $table) {
            $table->id();
            $table->date('created_date')->nullable();
            $table->unsignedBigInteger('carrier_id')->nullable();
            $table->string('prefix', 10)->nullable();
            $table->string('begin_no', 20)->nullable();
            $table->string('end_no', 20)->nullable();
            $table->integer('total_count')->default(0);
            $table->integer('available_count')->default(0);
            $table->integer('reserved_count')->default(0);
            $table->integer('assigned_count')->default(0);
            $table->string('latest_assigned_no', 20)->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();

            $table->foreign('carrier_id')->references('id')->on('trade_partners')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awb_numbers');
    }
};
