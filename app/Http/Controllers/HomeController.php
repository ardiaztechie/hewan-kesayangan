<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\StoreSetting;
use Illuminate\View\View;

/**
 * Beranda toko (versi awal). Katalog lengkap dibuat di Tahap 3.
 */
class HomeController extends Controller
{
    public function __invoke(): View
    {
        $setting = StoreSetting::query()->first();

        $products = Product::query()
            ->where('status', ProductStatus::Active)
            ->with([
                'variants' => fn ($query) => $query->where('is_active', true),
                'variants.wholesalePrices',
                'images',
            ])
            ->orderByDesc('is_featured')
            ->latest()
            ->get();

        return view('home', compact('setting', 'products'));
    }
}
