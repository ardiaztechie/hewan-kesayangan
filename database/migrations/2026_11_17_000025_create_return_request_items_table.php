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
        Schema::create('return_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_request_id')->constrained('return_requests')->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained('order_items')->restrictOnDelete();
            $table->unsignedInteger('quantity')->comment('Jumlah diajukan');
            $table->unsignedInteger('accepted_qty')->nullable()->comment('Jumlah diterima saat pemeriksaan');
            $table->decimal('unit_refund', 12, 2)->comment('Harga dipakai - porsi voucher per unit');
            $table->decimal('line_amount', 12, 2);
            $table->boolean('is_resellable')->nullable();
            $table->timestamps();
            $table->unique(['return_request_id', 'order_item_id']);
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_request_items');
    }
};
