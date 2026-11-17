<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnRequestItem extends Model
{
    protected $fillable = [
        'return_request_id',
        'order_item_id',
        'quantity',
        'accepted_qty',
        'unit_refund',
        'line_amount',
        'is_resellable',
    ];

    protected function casts(): array
    {
        return [
            'unit_refund' => 'decimal:2',
            'line_amount' => 'decimal:2',
            'is_resellable' => 'boolean',
        ];
    }

    public function returnRequest(): BelongsTo
    {
        return $this->belongsTo(ReturnRequest::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}
