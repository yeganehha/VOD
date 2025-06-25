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
        Schema::create('movie_crews', function (Blueprint $table) {
            $table->uuid('movie_id')->index();
            $table->foreign('movie_id')->references('id')->on('movies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('crew_id')->constrained('crews')->cascadeOnDelete();
            $table->foreignId('position_id')->constrained('crew_positions')->restrictOnDelete();
        });
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->uuid('movie_id')->index();
            $table->foreign('movie_id')->references('id')->on('movies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            $table->foreignId('profile_id')->constrained('profiles')->cascadeOnDelete();
            $table->text('comment');
            $table->string('publish_status');
            $table->boolean('is_spoiler');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('movie_crews');
    }
};
