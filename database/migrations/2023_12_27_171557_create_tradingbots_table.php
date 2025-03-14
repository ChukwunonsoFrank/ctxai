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
        Schema::create('tradingbots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('amount');
            $table->string('amount_earned');
            $table->string('duration');
            $table->string('duration_start');
            $table->string('duration_end');
            $table->string('strategy_id');
            $table->string('features')->nullable();
            $table->string('profit_limit_exceed')->comment('yes-will exceed no-will not exceed');
            $table->string('account_type')->comment('live or demo');
            $table->string('status')->comment('1-live 0-expired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tradingbots');
    }
};
