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
        Schema::create('financial_entries', function (Blueprint $table) {
            $table->id();
            $table->date('entry_date')->index();
            $table->enum('type', ['penjualan', 'ongkir', 'biaya_gateway', 'refund_produk', 'refund_ongkir', 'ongkir_retur', 'koreksi_refund']);
            $table->decimal('amount', 14, 2)->comment('Positif = masuk, negatif = keluar');
            $table->foreignId('order_id')->nullable()->constrained('orders')->restrictOnDelete();
            $table->foreignId('refund_id')->nullable()->constrained('refunds')->restrictOnDelete();
            $table->string('source_key', 80)->unique()->comment('mis. order:12:penjualan; mencegah pencatatan ganda');
            $table->string('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->comment('Buku kas sederhana untuk ringkasan omzet');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_entries');
    }
};
