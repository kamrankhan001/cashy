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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('jazzcash_account_title')->nullable();
            $table->string('jazzcash_account_number')->nullable();
            $table->string('easy_asa_account_title')->nullable();
            $table->string('easy_asa_account_number')->nullable();
            $table->string('per_coin_price')->default('0.2');
            $table->string('job_per_coin')->default('20');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
