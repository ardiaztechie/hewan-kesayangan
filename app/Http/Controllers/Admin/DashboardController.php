<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CancellationStatus;
use App\Enums\OrderStatus;
use App\Enums\OrderSubStatus;
use App\Enums\RefundStatus;
use App\Enums\ReturnStatus;
use App\Http\Controllers\Controller;
use App\Models\FinancialEntry;
use App\Models\Order;
use App\Models\OrderCancellation;
use App\Models\ProductVariant;
use App\Models\Refund;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Dashboard Seller Centre: kartu "Yang Perlu Dilakukan" (Staf & Owner)
 * dan Ringkasan Keuangan bulan ini (khusus Owner).
 */
class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $todo = [
            'perlu_diproses' => Order::query()->where('status', OrderStatus::Dikemas)
                ->where('sub_status', OrderSubStatus::PerluDiproses)->count(),
            'telah_diproses' => Order::query()->where('status', OrderStatus::Dikemas)
                ->where('sub_status', OrderSubStatus::TelahDiproses)->count(),
            'terlambat' => Order::query()->where('status', OrderStatus::Dikemas)
                ->where('ship_deadline_at', '<', now())->count(),
            'stok_menipis' => ProductVariant::query()->where('is_active', true)
                ->whereRaw('stock - reserved_stock <= min_stock')
                ->whereRaw('stock - reserved_stock > 0')->count(),
            'stok_habis' => ProductVariant::query()->where('is_active', true)
                ->whereRaw('stock - reserved_stock <= 0')->count(),
        ];

        $owner = $request->user()->isOwner() ? $this->ownerSummary() : null;

        return view('admin.dashboard', compact('todo', 'owner'));
    }

    /**
     * Ringkasan bulan berjalan dari catatan keuangan. Ongkir tidak dihitung sebagai omzet.
     */
    private function ownerSummary(): array
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $total = fn (array $types): float => (float) FinancialEntry::query()
            ->whereBetween('entry_date', [$start->toDateString(), $end->toDateString()])
            ->whereIn('type', $types)
            ->sum('amount');

        $omzetKotor = $total(['penjualan']);
        $refund = -$total(['refund_produk']);
        $omzetBersih = $omzetKotor - $refund + $total(['koreksi_refund']);
        $biayaGateway = -$total(['biaya_gateway']);
        $ongkirRetur = -$total(['ongkir_retur']);

        $pendingRefund = Refund::query()->where('status', RefundStatus::MenungguTransfer);

        return [
            'pembatalan' => OrderCancellation::query()->where('status', CancellationStatus::MenungguRespons)->count(),
            'pengembalian' => ReturnRequest::query()->where('status', ReturnStatus::MenungguRespons)->count(),
            'refund_jumlah' => (clone $pendingRefund)->count(),
            'refund_total' => (float) (clone $pendingRefund)->sum('total_amount'),
            'refund_terlambat' => (clone $pendingRefund)->where('transfer_deadline_at', '<', now())->count(),
            'jumlah_pesanan' => Order::query()->whereBetween('paid_at', [$start, $end])->count(),
            'omzet_kotor' => $omzetKotor,
            'refund' => $refund,
            'omzet_bersih' => $omzetBersih,
            'biaya_gateway' => $biayaGateway,
            'ongkir_retur' => $ongkirRetur,
            'penghasilan_bersih' => $omzetBersih - $biayaGateway - $ongkirRetur,
            'periode' => $start->translatedFormat('F Y'),
        ];
    }
}
