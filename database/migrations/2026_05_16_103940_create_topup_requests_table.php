<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('topup_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->bigInteger('amount');
        $table->enum('metode', ['qris', 'dana', 'gopay', 'cash']);
        $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
        $table->text('catatan')->nullable();
        $table->timestamp('approved_at')->nullable();
        $table->timestamps();
    });
}
};
