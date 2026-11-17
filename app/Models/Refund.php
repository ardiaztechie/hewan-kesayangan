<?php

namespace App\Models;

use App\Enums\RefundSourceType;
use App\Enums\RefundStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Refund manual; satu sumber hanya boleh satu refund
 */
class Refund extends Model
{
    protected $fillable = [
        'refund_number',
        'order_id',
        'source_type',
        'source_key',
        'order_cancellation_id',
        'return_request_id',
        'product_amount',
        'shipping_amount',
        'return_shipping_amount',
        'total_amount',
        'status',
        'dest_bank_name',
        'dest_account_number',
        'dest_account_name',
        'transfer_deadline_at',
        'store_bank_account',
        'transfer_date',
        'proof_path',
        'recorded_by',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'source_type' => RefundSourceType::class,
            'product_amount' => 'decimal:2',
            'shipping_amount' => 'decimal:2',
            'return_shipping_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'status' => RefundStatus::class,
            'transfer_deadline_at' => 'datetime',
            'transfer_date' => 'date',
            'recorded_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function cancellation(): BelongsTo
    {
        return $this->belongsTo(OrderCancellation::class, 'order_cancellation_id');
    }

    public function returnRequest(): BelongsTo
    {
        return $this->belongsTo(ReturnRequest::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function corrections(): HasMany
    {
        return $this->hasMany(RefundCorrection::class);
    }

    public function financialEntries(): HasMany
    {
        return $this->hasMany(FinancialEntry::class);
    }

    /**
     * Refund yang belum ditransfer melewati batas 2x24 jam.
     */
    public function isOverdue(): bool
    {
        return $this->status === RefundStatus::MenungguTransfer && now()->gt($this->transfer_deadline_at);
    }
}
