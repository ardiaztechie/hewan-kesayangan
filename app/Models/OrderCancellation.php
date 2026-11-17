<?php

namespace App\Models;

use App\Enums\CancellationStatus;
use App\Enums\CancelledBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Permintaan/riwayat pembatalan
 */
class OrderCancellation extends Model
{
    protected $fillable = [
        'order_id',
        'requested_by',
        'requester_id',
        'reason',
        'status',
        'respond_deadline_at',
        'responded_by',
        'responded_at',
        'reject_note',
        'refund_bank_name',
        'refund_account_number',
        'refund_account_name',
    ];

    protected function casts(): array
    {
        return [
            'requested_by' => CancelledBy::class,
            'status' => CancellationStatus::class,
            'respond_deadline_at' => 'datetime',
            'responded_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function responder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    public function refund(): HasOne
    {
        return $this->hasOne(Refund::class);
    }
}
