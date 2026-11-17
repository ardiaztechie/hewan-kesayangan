<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Koreksi refund dengan jejak audit (tanpa menghapus data lama)
 */
class RefundCorrection extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'refund_id',
        'old_total',
        'new_total',
        'difference',
        'reason',
        'proof_path',
        'corrected_by',
    ];

    protected function casts(): array
    {
        return [
            'old_total' => 'decimal:2',
            'new_total' => 'decimal:2',
            'difference' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function refund(): BelongsTo
    {
        return $this->belongsTo(Refund::class);
    }

    public function corrector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'corrected_by');
    }
}
