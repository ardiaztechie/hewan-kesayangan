<?php

namespace App\Enums;

enum UserRole: string
{
    case Customer = 'customer';
    case Owner = 'owner';
    case Staff = 'staff';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Customer => 'Pelanggan',
            self::Owner => 'Owner',
            self::Staff => 'Staf',
        };
    }
}
