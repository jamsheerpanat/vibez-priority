<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wallet_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('platform', ['apple', 'samsung']);
            $table->string('card_serial', 120)->unique();
            $table->string('device_id_hash', 190)->nullable();
            $table->string('pass_identifier', 190)->nullable();
            $table->enum('status', ['active', 'revoked', 'expired'])->default('active');
            $table->dateTime('issued_at');
            $table->dateTime('revoked_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_cards');
    }
};
