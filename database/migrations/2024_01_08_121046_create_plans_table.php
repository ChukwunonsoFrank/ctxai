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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('risk_type');
            $table->integer('min_amount');
            $table->integer('max_amount');
            $table->string('min_roi_percentage');
            $table->string('max_roi_percentage');
            $table->integer('order');
            $table->string('image');
            $table->string('status');
            $table->string('plan_duration')->comment('integers In hours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
