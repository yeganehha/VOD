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
        Schema::create('crews', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('slug')->unique();
            $table->longText('biography')->nullable();
            $table->longText('biography_en')->nullable();
            $table->date('birthday')->nullable();
            $table->date('death_at')->nullable();
            $table->foreignId('birth_location_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->enum('gender' , \App\Enums\Gender::values())->nullable();
            $table->string('avatar')->nullable();
            $table->foreignId('main_position_id')->constrained('crew_positions')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crews');
    }
};
