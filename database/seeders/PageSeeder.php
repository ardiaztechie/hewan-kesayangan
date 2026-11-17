<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

/**
 * Halaman profil brand dan informasi.
 */
class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::query()->create([
            'slug' => 'tentang-kami',
            'title' => 'Tentang Kami',
            'content' => 'Hewan Kesayangan Anda adalah brand alat peternakan dan perlengkapan hewan kesayangan. Website ini adalah toko resmi kami selain Shopee dan TikTok Shop.',
        ]);
        Page::query()->create([
            'slug' => 'cara-belanja',
            'title' => 'Cara Belanja',
            'content' => '1. Pilih produk dan jumlah. Harga grosir otomatis berlaku sesuai jumlah.
2. Checkout, pilih alamat dan kurir.
3. Bayar melalui QRIS atau Virtual Account dalam 24 jam.
4. Pesanan dikemas dan dikirim maksimal 2 hari setelah pembayaran.
5. Klik Pesanan Diterima setelah barang sampai.',
        ]);
        Page::query()->create([
            'slug' => 'kebijakan-pengembalian',
            'title' => 'Kebijakan Pengembalian',
            'content' => '1. Pengembalian dapat diajukan selama pesanan Dikirim sampai 3 hari setelah Selesai, dengan foto/video bukti.
2. Alasan yang diterima: barang rusak, tidak sesuai, kurang, atau tidak diterima.
3. Bila barang harus dikembalikan, kirim paling lambat 5 hari setelah pengajuan disetujui. Ongkir pengiriman retur ke toko ditanggung toko sesuai bukti resi.
4. Toko memeriksa barang paling lambat 2x24 jam setelah diterima. Hasilnya: pengembalian penuh, pengembalian sebagian, atau ditolak.
5. Bila ditolak dan barang dikirim balik ke pembeli, ongkir kirim balik ditanggung pembeli.
6. Dana ditransfer ke rekening/e-wallet pembeli paling lambat 2x24 jam setelah refund disetujui, dan bukti transfer dapat dilihat di halaman pesanan.',
        ]);
    }
}
