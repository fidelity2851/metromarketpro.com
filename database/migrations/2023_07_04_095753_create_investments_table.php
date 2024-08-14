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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('plan_id');
            $table->string('trx_num');
            $table->decimal('amount');
            $table->decimal('profit');
            $table->decimal('acc_profit')->default(0);
            $table->integer('run_time')->default(0);
            $table->string('rate_type');
            $table->decimal('rate_number');
            $table->string('interest_period');
            $table->string('maturity');
            $table->date('due_date');
            $table->boolean('isActive')->default(true);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
