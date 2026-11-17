<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Isi database dengan data awal: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StoreSettingSeeder::class,
            CatalogSeeder::class,
            VoucherSeeder::class,
            PageSeeder::class,
        ]);
    }
}
