<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Pengaturan toko (satu baris)
 */
class StoreSetting extends Model
{
    protected $fillable = [
        'store_name',
        'logo_path',
        'description',
        'whatsapp_number',
        'shopee_url',
        'tiktok_url',
        'origin_city_id',
        'origin_district_id',
        'origin_address',
        'active_couriers',
        'store_bank_name',
        'store_account_number',
        'store_account_name',
        'payment_timeout_hours',
        'ship_deadline_days',
        'auto_complete_days',
        'cancel_respond_hours',
        'return_window_days',
        'return_respond_hours',
        'return_ship_days',
        'inspection_hours',
        'refund_transfer_hours',
        'is_holiday_mode',
        'holiday_until',
        'holiday_message',
    ];

    protected function casts(): array
    {
        return [
            'active_couriers' => 'array',
            'is_holiday_mode' => 'boolean',
            'holiday_until' => 'date',
        ];
    }

    /**
     * Pengaturan toko hanya satu baris.
     */
    public static function current(): self
    {
        return static::query()->firstOrFail();
    }
}
