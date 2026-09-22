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
        Schema::create('shipment_memo_configs', function (Blueprint $table) {
            $table->id();
            $table->string('module', 50); // ocean-export, ocean-import, air-export, air-import, trucker, misc
            $table->string('section', 20); // master_bl or house_bl
            $table->string('field_name', 100); // oversea_agent, carrier, consignee, etc.
            $table->boolean('is_enabled')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->unique(['module', 'section', 'field_name']);
            $table->index(['module', 'section']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_memo_configs');
    }
};

