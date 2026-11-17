<?php

namespace App\Enums;

enum InspectionResult: string
{
    case Sesuai = 'sesuai';
    case SesuaiSebagian = 'sesuai_sebagian';
    case TidakSesuai = 'tidak_sesuai';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Sesuai => 'Sesuai',
            self::SesuaiSebagian => 'Sesuai Sebagian',
            self::TidakSesuai => 'Tidak Sesuai',
        };
    }
}
