<?php

namespace App\Enums;

enum CancellationStatus: string
{
    case MenungguRespons = 'menunggu_respons';
    case Disetujui = 'disetujui';
    case Ditolak = 'ditolak';
    case Ditarik = 'ditarik';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::MenungguRespons => 'Menunggu Respons',
            self::Disetujui => 'Disetujui',
            self::Ditolak => 'Ditolak',
            self::Ditarik => 'Ditarik Pembeli',
        };
    }
}
