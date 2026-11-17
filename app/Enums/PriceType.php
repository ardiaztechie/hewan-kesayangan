<?php

namespace App\Enums;

enum PriceType: string
{
    case Normal = 'normal';
    case Wholesale = 'wholesale';
    case Discount = 'discount';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Normal => 'Harga Normal',
            self::Wholesale => 'Harga Grosir',
            self::Discount => 'Harga Diskon',
        };
    }
}
