<?php

namespace App\Enums;

enum RefundStatus: string
{
    case MenungguTransfer = 'menunggu_transfer';
    case DanaDikembalikan = 'dana_dikembalikan';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::MenungguTransfer => 'Menunggu Transfer',
            self::DanaDikembalikan => 'Dana Dikembalikan',
        };
    }
}
