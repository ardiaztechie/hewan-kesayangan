<?php

namespace App\Enums;

enum CancelledBy: string
{
    case Customer = 'customer';
    case Store = 'store';
    case System = 'system';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Customer => 'Pembeli',
            self::Store => 'Penjual',
            self::System => 'Sistem',
        };
    }
}
