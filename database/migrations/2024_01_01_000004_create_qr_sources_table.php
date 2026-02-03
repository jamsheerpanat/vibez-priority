<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('qr_sources', function (Blueprint $table) {
            $table->id();
            $table->string('source_code', 100)->unique();
            $table->string('description', 190)->nullable();
            $table->foreignId('assigned_zone_id')->nullable()->constrained('access_zones')->nullOnDelete();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_sources');
    }
};
