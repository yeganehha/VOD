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
        Schema::create('view_histories', function (Blueprint $table) {
            $table->foreignId('profile_id')->constrained('profiles')->cascadeOnDelete();
            $table->uuid('movie_id')->index();
            $table->foreign('movie_id')->references('id')->on('movies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('last_range')->nullable();
            $table->integer('last_seconds')->nullable();
            $table->timestamps();
            $table->primary(['profile_id', 'movie_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_histories');
    }
};
