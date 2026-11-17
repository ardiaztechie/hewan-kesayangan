<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Pembayaran via invoice Xendit
 */
class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'external_id',
        'xendit_invoice_id',
        'invoice_url',
        'payment_method',
        'payment_channel',
        'amount',
        'gateway_fee',
        'status',
        'expires_at',
        'paid_at',
        'callback_payload',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'gateway_fee' => 'decimal:2',
            'status' => PaymentStatus::class,
            'expires_at' => 'datetime',
            'paid_at' => 'datetime',
            'callback_payload' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
