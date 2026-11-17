<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Perbandingan biaya website vs marketplace per bulan
 */
class CostComparison extends Model
{
    protected $fillable = [
        'period',
        'website_fixed_cost',
        'gateway_fee_total',
        'transaction_count',
        'net_revenue',
        'marketplace_fee_percent',
        'cost_per_transaction',
        'website_cost_percent',
        'note',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'website_fixed_cost' => 'decimal:2',
            'gateway_fee_total' => 'decimal:2',
            'net_revenue' => 'decimal:2',
            'marketplace_fee_percent' => 'decimal:2',
            'cost_per_transaction' => 'decimal:2',
            'website_cost_percent' => 'decimal:2',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
