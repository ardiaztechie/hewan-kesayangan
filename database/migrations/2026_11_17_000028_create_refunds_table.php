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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->string('refund_number', 30)->unique();
            $table->foreignId('order_id')->constrained('orders')->restrictOnDelete();
            $table->enum('source_type', ['cancellation', 'return', 'failed_delivery']);
            $table->string('source_key', 60)->unique()->comment('cancellation:{id} / return:{id} / failed_delivery:{order_id}; mencegah refund ganda');
            $table->foreignId('order_cancellation_id')->nullable()->constrained('order_cancellations')->restrictOnDelete();
            $table->foreignId('return_request_id')->nullable()->constrained('return_requests')->restrictOnDelete();
            $table->decimal('product_amount', 12, 2)->default(0);
            $table->decimal('shipping_amount', 12, 2)->default(0)->comment('Ongkir awal yang dikembalikan');
            $table->decimal('return_shipping_amount', 12, 2)->default(0)->comment('Penggantian ongkir retur (ditanggung toko)');
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['menunggu_transfer', 'dana_dikembalikan'])->default('menunggu_transfer')->index();
            $table->string('dest_bank_name', 50);
            $table->string('dest_account_number', 50);
            $table->string('dest_account_name', 100);
            $table->dateTime('transfer_deadline_at')->comment('2x24 jam sejak status Menunggu Transfer');
            $table->string('store_bank_account', 150)->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('proof_path')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('recorded_at')->nullable();
            $table->timestamps();
            $table->comment('Refund manual; satu sumber hanya boleh satu refund');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
