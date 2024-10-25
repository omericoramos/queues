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
        Schema::create('pull_resquests', function (Blueprint $table) {
            $table->id();
            $table->string('github_id');
            $table->string('github_number');
            $table->string('title');
            $table->string('state');
            $table->dateTime('github_created_at');
            $table->dateTime('github_updated_at');
            $table->dateTime('github_closed_at')->nullable();
            $table->datetime('github_merged_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pull_resquests');
    }
};
