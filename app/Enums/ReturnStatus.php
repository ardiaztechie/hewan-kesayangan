<?php

namespace App\Enums;

enum ReturnStatus: string
{
    case MenungguRespons = 'menunggu_respons';
    case MenungguBarangRetur = 'menunggu_barang_retur';
    case PemeriksaanBarang = 'pemeriksaan_barang';
    case MenungguTransfer = 'menunggu_transfer';
    case DanaDikembalikan = 'dana_dikembalikan';
    case Ditolak = 'ditolak';
    case Dibatalkan = 'dibatalkan';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::MenungguRespons => 'Menunggu Respons',
            self::MenungguBarangRetur => 'Menunggu Barang Retur',
            self::PemeriksaanBarang => 'Pemeriksaan Barang',
            self::MenungguTransfer => 'Disetujui - Menunggu Transfer',
            self::DanaDikembalikan => 'Dana Dikembalikan',
            self::Ditolak => 'Ditolak',
            self::Dibatalkan => 'Dibatalkan',
        };
    }
}
