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
            $table->string('title');
            $table->string('sub_title');
            $table->integer('min_investment');
            $table->integer('max_investment');
            $table->string('rate_type');
            $table->integer('rate_number');
            $table->string('interest_period');
            $table->string('maturity');
            $table->boolean('payout_buiness_days_only')->default(false);
            $table->boolean('return_capital_amount')->default(true);
            $table->boolean('status')->default(true);
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
