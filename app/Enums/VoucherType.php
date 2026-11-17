<?php

namespace App\Enums;

enum VoucherType: string
{
    case Fixed = 'fixed';
    case Percent = 'percent';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Fixed => 'Potongan Nominal',
            self::Percent => 'Potongan Persen',
        };
    }
}
