<?php

namespace App\Models;

use App\Enums\PriceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Snapshot item pesanan
 */
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'product_name',
        'variant_name',
        'sku',
        'normal_price',
        'applied_price',
        'price_type',
        'quantity',
        'weight_gram',
        'subtotal',
        'voucher_share',
        'returned_qty',
    ];

    protected function casts(): array
    {
        return [
            'normal_price' => 'decimal:2',
            'applied_price' => 'decimal:2',
            'price_type' => PriceType::class,
            'subtotal' => 'decimal:2',
            'voucher_share' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function returnItems(): HasMany
    {
        return $this->hasMany(ReturnRequestItem::class);
    }

    /**
     * Jumlah yang masih bisa diajukan pengembalian.
     */
    public function refundableQty(): int
    {
        return $this->quantity - $this->returned_qty;
    }

    /**
     * Nilai refund per unit = harga yang dipakai - porsi voucher per unit.
     */
    public function unitRefund(): float
    {
        return round((float) $this->applied_price - ((float) $this->voucher_share / $this->quantity), 2);
    }
}
