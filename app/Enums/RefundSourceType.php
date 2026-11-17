<?php

namespace App\Enums;

enum RefundSourceType: string
{
    case Cancellation = 'cancellation';
    case Return = 'return';
    case FailedDelivery = 'failed_delivery';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Cancellation => 'Pembatalan',
            self::Return => 'Pengembalian',
            self::FailedDelivery => 'Gagal Kirim',
        };
    }
}
