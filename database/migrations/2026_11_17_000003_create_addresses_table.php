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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('label', 50)->nullable();
            $table->string('recipient_name');
            $table->string('phone', 20);
            $table->string('province_id', 20);
            $table->string('province_name', 100);
            $table->string('city_id', 20);
            $table->string('city_name', 100);
            $table->string('district_id', 20)->nullable();
            $table->string('district_name', 100)->nullable();
            $table->string('postal_code', 10);
            $table->text('detail');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->comment('Buku alamat pelanggan');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
