<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'email_verified_at']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->char('uuid', 36)->unique()->after('id');
            $table->string('full_name', 190)->after('uuid');
            $table->string('email', 190)->nullable()->change();
            $table->string('mobile', 50)->nullable()->after('email');
            $table->enum('user_type', ['visitor', 'employee'])->default('visitor')->after('mobile');
            $table->string('company_name', 190)->nullable()->after('user_type');
            $table->enum('status', ['active', 'suspended', 'revoked'])->default('active')->after('company_name');
            $table->string('registered_via_qr', 100)->nullable()->after('status');
            $table->dropColumn('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'full_name', 'mobile', 'user_type', 'company_name', 'status', 'registered_via_qr']);
            $table->string('name')->after('id');
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->string('password')->after('email_verified_at');
        });
    }
};
