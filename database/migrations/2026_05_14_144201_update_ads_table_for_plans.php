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
        Schema::table('ads', function (Blueprint $table) {
            // Remove the arbitrary coins column
            $table->dropColumn('coins');

            // Add foreign key to AdsPlan
            $table->foreignId('ads_plan_id')->nullable()->after('member_id')
                ->constrained('ads_plans')
                ->onDelete('restrict'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropForeign(['ads_plan_id']);
            $table->dropColumn('ads_plan_id');
            
            $table->integer('coins')->nullable()->after('member_id');
        });
    }
};
