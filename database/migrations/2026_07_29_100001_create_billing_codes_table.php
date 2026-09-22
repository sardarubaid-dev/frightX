<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('billing_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name_eng', 200)->nullable();
            $table->string('name_local', 200)->nullable();
            $table->string('revenue', 50)->nullable();
            $table->string('cost', 50)->nullable();
            $table->string('credit', 50)->nullable();
            $table->string('debit', 50)->nullable();
            $table->string('department', 50)->nullable();
            $table->boolean('ar')->default(false);
            $table->boolean('ap')->default(false);
            $table->boolean('dc')->default(false);
            $table->boolean('ba')->default(false);
            $table->boolean('payroll')->default(false);
            $table->boolean('ohw')->default(false);
            $table->boolean('oim')->default(false);
            $table->boolean('aim')->default(false);
            $table->boolean('aie')->default(false);
            $table->boolean('oem')->default(false);
            $table->boolean('oew')->default(false);
            $table->boolean('aerial')->default(false);
            $table->boolean('alog')->default(false);
            $table->boolean('tk')->default(false);
            $table->boolean('misc')->default(false);
            $table->boolean('wh')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_codes');
    }
};
