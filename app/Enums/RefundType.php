<?php

namespace App\Enums;

enum RefundType: string
{
    case Penuh = 'penuh';
    case Sebagian = 'sebagian';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Penuh => 'Pengembalian Penuh',
            self::Sebagian => 'Pengembalian Sebagian',
        };
    }
}
