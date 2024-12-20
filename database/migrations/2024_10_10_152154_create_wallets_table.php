<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('amount')->default(0);
            $table->integer('daily_earning')->default(0); // Add daily_earning column
            $table->date('last_earning_date')->nullable();
            $table->integer('referral_bonus')->nullable();
            $table->integer('extra_coins')->nullable();
            $table->decimal('pkr', 15, 2)->nullable();
            $table->decimal('convert_to_pkr', 15, 2)->default(0)->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
