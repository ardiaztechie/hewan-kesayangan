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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->foreignId('product_variant_id')->constrained('product_variants')->restrictOnDelete();
            $table->string('product_name');
            $table->string('variant_name', 100);
            $table->string('sku', 64);
            $table->decimal('normal_price', 12, 2);
            $table->decimal('applied_price', 12, 2)->comment('Harga satuan yang dipakai');
            $table->enum('price_type', ['normal', 'wholesale', 'discount']);
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('weight_gram');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('voucher_share', 12, 2)->default(0)->comment('Porsi diskon voucher untuk baris ini (proporsional)');
            $table->unsignedInteger('returned_qty')->default(0)->comment('Jumlah yang sudah direfund');
            $table->timestamps();
            $table->comment('Snapshot item pesanan');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
