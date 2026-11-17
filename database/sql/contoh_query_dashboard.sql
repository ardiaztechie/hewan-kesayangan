-- Contoh query untuk dashboard Owner. Ganti tanggal sesuai periode.

-- 1. Ringkasan Keuangan (ongkir tidak dihitung sebagai omzet)
SELECT
  SUM(CASE WHEN type = 'penjualan' THEN amount ELSE 0 END)                                    AS omzet_kotor,
  -SUM(CASE WHEN type = 'refund_produk' THEN amount ELSE 0 END)                               AS refund,
  SUM(CASE WHEN type IN ('penjualan','refund_produk','koreksi_refund') THEN amount ELSE 0 END) AS omzet_bersih,
  -SUM(CASE WHEN type = 'biaya_gateway' THEN amount ELSE 0 END)                               AS biaya_payment_gateway,
  -SUM(CASE WHEN type = 'ongkir_retur' THEN amount ELSE 0 END)                                AS penggantian_ongkir_retur,
  SUM(CASE WHEN type IN ('penjualan','refund_produk','koreksi_refund','biaya_gateway','ongkir_retur') THEN amount ELSE 0 END) AS penghasilan_bersih
FROM financial_entries
WHERE entry_date BETWEEN '2026-11-01' AND '2026-11-30';

-- 2. Kartu "Refund Belum Ditransfer" (yang lewat batas ditandai terlambat)
SELECT COUNT(*) AS jumlah, SUM(total_amount) AS total,
       SUM(transfer_deadline_at < NOW()) AS terlambat
FROM refunds WHERE status = 'menunggu_transfer';

-- 3. Kartu "Yang Perlu Dilakukan"
SELECT
  SUM(status = 'dikemas' AND sub_status = 'perlu_diproses') AS perlu_diproses,
  SUM(status = 'dikemas' AND sub_status = 'telah_diproses') AS telah_diproses,
  SUM(status = 'dikemas' AND ship_deadline_at < NOW())     AS terlambat_dikirim
FROM orders;

-- 4. Stok menipis / habis (stok tersedia = stok fisik - direservasi)
SELECT p.name, v.name AS varian, v.sku, v.stock, v.reserved_stock,
       (v.stock - v.reserved_stock) AS tersedia, v.min_stock,
       CASE WHEN v.stock - v.reserved_stock = 0 THEN 'Habis' ELSE 'Menipis' END AS label
FROM product_variants v JOIN products p ON p.id = v.product_id
WHERE v.stock - v.reserved_stock <= v.min_stock
ORDER BY tersedia;
