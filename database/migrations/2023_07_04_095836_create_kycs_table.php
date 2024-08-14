<?php

use App\Enums\KycStatus;
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
        Schema::create('kyc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('verify_method')->nullable();
            $table->string('verify_proof')->nullable();
            $table->string('verify_reason')->nullable();
            $table->string('address_method')->nullable();
            $table->string('address_proof')->nullable();
            $table->string('address_reason')->nullable();
            $table->string('passport')->nullable();
            $table->string('passport_reason')->nullable();
            $table->string('status')->default(KycStatus::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc');
    }
};
