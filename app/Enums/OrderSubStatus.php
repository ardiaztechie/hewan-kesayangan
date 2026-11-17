<?php

namespace App\Enums;

enum OrderSubStatus: string
{
    case PerluDiproses = 'perlu_diproses';
    case TelahDiproses = 'telah_diproses';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::PerluDiproses => 'Perlu Diproses',
            self::TelahDiproses => 'Telah Diproses',
        };
    }
}
