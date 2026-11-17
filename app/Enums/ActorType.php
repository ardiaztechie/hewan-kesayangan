<?php

namespace App\Enums;

enum ActorType: string
{
    case Customer = 'customer';
    case Owner = 'owner';
    case Staff = 'staff';
    case System = 'system';
    case Xendit = 'xendit';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Customer => 'Pembeli',
            self::Owner => 'Owner',
            self::Staff => 'Staf',
            self::System => 'Sistem',
            self::Xendit => 'Xendit',
        };
    }
}
