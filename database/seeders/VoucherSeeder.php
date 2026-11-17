<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;

/**
 * Voucher contoh khusus website.
 */
class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        Voucher::query()->create([
            'code' => 'WEBSITE10',
            'name' => 'Diskon 10% belanja di website',
            'type' => 'percent',
            'value' => 10,
            'max_discount' => 20000,
            'min_purchase' => 100000,
            'quota' => 100,
            'per_user_limit' => 1,
            'new_customer_only' => false,
            'start_at' => '2026-11-17 00:00:00',
            'end_at' => '2027-02-28 23:59:59',
        ]);
    }
}
