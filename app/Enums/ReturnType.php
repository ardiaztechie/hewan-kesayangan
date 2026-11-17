<?php

namespace App\Enums;

enum ReturnType: string
{
    case RefundOnly = 'refund_only';
    case ReturnRefund = 'return_refund';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::RefundOnly => 'Pengembalian Dana Saja',
            self::ReturnRefund => 'Kembalikan Barang & Dana',
        };
    }
}
