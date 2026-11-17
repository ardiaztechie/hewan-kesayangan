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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->nullOnDelete();
            $table->enum('status', ['belum_bayar', 'dikemas', 'menunggu_pembatalan', 'dikirim', 'selesai', 'dibatalkan', 'pengembalian', 'pengembalian_selesai'])->default('belum_bayar');
            $table->enum('sub_status', ['perlu_diproses', 'telah_diproses'])->nullable();
            $table->string('recipient_name');
            $table->string('recipient_phone', 20);
            $table->text('shipping_address')->comment('Snapshot alamat saat checkout');
            $table->string('shipping_city_id', 20);
            $table->string('shipping_district_id', 20)->nullable();
            $table->string('shipping_postal_code', 10);
            $table->string('courier_code', 30);
            $table->string('courier_service', 50);
            $table->string('shipping_etd', 30)->nullable();
            $table->unsignedInteger('shipping_weight_gram')->comment('Maks(berat aktual, volumetrik)');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('wholesale_saving', 12, 2)->default(0);
            $table->decimal('voucher_discount', 12, 2)->default(0);
            $table->decimal('shipping_cost', 12, 2);
            $table->decimal('grand_total', 12, 2);
            $table->text('customer_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->dateTime('payment_deadline_at');
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('ship_deadline_at')->nullable()->index();
            $table->dateTime('processed_at')->nullable();
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('auto_complete_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->enum('cancelled_by', ['customer', 'store', 'system'])->nullable();
            $table->string('cancel_reason')->nullable();
            $table->timestamps();
            $table->index(['status', 'sub_status']);
            $table->comment('Pesanan dengan status ala Shopee');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
