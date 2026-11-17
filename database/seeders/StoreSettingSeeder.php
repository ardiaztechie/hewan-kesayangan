<?php

namespace Database\Seeders;

use App\Models\StoreSetting;
use Illuminate\Database\Seeder;

/**
 * Pengaturan toko (satu baris). Batas waktu memakai nilai default di migration.
 */
class StoreSettingSeeder extends Seeder
{
    public function run(): void
    {
        StoreSetting::query()->create([
            'store_name' => 'Hewan Kesayangan Anda',
            'description' => 'Official online store alat peternakan dan perlengkapan hewan kesayangan.',
            'whatsapp_number' => '6281200000000',
            'shopee_url' => null,
            'tiktok_url' => null,
            'active_couriers' => ['jne', 'jnt', 'sicepat', 'anteraja'],
        ]);
    }
}
