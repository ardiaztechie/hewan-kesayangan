<?php

namespace App\Enums;

enum OrderStatus: string
{
    case BelumBayar = 'belum_bayar';
    case Dikemas = 'dikemas';
    case MenungguPembatalan = 'menunggu_pembatalan';
    case Dikirim = 'dikirim';
    case Selesai = 'selesai';
    case Dibatalkan = 'dibatalkan';
    case Pengembalian = 'pengembalian';
    case PengembalianSelesai = 'pengembalian_selesai';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::BelumBayar => 'Belum Bayar',
            self::Dikemas => 'Dikemas',
            self::MenungguPembatalan => 'Menunggu Pembatalan',
            self::Dikirim => 'Dikirim',
            self::Selesai => 'Selesai',
            self::Dibatalkan => 'Dibatalkan',
            self::Pengembalian => 'Pengembalian',
            self::PengembalianSelesai => 'Pengembalian Selesai',
        };
    }
}
