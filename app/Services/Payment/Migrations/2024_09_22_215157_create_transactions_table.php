<?php

use App\Services\Payment\Enums\PayStatus;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->uuid('call_back_uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('payable');
            $table->string('ip_address')->nullable();
            $table->decimal('price', 15,0);
            $table->string('gateway');
            $table->string('reference_id')->nullable();
            $table->string('reference_id2')->nullable();
            $table->string('card_mask')->nullable();
            $table->string('card_hash')->nullable();
            $table->string('status')->default(PayStatus::INIT->value);
            $table->timestamp('paid_at')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
