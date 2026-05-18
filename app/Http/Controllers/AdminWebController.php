<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TopupRequest;
use App\Models\RefundRequest;
use Illuminate\Support\Facades\DB;

class AdminWebController extends Controller
{
    // ─────────────────────────────────────────────
    // DASHBOARD OVERVIEW
    // ─────────────────────────────────────────────
    public function dashboard()
    {
        // Stats cards
        $totalPendapatan = Transaction::where('status', 'SUKSES')->sum('total');
        $totalTransaksi  = Transaction::count();
        $totalWarung     = Shop::count();
        $totalPending    = Transaction::where('status', 'PENDING')->count();

        // Data warung + pendapatan
        $shops = Shop::withCount('transactions')
            ->withSum('transactions', 'total')
            ->get();

        // Grafik 7 hari terakhir
        $grafik = Transaction::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as total_transaksi'),
                DB::raw('SUM(total) as total_pendapatan')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('admin.kadi.dashboard', compact(
            'totalPendapatan',
            'totalTransaksi',
            'totalWarung',
            'totalPending',
            'shops',
            'grafik'
        ));
    }

    public function topupIndex(Request $request)
    {
        // ── DATA TOPUP ──
        $topupQuery = TopupRequest::with('user')->latest();
        if ($request->topup_status) {
            $topupQuery->where('status', $request->topup_status);
        }
        $topups        = $topupQuery->paginate(15, ['*'], 'topup_page');
        $pendingCount  = TopupRequest::where('status', 'PENDING')->count();
        $approvedCount = TopupRequest::where('status', 'APPROVED')->count();
        $rejectedCount = TopupRequest::where('status', 'REJECTED')->count();
        $totalApproved = TopupRequest::where('status', 'APPROVED')->sum('amount');

        // ── DATA REFUND ──
        $refundQuery = RefundRequest::with('user')->latest();
        if ($request->refund_status) {
            $refundQuery->where('status', $request->refund_status);
        }
        $refunds             = $refundQuery->paginate(15, ['*'], 'refund_page');
        $refundPendingCount  = RefundRequest::where('status', 'PENDING')->count();
        $refundApprovedCount = RefundRequest::where('status', 'APPROVED')->count();
        $refundRejectedCount = RefundRequest::where('status', 'REJECTED')->count();
        $totalRefunded       = RefundRequest::where('status', 'APPROVED')->sum('amount');

        $activeTab = $request->tab === 'refund' ? 'refund' : 'topup';

        return view('admin.kadi.topup', compact(
            'topups', 'pendingCount', 'approvedCount', 'rejectedCount', 'totalApproved',
            'refunds', 'refundPendingCount', 'refundApprovedCount', 'refundRejectedCount', 'totalRefunded',
            'activeTab'
        ));
    }


    // ─────────────────────────────────────────────
    // MANAJEMEN WARUNG
    // ─────────────────────────────────────────────
    public function shops()
    {
        $shops = Shop::with('users')->withCount('transactions')->get();
        return view('admin.kadi.shops', compact('shops'));
    }
    // Halaman warung yang sudah dihapus
public function trashedShops()
{
    $shops = Shop::onlyTrashed()->with('users')->get();
    return view('admin.kadi.shops-trashed', compact('shops'));
}

// Restore warung
public function restoreShop($id)
{
    Shop::withTrashed()->findOrFail($id)->restore();

    return redirect()->route('admin.kadi.shops.trashed')->with('swal', [
        'type'  => 'success',
        'title' => 'Berhasil!',
        'text'  => 'Warung berhasil dipulihkan.',
    ]);
}

    public function createShop()
    {
        return view('admin.kadi.shop-create');
    }

    public function storeShop(Request $request)
    {
        $request->validate([
            'shop_name'      => 'required|string|max:255',
            'admin_name'     => 'required|string|max:255',
            'admin_email'    => 'required|email|unique:users,email',
            'admin_password' => 'required|min:8',
            'admin_phone'    => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // Buat warung
            $shop = Shop::create([
                'name'    => $request->shop_name,
                'balance' => 0,
            ]);

            // Otomatis buat akun admin kantin
            User::create([
                'name'     => $request->admin_name,
                'email'    => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'phone'    => $request->admin_phone,
                'role'     => 'admin_kantin',
                'shop_id'  => $shop->id,
            ]);
        });

        return redirect()->route('admin.kadi.shops')->with('swal', [
            'type'  => 'success',
            'title' => 'Warung Dibuat!',
            'text'  => 'Warung dan akun admin kantin berhasil dibuat.',
        ]);
    }

    public function editShop(Shop $shop)
    {
        $admin = $shop->users()->where('role', 'admin_kantin')->first();
        return view('admin.kadi.shop-edit', compact('shop', 'admin'));
    }

    public function updateShop(Request $request, Shop $shop)
    {
        $request->validate([
            'shop_name'   => 'required|string|max:255',
            'admin_name'  => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email,' . $shop->users()->first()?->id,
            'admin_phone' => 'nullable|string',
        ]);

        $shop->update(['name' => $request->shop_name]);

        $admin = $shop->users()->where('role', 'admin_kantin')->first();
        if ($admin) {
            $adminData = [
                'name'  => $request->admin_name,
                'email' => $request->admin_email,
                'phone' => $request->admin_phone,
            ];
            if ($request->filled('admin_password')) {
                $adminData['password'] = Hash::make($request->admin_password);
            }
            $admin->update($adminData);
        }

        return redirect()->route('admin.kadi.shops')->with('swal', [
            'type'  => 'success',
            'title' => 'Berhasil Diupdate!',
            'text'  => 'Data warung berhasil diperbarui.',
        ]);
    }

    public function deleteShop(Shop $shop)
    {
        $shop->delete();
        return redirect()->route('admin.kadi.shops')->with('swal', [
            'type'  => 'success',
            'title' => 'Warung Dihapus!',
            'text'  => 'Warung dan semua datanya berhasil dihapus.',
        ]);
    }

    // ─────────────────────────────────────────────
    // SEMUA TRANSAKSI + FILTER
    // ─────────────────────────────────────────────
    public function transactions(Request $request)
    {
        $query = Transaction::with('shop', 'user')->latest();

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter warung
        if ($request->filled('shop_id')) {
            $query->where('shop_id', $request->shop_id);
        }

        // Filter tanggal
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        $transactions = $query->paginate(20)->withQueryString();
        $shops        = Shop::all();

        return view('admin.kadi.transactions', compact('transactions', 'shops'));
    }

    // ─────────────────────────────────────────────
    // EXPORT CSV
    // ─────────────────────────────────────────────
    public function exportCsv(Request $request)
    {
        $query = Transaction::with('shop', 'user')->latest();

        if ($request->filled('status'))  $query->where('status', $request->status);
        if ($request->filled('shop_id')) $query->where('shop_id', $request->shop_id);
        if ($request->filled('dari'))    $query->whereDate('created_at', '>=', $request->dari);
        if ($request->filled('sampai'))  $query->whereDate('created_at', '<=', $request->sampai);

        $transactions = $query->get();

        $filename = 'laporan-transaksi-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, ['ID', 'Warung', 'Nama Siswa', 'No Telepon', 'Items', 'Total', 'Status', 'Tanggal']);

            foreach ($transactions as $tx) {
                $items = is_array($tx->items)
                    ? collect($tx->items)->pluck('name')->join(', ')
                    : $tx->items;

                fputcsv($file, [
                    $tx->id,
                    $tx->shop->name,
                    $tx->cashier_name,
                    $tx->phone,
                    $items,
                    $tx->total,
                    $tx->status,
                    $tx->created_at->format('d M Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
