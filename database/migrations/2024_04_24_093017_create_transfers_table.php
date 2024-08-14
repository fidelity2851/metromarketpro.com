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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id');
            $table->foreignId('receiver_id');
            $table->string('trx_num');
            $table->integer('amount');
            $table->integer('fee')->default(0);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });


        // Transfer table
        Schema::table('transfers', function (Blueprint $table) {
            $table->foreign('sender_id')->references('id')->on('users')->onUpdate('cascade')
                ->onDelete('cascade');;
            $table->foreign('receiver_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        // Settings table
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('allow_transfer')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
