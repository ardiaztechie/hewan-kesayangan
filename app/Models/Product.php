<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Produk; produk yang pernah dipesan hanya bisa diarsipkan
 */
class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'brand',
        'description',
        'specifications',
        'animal_type',
        'weight_gram',
        'length_cm',
        'width_cm',
        'height_cm',
        'video_url',
        'status',
        'is_featured',
        'rating_avg',
        'rating_count',
        'sold_count',
    ];

    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'status' => ProductStatus::class,
            'is_featured' => 'boolean',
            'rating_avg' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_product_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Berat kirim per pcs (gram) = nilai terbesar antara berat aktual dan berat volumetrik (p x l x t / 6.000 kg).
     */
    public function shippingWeight(): int
    {
        $volumetricGram = (int) ceil($this->length_cm * $this->width_cm * $this->height_cm / 6);

        return max($this->weight_gram, $volumetricGram);
    }
}
