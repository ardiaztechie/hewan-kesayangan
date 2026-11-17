<?php

namespace App\Support;

final class Format
{
    /**
     * Contoh: 1500000 -> "Rp1.500.000"
     */
    public static function rupiah(float|int|string|null $value): string
    {
        return 'Rp'.number_format((float) $value, 0, ',', '.');
    }
}
