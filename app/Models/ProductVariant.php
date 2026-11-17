<?php

namespace App\Models;

use App\Enums\PriceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'name',
        'price',
        'discount_price',
        'discount_start_at',
        'discount_end_at',
        'cost_price',
        'stock',
        'reserved_stock',
        'min_stock',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
            'discount_start_at' => 'datetime',
            'discount_end_at' => 'datetime',
            'cost_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function wholesalePrices(): HasMany
    {
        return $this->hasMany(WholesalePrice::class)->orderBy('min_qty');
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function stockAlerts(): HasMany
    {
        return $this->hasMany(StockAlert::class);
    }

    public function availableStock(): int
    {
        return max(0, $this->stock - $this->reserved_stock);
    }

    public function isLowStock(): bool
    {
        return $this->availableStock() <= $this->min_stock;
    }

    /**
     * Harga coret yang sedang berlaku, atau null bila tidak ada.
     */
    public function activeDiscountPrice(?Carbon $at = null): ?string
    {
        $at ??= now();

        if ($this->discount_price === null) {
            return null;
        }
        if ($this->discount_start_at && $at->lt($this->discount_start_at)) {
            return null;
        }
        if ($this->discount_end_at && $at->gt($this->discount_end_at)) {
            return null;
        }

        return $this->discount_price;
    }

    /**
     * Harga satuan untuk jumlah tertentu: tingkat grosir dengan min_qty terbesar yang <= qty,
     * dibandingkan dengan harga coret aktif, lalu diambil yang termurah.
     *
     * @return array{price: string, type: PriceType}
     */
    public function getUnitPrice(int $qty): array
    {
        $best = ['price' => $this->price, 'type' => PriceType::Normal];

        $tier = $this->wholesalePrices
            ->where('min_qty', '<=', $qty)
            ->sortByDesc('min_qty')
            ->first();
        if ($tier && (float) $tier->price < (float) $best['price']) {
            $best = ['price' => $tier->price, 'type' => PriceType::Wholesale];
        }

        $discount = $this->activeDiscountPrice();
        if ($discount !== null && (float) $discount < (float) $best['price']) {
            $best = ['price' => $discount, 'type' => PriceType::Discount];
        }

        return $best;
    }
}
