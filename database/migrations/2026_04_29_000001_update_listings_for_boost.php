<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Link to active boost
            $table->foreignId('active_boost_id')
                ->nullable()
                ->after('boost_level')
                ->constrained('boosts')
                ->nullableOnDelete();
            
            // Final ranking score (denormalized for fast queries)
            $table->decimal('final_score', 12, 4)
                ->default(0)
                ->after('active_boost_id')
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['active_boost_id']);
            $table->dropColumn('active_boost_id');
            $table->dropIndex(['final_score']);
            $table->dropColumn('final_score');
        });
    }
};
