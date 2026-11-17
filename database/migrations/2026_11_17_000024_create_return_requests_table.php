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
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number', 30)->unique();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->enum('type', ['refund_only', 'return_refund'])->comment('Dana saja / barang & dana');
            $table->enum('reason', ['rusak', 'tidak_sesuai', 'kurang', 'tidak_diterima', 'lainnya']);
            $table->text('description');
            $table->enum('status', ['menunggu_respons', 'menunggu_barang_retur', 'pemeriksaan_barang', 'menunggu_transfer', 'dana_dikembalikan', 'ditolak', 'dibatalkan'])->default('menunggu_respons')->index();
            $table->string('refund_bank_name', 50);
            $table->string('refund_account_number', 50);
            $table->string('refund_account_name', 100);
            $table->dateTime('respond_deadline_at');
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('return_ship_deadline_at')->nullable()->comment('Batas kirim barang retur (5 hari)');
            $table->string('return_courier', 50)->nullable();
            $table->string('return_tracking_number', 50)->nullable();
            $table->decimal('return_shipping_cost', 12, 2)->default(0)->comment('Ongkir retur pelanggan -> toko, DITANGGUNG TOKO');
            $table->string('return_shipping_proof_path')->nullable();
            $table->dateTime('return_shipped_at')->nullable();
            $table->dateTime('item_received_at')->nullable();
            $table->dateTime('inspection_deadline_at')->nullable();
            $table->enum('inspection_result', ['sesuai', 'sesuai_sebagian', 'tidak_sesuai'])->nullable();
            $table->text('inspection_note')->nullable();
            $table->dateTime('inspected_at')->nullable();
            $table->enum('refund_type', ['penuh', 'sebagian'])->nullable();
            $table->decimal('recommended_amount', 12, 2)->default(0)->comment('Nominal rekomendasi sistem');
            $table->decimal('approved_amount', 12, 2)->nullable()->comment('Nominal final (<= rekomendasi)');
            $table->text('partial_reason')->nullable();
            $table->text('reject_reason')->nullable();
            $table->boolean('ship_back_required')->default(false)->comment('Barang dikirim balik ke pelanggan bila tidak sesuai');
            $table->decimal('ship_back_cost', 12, 2)->default(0)->comment('Ongkir kirim balik ke pelanggan, DITANGGUNG PEMBELI');
            $table->string('ship_back_tracking_number', 50)->nullable();
            $table->dateTime('ship_back_at')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->comment('Pengajuan pengembalian (alur final)');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_requests');
    }
};
