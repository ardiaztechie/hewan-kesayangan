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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained('orders')->cascadeOnDelete();
            $table->string('courier_code', 30);
            $table->string('courier_name', 50);
            $table->string('service', 50);
            $table->string('tracking_number', 50)->nullable()->index();
            $table->decimal('shipping_cost', 12, 2);
            $table->dateTime('label_printed_at')->nullable();
            $table->dateTime('shipped_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('shipped_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_failed_delivery')->default(false);
            $table->dateTime('failed_at')->nullable();
            $table->text('failed_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
