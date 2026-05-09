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
        Schema::create('package_coins', function (Blueprint $table) {
            $table->id();
            $table->integer('coins')->comment('Number of coins in package');
            $table->decimal('price', 10, 2)->comment('Price in DZD');
            $table->date('date_end_offer')->nullable()->comment('When offer expires');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_coins');
    }
};
