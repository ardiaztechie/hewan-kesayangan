<?php

namespace Database\Seeders;

use App\Enums\StockMovementType;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Kategori, produk contoh, varian, harga grosir, dan kartu stok awal.
 */
class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::query()->where('role', 'owner')->firstOrFail();

        // Kategori bertingkat
        $categories = [];
        $categories[1] = Category::query()->create([
            'name' => 'Peralatan Ternak Unggas',
            'slug' => 'peralatan-ternak-unggas',
            'sort_order' => 1,
        ] + ['parent_id' => null]);
        $categories[2] = Category::query()->create([
            'name' => 'Tempat Pakan & Minum Unggas',
            'slug' => 'tempat-pakan-minum-unggas',
            'sort_order' => 1,
        ] + ['parent_id' => $categories[1]->id]);
        $categories[3] = Category::query()->create([
            'name' => 'Mesin Penetas Telur',
            'slug' => 'mesin-penetas-telur',
            'sort_order' => 2,
        ] + ['parent_id' => $categories[1]->id]);
        $categories[4] = Category::query()->create([
            'name' => 'Peralatan Ternak Ruminansia',
            'slug' => 'peralatan-ternak-ruminansia',
            'sort_order' => 2,
        ] + ['parent_id' => null]);
        $categories[5] = Category::query()->create([
            'name' => 'Perlengkapan Hewan Kesayangan',
            'slug' => 'perlengkapan-hewan-kesayangan',
            'sort_order' => 3,
        ] + ['parent_id' => null]);

        // Produk contoh (DATA DEMO: ganti dengan data asli toko)
        $products = [];
        $products[1] = $product = Product::query()->create([
            'name' => 'Tempat Minum Ayam Otomatis',
            'slug' => 'tempat-minum-ayam-otomatis',
            'brand' => 'Hewan Kesayangan',
            'animal_type' => 'Ayam',
            'weight_gram' => 450,
            'length_cm' => 25,
            'width_cm' => 25,
            'height_cm' => 30,
            'is_featured' => true,
            'description' => 'Tempat minum ayam otomatis dengan tutup ulir, mudah diisi dan dibersihkan.',
        ] + ['category_id' => $categories[2]->id]);
        $variant = $product->variants()->create([
            'sku' => 'TMA-3L',
            'name' => '3 Liter',
            'price' => 25000,
            'stock' => 120,
            'min_stock' => 20,
        ]);
        $variant->wholesalePrices()->create(['min_qty' => 10, 'price' => 22000]);
        $variant->wholesalePrices()->create(['min_qty' => 50, 'price' => 20000]);
        $variant->stockMovements()->create(['type' => StockMovementType::Restock, 'qty_change' => 120, 'reserved_change' => 0, 'stock_after' => 120, 'reserved_after' => 0, 'note' => 'Stok awal', 'user_id' => $owner->id]);
        $variant = $product->variants()->create([
            'sku' => 'TMA-5L',
            'name' => '5 Liter',
            'price' => 35000,
            'stock' => 80,
            'min_stock' => 15,
        ]);
        $variant->wholesalePrices()->create(['min_qty' => 10, 'price' => 32000]);
        $variant->wholesalePrices()->create(['min_qty' => 50, 'price' => 29000]);
        $variant->stockMovements()->create(['type' => StockMovementType::Restock, 'qty_change' => 80, 'reserved_change' => 0, 'stock_after' => 80, 'reserved_after' => 0, 'note' => 'Stok awal', 'user_id' => $owner->id]);
        $products[2] = $product = Product::query()->create([
            'name' => 'Tempat Pakan Ayam Gantung',
            'slug' => 'tempat-pakan-ayam-gantung',
            'brand' => 'Hewan Kesayangan',
            'animal_type' => 'Ayam',
            'weight_gram' => 600,
            'length_cm' => 30,
            'width_cm' => 30,
            'height_cm' => 35,
            'is_featured' => false,
            'description' => 'Tempat pakan gantung kapasitas 5 kg untuk ayam pedaging dan petelur.',
        ] + ['category_id' => $categories[2]->id]);
        $variant = $product->variants()->create([
            'sku' => 'TPA-5KG',
            'name' => '5 kg',
            'price' => 30000,
            'stock' => 100,
            'min_stock' => 20,
        ]);
        $variant->wholesalePrices()->create(['min_qty' => 10, 'price' => 27000]);
        $variant->wholesalePrices()->create(['min_qty' => 50, 'price' => 25000]);
        $variant->stockMovements()->create(['type' => StockMovementType::Restock, 'qty_change' => 100, 'reserved_change' => 0, 'stock_after' => 100, 'reserved_after' => 0, 'note' => 'Stok awal', 'user_id' => $owner->id]);
        $products[3] = $product = Product::query()->create([
            'name' => 'Mesin Penetas Telur 50 Butir',
            'slug' => 'mesin-penetas-telur-50-butir',
            'brand' => 'Hewan Kesayangan',
            'animal_type' => 'Unggas',
            'weight_gram' => 3500,
            'length_cm' => 50,
            'width_cm' => 40,
            'height_cm' => 30,
            'is_featured' => true,
            'description' => 'Mesin penetas telur kapasitas 50 butir dengan pengatur suhu otomatis.',
        ] + ['category_id' => $categories[3]->id]);
        $variant = $product->variants()->create([
            'sku' => 'MPT-50',
            'name' => 'Default',
            'price' => 650000,
            'stock' => 10,
            'min_stock' => 3,
        ]);
        $variant->stockMovements()->create(['type' => StockMovementType::Restock, 'qty_change' => 10, 'reserved_change' => 0, 'stock_after' => 10, 'reserved_after' => 0, 'note' => 'Stok awal', 'user_id' => $owner->id]);
        $products[4] = $product = Product::query()->create([
            'name' => 'Kandang Kucing Lipat',
            'slug' => 'kandang-kucing-lipat',
            'brand' => 'Hewan Kesayangan',
            'animal_type' => 'Kucing',
            'weight_gram' => 4000,
            'length_cm' => 60,
            'width_cm' => 45,
            'height_cm' => 50,
            'is_featured' => false,
            'description' => 'Kandang kucing lipat berbahan besi, mudah dibawa dan disimpan.',
        ] + ['category_id' => $categories[5]->id]);
        $variant = $product->variants()->create([
            'sku' => 'KKL-M',
            'name' => 'Ukuran M',
            'price' => 250000,
            'stock' => 15,
            'min_stock' => 5,
        ]);
        $variant->stockMovements()->create(['type' => StockMovementType::Restock, 'qty_change' => 15, 'reserved_change' => 0, 'stock_after' => 15, 'reserved_after' => 0, 'note' => 'Stok awal', 'user_id' => $owner->id]);
        $variant = $product->variants()->create([
            'sku' => 'KKL-L',
            'name' => 'Ukuran L',
            'price' => 320000,
            'stock' => 8,
            'min_stock' => 3,
            'discount_price' => 299000,
        ]);
        $variant->stockMovements()->create(['type' => StockMovementType::Restock, 'qty_change' => 8, 'reserved_change' => 0, 'stock_after' => 8, 'reserved_after' => 0, 'note' => 'Stok awal', 'user_id' => $owner->id]);

        // Produk terkait (cross selling)
        $products[1]->relatedProducts()->attach($products[2]->id);
        $products[2]->relatedProducts()->attach($products[1]->id);
    }
}
