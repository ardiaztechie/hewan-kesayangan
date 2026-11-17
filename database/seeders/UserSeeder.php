<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Akun demo: owner, staf, dan pelanggan. Password semua akun: password (WAJIB diganti di produksi).
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->create([
            'name' => 'Owner Hewan Kesayangan',
            'email' => 'owner@hewankesayangan.test',
            'phone' => '6281200000001',
            'role' => 'owner',
            'is_active' => true,
        ] + ['password' => Hash::make('password')]);
        $user->forceFill(['email_verified_at' => now()])->save();

        $user = User::query()->create([
            'name' => 'Staf Gudang',
            'email' => 'staf@hewankesayangan.test',
            'phone' => '6281200000002',
            'role' => 'staff',
            'is_active' => true,
        ] + ['password' => Hash::make('password')]);
        $user->forceFill(['email_verified_at' => now()])->save();

        $user = User::query()->create([
            'name' => 'Pelanggan Demo',
            'email' => 'pelanggan@contoh.test',
            'phone' => '6281200000003',
            'role' => 'customer',
            'is_active' => true,
        ] + ['password' => Hash::make('password')]);
        $user->forceFill(['email_verified_at' => now()])->save();

        // Keranjang untuk pelanggan demo
        User::query()->where('email', 'pelanggan@contoh.test')->first()->cart()->create();
    }
}
