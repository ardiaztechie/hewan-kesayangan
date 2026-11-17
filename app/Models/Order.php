<?php

namespace App\Models;

use App\Enums\CancelledBy;
use App\Enums\OrderStatus;
use App\Enums\OrderSubStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Pesanan dengan status ala Shopee
 */
class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'address_id',
        'voucher_id',
        'status',
        'sub_status',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'shipping_city_id',
        'shipping_district_id',
        'shipping_postal_code',
        'courier_code',
        'courier_service',
        'shipping_etd',
        'shipping_weight_gram',
        'subtotal',
        'wholesale_saving',
        'voucher_discount',
        'shipping_cost',
        'grand_total',
        'customer_note',
        'admin_note',
        'payment_deadline_at',
        'paid_at',
        'ship_deadline_at',
        'processed_at',
        'shipped_at',
        'auto_complete_at',
        'completed_at',
        'cancelled_at',
        'cancelled_by',
        'cancel_reason',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'sub_status' => OrderSubStatus::class,
            'subtotal' => 'decimal:2',
            'wholesale_saving' => 'decimal:2',
            'voucher_discount' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'grand_total' => 'decimal:2',
            'payment_deadline_at' => 'datetime',
            'paid_at' => 'datetime',
            'ship_deadline_at' => 'datetime',
            'processed_at' => 'datetime',
            'shipped_at' => 'datetime',
            'auto_complete_at' => 'datetime',
            'completed_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'cancelled_by' => CancelledBy::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('created_at');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    public function cancellations(): HasMany
    {
        return $this->hasMany(OrderCancellation::class);
    }

    public function returnRequests(): HasMany
    {
        return $this->hasMany(ReturnRequest::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    public function financialEntries(): HasMany
    {
        return $this->hasMany(FinancialEntry::class);
    }

    public function isLateToShip(): bool
    {
        return $this->status === OrderStatus::Dikemas
            && $this->ship_deadline_at !== null
            && now()->gt($this->ship_deadline_at);
    }
}
