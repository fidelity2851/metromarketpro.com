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
        // Users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        // Transaction table
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        // Deposit table
        Schema::table('deposits', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('method_id')->references('id')->on('deposit_methods')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        // Withdrawal table
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        // Withdrawal Method table
        Schema::table('withdrawal_methods', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        // Investment table
        Schema::table('investments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        // Support Ticket table
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        // KYC table
        Schema::table('kyc', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        // Referral table
        Schema::table('referrals', function (Blueprint $table) {
            $table->foreign('referral_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('referee_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        // Managements table
        Schema::table('managements', function (Blueprint $table) {
            $table->foreign('manager_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        // Message table
        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('support_ticket_id')->references('id')->on('support_tickets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('foreign_keys');
    // }
};
