<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nfc_devices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 190);
            $table->string('location', 190)->nullable();
            $table->string('reader_uid', 190)->unique();
            $table->string('api_key_hash', 190);
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nfc_devices');
    }
};
