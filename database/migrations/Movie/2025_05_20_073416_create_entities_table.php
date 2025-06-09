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
        Schema::create('entities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('title_en');
            $table->string('slug');
            $table->string('second_title')->nullable();
            $table->string('second_title_en')->nullable();
            $table->string('pre_title')->nullable();
            $table->string('pre_title_en')->nullable();
            $table->string('type')->nullable();
            $table->string('publish_status');
            $table->string('weekly_release_schedule_day')->nullable();
            $table->time('weekly_release_schedule_hour')->nullable();
            $table->longText('about_movie')->nullable();
            $table->longText('about_movie_en')->nullable();
            $table->foreignId('age_range_id')->nullable()->constrained('age_ranges')->nullOnDelete();
            $table->string('main_audio')->nullable();
            $table->boolean('exclusive')->default(false);
            $table->boolean('is_free_movie')->default(false);
            $table->string('logo')->nullable();
            $table->string('movie_logo')->nullable();
            $table->integer('pro_year')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('entity_country', function (Blueprint $table) {
            $table->uuid('entity_id')->index();
            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
        });
        Schema::create('entity_covers', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('entity_id')->index();
            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('ratio_type')->nullable();
            $table->enum('cover_type' , \App\Enums\CoverType::values())->default(\App\Enums\CoverType::Image->value);
        });
        Schema::create('entity_genres', function (Blueprint $table) {
            $table->uuid('entity_id')->index();
            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('genre_id')->constrained('genres')->cascadeOnDelete();
        });
        Schema::create('movies', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('entity_id')->index();
            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('is_high_definition')->default(false);
            $table->foreignId('age_range_id')->nullable()->constrained('age_ranges')->nullOnDelete();
            $table->string('main_audio')->nullable();
            $table->longText('description')->nullable();
            $table->longText('description_en')->nullable();
            $table->boolean('dubbed')->default(false);
            $table->integer('duration')->nullable();
            $table->boolean('exclusive')->default(false);
            $table->boolean('is_multi_audio')->default(false);
            $table->boolean('has_subtitle')->default(false);
            $table->float('imdb_rate')->default(0);
            $table->date('publish_date')->nullable();
            $table->integer('pro_year')->nullable();
            $table->unsignedTinyInteger('season')->default(1);
            $table->unsignedTinyInteger('episode')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entity_country');
        Schema::dropIfExists('entity_covers');
        Schema::dropIfExists('entity_genres');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('entities');
    }
};
