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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained('orders')->cascadeOnDelete();
            $table->string('external_id', 100)->unique()->comment('ID unik yang dikirim ke Xendit');
            $table->string('xendit_invoice_id', 100)->nullable()->unique();
            $table->text('invoice_url')->nullable();
            $table->string('payment_method', 30)->nullable()->comment('QRIS / BANK_TRANSFER');
            $table->string('payment_channel', 30)->nullable()->comment('mis. BCA, BRI');
            $table->decimal('amount', 12, 2);
            $table->decimal('gateway_fee', 12, 2)->default(0);
            $table->enum('status', ['pending', 'paid', 'expired', 'failed'])->default('pending');
            $table->dateTime('expires_at');
            $table->dateTime('paid_at')->nullable();
            $table->json('callback_payload')->nullable();
            $table->timestamps();
            $table->comment('Pembayaran via invoice Xendit');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
