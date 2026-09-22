<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gl_codes', function (Blueprint $table) {
            $table->id();
            $table->string('gl_code', 50)->unique();
            $table->string('gl_name_eng', 200)->nullable();
            $table->string('gl_name_local', 200)->nullable();
            $table->string('name_type', 50)->nullable();
            $table->string('sub', 200)->nullable();
            $table->boolean('aire_ap_code')->default(false);
            $table->boolean('detail')->default(false);
            $table->boolean('deposit')->default(false);
            $table->boolean('forgotten')->default(false);
            $table->boolean('transaction')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gl_codes');
    }
};
