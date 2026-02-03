<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('access_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_card_id')->constrained('wallet_cards')->cascadeOnDelete();
            $table->foreignId('door_id')->constrained('doors')->cascadeOnDelete();
            $table->dateTime('valid_from');
            $table->dateTime('valid_to');
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->timestamps();

            $table->index('valid_to');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_permissions');
    }
};
