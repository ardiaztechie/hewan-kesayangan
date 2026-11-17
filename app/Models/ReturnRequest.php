<?php

namespace App\Models;

use App\Enums\InspectionResult;
use App\Enums\RefundType;
use App\Enums\ReturnReason;
use App\Enums\ReturnStatus;
use App\Enums\ReturnType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Pengajuan pengembalian (alur final)
 */
class ReturnRequest extends Model
{
    protected $fillable = [
        'request_number',
        'order_id',
        'user_id',
        'type',
        'reason',
        'description',
        'status',
        'refund_bank_name',
        'refund_account_number',
        'refund_account_name',
        'respond_deadline_at',
        'approved_at',
        'return_ship_deadline_at',
        'return_courier',
        'return_tracking_number',
        'return_shipping_cost',
        'return_shipping_proof_path',
        'return_shipped_at',
        'item_received_at',
        'inspection_deadline_at',
        'inspection_result',
        'inspection_note',
        'inspected_at',
        'refund_type',
        'recommended_amount',
        'approved_amount',
        'partial_reason',
        'reject_reason',
        'ship_back_required',
        'ship_back_cost',
        'ship_back_tracking_number',
        'ship_back_at',
        'handled_by',
    ];

    protected function casts(): array
    {
        return [
            'type' => ReturnType::class,
            'reason' => ReturnReason::class,
            'status' => ReturnStatus::class,
            'respond_deadline_at' => 'datetime',
            'approved_at' => 'datetime',
            'return_ship_deadline_at' => 'datetime',
            'return_shipping_cost' => 'decimal:2',
            'return_shipped_at' => 'datetime',
            'item_received_at' => 'datetime',
            'inspection_deadline_at' => 'datetime',
            'inspection_result' => InspectionResult::class,
            'inspected_at' => 'datetime',
            'refund_type' => RefundType::class,
            'recommended_amount' => 'decimal:2',
            'approved_amount' => 'decimal:2',
            'ship_back_required' => 'boolean',
            'ship_back_cost' => 'decimal:2',
            'ship_back_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReturnRequestItem::class);
    }

    public function evidences(): HasMany
    {
        return $this->hasMany(ReturnEvidence::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(ReturnStatusHistory::class)->orderBy('created_at');
    }

    public function refund(): HasOne
    {
        return $this->hasOne(Refund::class);
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    /**
     * Status yang dianggap masih berjalan; satu pesanan hanya boleh punya satu pengajuan aktif.
     */
    public const ACTIVE_STATUSES = [
        ReturnStatus::MenungguRespons,
        ReturnStatus::MenungguBarangRetur,
        ReturnStatus::PemeriksaanBarang,
        ReturnStatus::MenungguTransfer,
    ];

    public function isActive(): bool
    {
        return in_array($this->status, self::ACTIVE_STATUSES, true);
    }
}
