<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('PENDING','SIAP','SELESAI','SUKSES','DIBATALKAN') DEFAULT 'PENDING'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('PENDING','SUKSES','SELESAI','DIBATALKAN') DEFAULT 'PENDING'");
    }
};
