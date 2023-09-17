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
        Schema::create('dbuser.projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('client')->nullable();
            $table->string('company')->nullable();
            $table->date('begin_at');
            $table->date('finish_at');
            $table->softDeletes();
        });

        Schema::create('dbuser.tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->boolean('completed');
            $table->integer('id_project');
            $table->foreign('id_project')->references('id')->on('dbuser.projects')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbuser.tasks');
        Schema::dropIfExists('dbuser.projects');
    }
};
