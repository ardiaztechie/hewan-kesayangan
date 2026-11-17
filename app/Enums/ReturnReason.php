<?php

namespace App\Enums;

enum ReturnReason: string
{
    case Rusak = 'rusak';
    case TidakSesuai = 'tidak_sesuai';
    case Kurang = 'kurang';
    case TidakDiterima = 'tidak_diterima';
    case Lainnya = 'lainnya';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Rusak => 'Barang rusak',
            self::TidakSesuai => 'Barang tidak sesuai',
            self::Kurang => 'Barang kurang',
            self::TidakDiterima => 'Barang tidak diterima',
            self::Lainnya => 'Lainnya',
        };
    }
}
