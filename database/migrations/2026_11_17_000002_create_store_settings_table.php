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
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('logo_path')->nullable();
            $table->text('description')->nullable();
            $table->string('whatsapp_number', 20);
            $table->string('shopee_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('origin_city_id', 20)->nullable()->comment('Kota asal untuk API Ongkir');
            $table->string('origin_district_id', 20)->nullable();
            $table->text('origin_address')->nullable();
            $table->json('active_couriers')->nullable()->comment('Kode kurir aktif, mis. ["jne","jnt","sicepat"]');
            $table->string('store_bank_name', 50)->nullable();
            $table->string('store_account_number', 50)->nullable();
            $table->string('store_account_name', 100)->nullable();
            $table->unsignedInteger('payment_timeout_hours')->default(24);
            $table->unsignedInteger('ship_deadline_days')->default(2);
            $table->unsignedInteger('auto_complete_days')->default(7);
            $table->unsignedInteger('cancel_respond_hours')->default(24);
            $table->unsignedInteger('return_window_days')->default(3)->comment('Batas ajukan pengembalian setelah Selesai');
            $table->unsignedInteger('return_respond_hours')->default(48);
            $table->unsignedInteger('return_ship_days')->default(5)->comment('Batas pelanggan mengirim barang retur');
            $table->unsignedInteger('inspection_hours')->default(48);
            $table->unsignedInteger('refund_transfer_hours')->default(48);
            $table->boolean('is_holiday_mode')->default(false);
            $table->date('holiday_until')->nullable();
            $table->string('holiday_message')->nullable();
            $table->timestamps();
            $table->comment('Pengaturan toko (satu baris)');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
