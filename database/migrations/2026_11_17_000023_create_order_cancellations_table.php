<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('order_cancellations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->enum('requested_by', ['customer', 'store', 'system']);
            $table->foreignId('requester_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reason');
            $table->enum('status', ['menunggu_respons', 'disetujui', 'ditolak', 'ditarik'])->default('menunggu_respons');
            $table->dateTime('respond_deadline_at')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('responded_at')->nullable();
            $table->text('reject_note')->nullable();
            $table->string('refund_bank_name', 50)->nullable();
            $table->string('refund_account_number', 50)->nullable();
            $table->string('refund_account_name', 100)->nullable();
            $table->timestamps();
            $table->comment('Permintaan/riwayat pembatalan');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_cancellations');
    }
};
