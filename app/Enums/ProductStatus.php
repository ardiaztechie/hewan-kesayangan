<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Active = 'active';
    case Hidden = 'hidden';
    case Archived = 'archived';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Active => 'Aktif',
            self::Hidden => 'Disembunyikan',
            self::Archived => 'Diarsipkan',
        };
    }
}
