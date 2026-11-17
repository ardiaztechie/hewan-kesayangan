@use('App\Support\Format')
<x-admin-layout title="Dashboard">
    <h2 class="mb-3 text-base font-semibold">Yang Perlu Dilakukan</h2>
    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-5">
        @foreach ([
            ['Perlu Diproses', $todo['perlu_diproses'], 'Pesanan sudah dibayar'],
            ['Telah Diproses', $todo['telah_diproses'], 'Menunggu input resi'],
            ['Terlambat Dikirim', $todo['terlambat'], 'Lewat batas 2 hari'],
            ['Stok Menipis', $todo['stok_menipis'], 'Di bawah stok minimum'],
            ['Stok Habis', $todo['stok_habis'], 'Tidak bisa dibeli'],
        ] as [$label, $value, $hint])
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-sm opacity-70">{{ $label }}</p>
                    <p @class(['text-3xl font-bold', 'text-error' => $value > 0 && in_array($label, ['Terlambat Dikirim', 'Stok Habis'])])>{{ $value }}</p>
                    <p class="text-xs opacity-60">{{ $hint }}</p>
                </div>
            </div>
        @endforeach
    </div>

    @if ($owner)
        <h2 class="mb-3 mt-8 text-base font-semibold">Perlu Respons Owner</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="card bg-base-100 shadow-sm"><div class="card-body p-4">
                <p class="text-sm opacity-70">Pembatalan Perlu Respons</p>
                <p class="text-3xl font-bold">{{ $owner['pembatalan'] }}</p>
            </div></div>
            <div class="card bg-base-100 shadow-sm"><div class="card-body p-4">
                <p class="text-sm opacity-70">Pengembalian Perlu Respons</p>
                <p class="text-3xl font-bold">{{ $owner['pengembalian'] }}</p>
            </div></div>
            <div @class(['card bg-base-100 shadow-sm', 'border border-error' => $owner['refund_terlambat'] > 0])><div class="card-body p-4">
                <p class="text-sm opacity-70">Refund Belum Ditransfer</p>
                <p class="text-3xl font-bold">{{ $owner['refund_jumlah'] }}</p>
                <p class="text-xs opacity-60">Total {{ Format::rupiah($owner['refund_total']) }}
                    @if ($owner['refund_terlambat'] > 0)
                        · <span class="font-semibold text-error">{{ $owner['refund_terlambat'] }} lewat 2x24 jam</span>
                    @endif
                </p>
            </div></div>
        </div>

        <h2 class="mb-3 mt-8 text-base font-semibold">Ringkasan Keuangan · {{ $owner['periode'] }}</h2>
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-0">
                <table class="table">
                    <tbody>
                        <tr><td>Jumlah pesanan dibayar</td><td class="text-right">{{ $owner['jumlah_pesanan'] }}</td></tr>
                        <tr><td>Omzet kotor</td><td class="text-right">{{ Format::rupiah($owner['omzet_kotor']) }}</td></tr>
                        <tr><td>Refund</td><td class="text-right">&minus; {{ Format::rupiah($owner['refund']) }}</td></tr>
                        <tr class="font-semibold"><td>Omzet bersih</td><td class="text-right">{{ Format::rupiah($owner['omzet_bersih']) }}</td></tr>
                        <tr><td>Biaya payment gateway</td><td class="text-right">&minus; {{ Format::rupiah($owner['biaya_gateway']) }}</td></tr>
                        <tr><td>Penggantian ongkir retur</td><td class="text-right">&minus; {{ Format::rupiah($owner['ongkir_retur']) }}</td></tr>
                        <tr class="text-lg font-bold"><td>Penghasilan bersih</td><td class="text-right">{{ Format::rupiah($owner['penghasilan_bersih']) }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <p class="mt-2 text-xs opacity-60">Ongkir yang dibayar pelanggan tidak dihitung sebagai omzet. Angka akan terisi setelah ada pesanan (Tahap 5).</p>
    @endif
</x-admin-layout>
