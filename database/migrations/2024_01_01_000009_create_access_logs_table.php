<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_card_id')->nullable()->constrained('wallet_cards')->nullOnDelete();
            $table->foreignId('door_id')->nullable()->constrained('doors')->nullOnDelete();
            $table->foreignId('device_id')->nullable()->constrained('nfc_devices')->nullOnDelete();
            $table->enum('result', ['granted', 'denied']);
            $table->string('reason', 190)->nullable();
            $table->json('meta')->nullable();
            $table->dateTime('created_at')->useCurrent();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_logs');
    }
};
