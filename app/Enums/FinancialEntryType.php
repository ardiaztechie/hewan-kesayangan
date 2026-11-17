<?php

namespace App\Enums;

enum FinancialEntryType: string
{
    case Penjualan = 'penjualan';
    case Ongkir = 'ongkir';
    case BiayaGateway = 'biaya_gateway';
    case RefundProduk = 'refund_produk';
    case RefundOngkir = 'refund_ongkir';
    case OngkirRetur = 'ongkir_retur';
    case KoreksiRefund = 'koreksi_refund';

    /**
     * Label Bahasa Indonesia untuk ditampilkan di halaman.
     */
    public function label(): string
    {
        return match ($this) {
            self::Penjualan => 'Penjualan',
            self::Ongkir => 'Ongkir',
            self::BiayaGateway => 'Biaya Payment Gateway',
            self::RefundProduk => 'Refund Produk',
            self::RefundOngkir => 'Refund Ongkir',
            self::OngkirRetur => 'Penggantian Ongkir Retur',
            self::KoreksiRefund => 'Koreksi Refund',
        };
    }
}
