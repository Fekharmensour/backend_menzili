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
        Schema::table('listings', function (Blueprint $table) {
            $table->index('member_id');
            $table->index('type_id');
            $table->index('rent_duration_id');
            $table->index('location_id');
            $table->index('price');
            $table->index('boost_level');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropIndex(['member_id']);
            $table->dropIndex(['type_id']);
            $table->dropIndex(['rent_duration_id']);
            $table->dropIndex(['location_id']);
            $table->dropIndex(['price']);
            $table->dropIndex(['boost_level']);
            $table->dropIndex(['is_active']);
        });
    }
};
