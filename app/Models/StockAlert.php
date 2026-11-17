<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockAlert extends Model
{
    protected $fillable = [
        'product_variant_id',
        'stock_at_alert',
        'status',
        'sent_at',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
