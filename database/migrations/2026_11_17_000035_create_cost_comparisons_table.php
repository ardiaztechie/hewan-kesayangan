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
        Schema::create('cost_comparisons', function (Blueprint $table) {
            $table->id();
            $table->string('period', 7)->unique()->comment('YYYY-MM');
            $table->decimal('website_fixed_cost', 12, 2);
            $table->decimal('gateway_fee_total', 12, 2);
            $table->unsignedInteger('transaction_count');
            $table->decimal('net_revenue', 14, 2);
            $table->decimal('marketplace_fee_percent', 5, 2);
            $table->decimal('cost_per_transaction', 12, 2);
            $table->decimal('website_cost_percent', 5, 2);
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->comment('Perbandingan biaya website vs marketplace per bulan');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_comparisons');
    }
};
