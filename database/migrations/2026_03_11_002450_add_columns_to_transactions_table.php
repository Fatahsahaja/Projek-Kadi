<?php
// Nama file: xxxx_xx_xx_add_columns_to_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('confirmation_token')->unique()->nullable()->after('status');
            $table->timestamp('confirmed_at')->nullable()->after('confirmation_token');
            $table->text('notes')->nullable()->after('confirmed_at');
        });

        // Fix status jadi konsisten KAPITAL semua
        // (sudah benar di migration awal, tapi pastikan enum-nya ini)
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['confirmation_token', 'confirmed_at', 'notes']);
        });
    }
};
