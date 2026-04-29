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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();
            $table->text('image_path');


            $table->enum('target_type', ['listing', 'member', 'external']);

            $table->foreignId('listing_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('target_member_id')->nullable()->constrained('members')->nullOnDelete();

            $table->string('external_url')->nullable();


            $table->date('start_date');
            $table->date('end_date');


            $table->enum('status', ['active', 'paused', 'expired'])->default('active');


            $table->foreignId('member_id')->constrained()->cascadeOnDelete();


            $table->integer('coins')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
