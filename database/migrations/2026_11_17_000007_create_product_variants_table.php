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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('sku', 64)->unique();
            $table->string('name', 100)->default('Default');
            $table->decimal('price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable()->comment('Harga coret');
            $table->dateTime('discount_start_at')->nullable();
            $table->dateTime('discount_end_at')->nullable();
            $table->decimal('cost_price', 12, 2)->nullable()->comment('Harga pokok');
            $table->unsignedInteger('stock')->default(0)->comment('Stok fisik');
            $table->unsignedInteger('reserved_stock')->default(0)->comment('Stok tertahan pesanan belum dikirim');
            $table->unsignedInteger('min_stock')->default(0)->comment('Batas peringatan stok menipis');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
