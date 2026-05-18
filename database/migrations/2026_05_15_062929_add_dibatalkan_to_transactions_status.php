<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('SUKSES', 'SELESAI', 'PENDING', 'DIBATALKAN') DEFAULT 'PENDING'");
}

public function down(): void
{
    DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('SUKSES', 'SELESAI', 'PENDING') DEFAULT 'PENDING'");
}
};
