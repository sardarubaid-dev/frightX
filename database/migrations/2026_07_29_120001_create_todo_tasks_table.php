<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('todo_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('module', 50); // ocean-import, ocean-export, air-import, air-export, trucking
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->json('config')->nullable(); // Workflow configuration (conditions, actions, timing)
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('module');
            $table->index(['module', 'order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('todo_tasks');
    }
};
