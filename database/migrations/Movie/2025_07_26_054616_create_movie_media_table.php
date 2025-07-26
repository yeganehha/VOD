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
        Schema::create('movie_files', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('movie_id')->index();
            $table->foreign('movie_id')->references('id')->on('movies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('ratio_type')->nullable();
            $table->string('path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_files');
    }
};
