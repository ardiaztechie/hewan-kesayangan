<?php

namespace App\Enums;

enum StockMovementType: string
{
    case Reserve = 'reserve';
    case Release = 'release';
    case SaleOut = 'sale_out';
    case ReturnIn = 'return_in';
    case Restock = 'restock';
    case Adjustment = 'adjustment';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Reserve => 'Reservasi',
            self::Release => 'Lepas Reservasi',
            self::SaleOut => 'Terjual (Dikirim)',
            self::ReturnIn => 'Retur Masuk',
            self::Restock => 'Barang Masuk',
            self::Adjustment => 'Penyesuaian / Stock Opname',
        };
    }
}
