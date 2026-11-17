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
        Schema::create('refund_corrections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refund_id')->constrained('refunds')->cascadeOnDelete();
            $table->decimal('old_total', 12, 2);
            $table->decimal('new_total', 12, 2);
            $table->decimal('difference', 12, 2);
            $table->text('reason');
            $table->string('proof_path')->nullable();
            $table->foreignId('corrected_by')->constrained('users')->restrictOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->comment('Koreksi refund dengan jejak audit (tanpa menghapus data lama)');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_corrections');
    }
};
