<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('phone_verified')->default(false)->after('phone');
            $table->boolean('email_verified')->default(false)->after('email');
            $table->string('phone_verification_code')->nullable()->after('phone_verified');
            $table->string('email_verification_code')->nullable()->after('email_verified');
            $table->timestamp('phone_verification_sent_at')->nullable();
            $table->timestamp('email_verification_sent_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone_verified',
                'email_verified',
                'phone_verification_code',
                'email_verification_code',
                'phone_verification_sent_at',
                'email_verification_sent_at'
            ]);
        });
    }
};