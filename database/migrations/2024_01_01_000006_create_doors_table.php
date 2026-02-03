<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('doors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->constrained('access_zones')->cascadeOnDelete();
            $table->foreignId('device_id')->constrained('nfc_devices')->cascadeOnDelete();
            $table->string('door_name', 190);
            $table->enum('status', ['active', 'locked', 'disabled'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doors');
    }
};
