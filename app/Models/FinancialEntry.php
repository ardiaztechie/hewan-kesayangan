<?php

namespace App\Models;

use App\Enums\FinancialEntryType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Buku kas sederhana untuk ringkasan omzet
 */
class FinancialEntry extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'entry_date',
        'type',
        'amount',
        'order_id',
        'refund_id',
        'source_key',
        'description',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'entry_date' => 'date',
            'type' => FinancialEntryType::class,
            'amount' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function refund(): BelongsTo
    {
        return $this->belongsTo(Refund::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
