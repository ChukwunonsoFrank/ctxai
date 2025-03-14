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
        Schema::create('timers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('asset_name')->nullable();
            $table->string('asset_display_name')->nullable();
            $table->string('percentage')->nullable();
            $table->string('image_url')->nullable();
            $table->string('action')->nullable();
            $table->bigInteger('timer_starts_at')->nullable();
            $table->bigInteger('timer_ends_at')->nullable();
            $table->boolean('is_timer_running')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timers');
    }
};
