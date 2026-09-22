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
        if (!Schema::hasTable('container_types')) {
            Schema::create('container_types', function (Blueprint $table) {
                $table->id();
                $table->string('code', 20)->unique();
                $table->string('description', 255);
                $table->string('ams_type_code', 50)->nullable();
                $table->string('type', 50)->nullable();
                $table->decimal('teu', 4, 2)->default(1.00);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                
                $table->index('code');
                $table->index('is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('container_types');
    }
};
