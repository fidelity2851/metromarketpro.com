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
            $table->string('company_name')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_tel')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_url')->nullable();
            $table->string('company_address')->nullable();
            $table->string('currency')->nullable();
            $table->string('language')->nullable();
            $table->integer('min_withdrawal')->nullable();
            $table->string('withdrawal_fee_type')->nullable();
            $table->decimal('withdrawal_fee')->nullable();
            $table->string('white_logo')->nullable();
            $table->string('dark_logo')->nullable();
            $table->string('favicon')->nullable();

            $table->boolean('must_verify_email')->default(false);
            $table->boolean('allow_deposit')->default(true);
            $table->boolean('allow_investment')->default(true);
            $table->boolean('allow_withdrawal')->default(true);
            
            $table->boolean('allow_withdraw_deposit')->default(true);

            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_protocol')->nullable();
            $table->string('smtp_user')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('sms_phone')->nullable();
            $table->boolean('sms_active')->default(false);
            $table->boolean('referral_active')->default(false);
            $table->string('referral_pay_type')->nullable();
            $table->decimal('referral_pay_rate')->nullable();
            $table->boolean('pay_referral_once')->default(true);
            $table->boolean('pay_referral_without_deposit')->default(false);
            $table->boolean('kyc_active')->default(true);
            $table->boolean('deposit_without_kyc')->default(true);
            $table->boolean('withdraw_without_kyc')->default(false);
            $table->boolean('status')->default(true);
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
