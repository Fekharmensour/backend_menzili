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
        Schema::table('members', function (Blueprint $table) {
            $table->enum('identity_status', ['unsubmitted', 'pending', 'approved', 'rejected'])->default('unsubmitted')->after('card_id_back_path');
            $table->text('identity_rejection_reason')->nullable()->after('identity_status');
            $table->enum('agent_status', ['unsubmitted', 'pending', 'approved', 'rejected'])->default('unsubmitted')->after('document_path');
            $table->text('agent_rejection_reason')->nullable()->after('agent_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'identity_status',
                'identity_rejection_reason',
                'agent_status',
                'agent_rejection_reason'
            ]);
        });
    }
};
