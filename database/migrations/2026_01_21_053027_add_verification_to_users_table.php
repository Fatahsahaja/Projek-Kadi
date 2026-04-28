<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'phone_verified'))
            $table->boolean('phone_verified')->default(false)->after('phone');

        if (!Schema::hasColumn('users', 'email_verified'))
            $table->boolean('email_verified')->default(false)->after('phone_verified');

        if (!Schema::hasColumn('users', 'phone_verification_code'))
            $table->string('phone_verification_code')->nullable()->after('email_verified');

        if (!Schema::hasColumn('users', 'email_verification_code'))
            $table->string('email_verification_code')->nullable()->after('phone_verification_code');

        if (!Schema::hasColumn('users', 'phone_verification_sent_at'))
            $table->timestamp('phone_verification_sent_at')->nullable()->after('email_verification_code');

        if (!Schema::hasColumn('users', 'email_verification_sent_at'))
            $table->timestamp('email_verification_sent_at')->nullable()->after('phone_verification_sent_at');
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
