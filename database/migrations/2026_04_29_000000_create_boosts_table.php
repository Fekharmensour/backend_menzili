<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boosts', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            
            $table->unsignedBigInteger('coins_spent'); // Raw coins, no normalization
            
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('expires_at');
            $table->timestamp('expired_at')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['status', 'expires_at']);
            $table->index('listing_id');
            $table->index('member_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boosts');
    }
};
