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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand', 100)->nullable();
            $table->longText('description')->nullable();
            $table->json('specifications')->nullable();
            $table->string('animal_type', 50)->nullable()->comment('Jenis hewan untuk filter');
            $table->unsignedInteger('weight_gram')->comment('Berat aktual per pcs');
            $table->unsignedInteger('length_cm')->default(0);
            $table->unsignedInteger('width_cm')->default(0);
            $table->unsignedInteger('height_cm')->default(0);
            $table->string('video_url')->nullable();
            $table->enum('status', ['active', 'hidden', 'archived'])->default('active')->index();
            $table->boolean('is_featured')->default(false);
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->unsignedInteger('sold_count')->default(0);
            $table->timestamps();
            $table->comment('Produk; produk yang pernah dipesan hanya bisa diarsipkan');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
