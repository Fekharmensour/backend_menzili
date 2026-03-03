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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();

            // Multilingual Title
            $table->string('title');

            // Multilingual Description
            $table->text('description')->nullable();

            // Pricing & Property Info
            $table->decimal('price', 12, 2);
            $table->integer('floor')->nullable();
            $table->decimal('surface', 8, 2)->nullable();

            $table->integer('min_duration')->nullable();
            $table->integer('number_rooms')->nullable();
            $table->integer('number_persons')->nullable();


            $table->boolean('is_active')->default(true);
            $table->boolean('is_ready')->default(true);
            $table->boolean('is_negotiable')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->integer('boost_level')->default(0);

            // Enums
            $table->enum('moderation_status', ['pending', 'approved', 'rejected'])
                ->default('pending');



            // Image
            $table->string('main_image')->nullable();

            // Relations
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('rent_duration_id')->constrained('rent_durations')->cascadeOnDelete();
            $table->foreignId('type_id')->constrained('types')->cascadeOnDelete();
            $table->foreignId('location_id')->constrained('locations')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
