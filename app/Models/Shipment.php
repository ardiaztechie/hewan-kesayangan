<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    protected $fillable = [
        'order_id',
        'courier_code',
        'courier_name',
        'service',
        'tracking_number',
        'shipping_cost',
        'label_printed_at',
        'shipped_at',
        'processed_by',
        'shipped_by',
        'is_failed_delivery',
        'failed_at',
        'failed_note',
    ];

    protected function casts(): array
    {
        return [
            'shipping_cost' => 'decimal:2',
            'label_printed_at' => 'datetime',
            'shipped_at' => 'datetime',
            'is_failed_delivery' => 'boolean',
            'failed_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function shipper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shipped_by');
    }
}
