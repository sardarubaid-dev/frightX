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
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_id', 50)->unique()->after('id')->nullable();
            $table->string('first_name', 100)->after('user_id')->nullable();
            $table->string('last_name', 100)->after('first_name')->nullable();
            $table->string('office_code', 50)->after('email')->nullable();
            $table->string('office_name', 150)->after('office_code')->nullable();
            $table->string('department_code', 50)->after('office_name')->nullable();
            $table->string('department_name', 150)->after('department_code')->nullable();
            $table->string('branch', 100)->after('department_name')->nullable();
            $table->string('role', 100)->after('branch')->default('Operation');
            $table->enum('status', ['Enable', 'Disable'])->after('role')->default('Enable');
            $table->timestamp('create_date')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_id',
                'first_name',
                'last_name',
                'office_code',
                'office_name',
                'department_code',
                'department_name',
                'branch',
                'role',
                'status',
                'create_date'
            ]);
        });
    }
};

