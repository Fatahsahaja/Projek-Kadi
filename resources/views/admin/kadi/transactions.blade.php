<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Transaksi — KADI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #1a1f2e;
            position: fixed;
            top: 0;
            left: 0;
            padding: 30px 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            margin: 0;
        }

        .sidebar-brand span {
            color: #f7941d;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 25px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            color: white;
            background: rgba(247, 148, 29, 0.1);
            border-left-color: #f7941d;
        }

        .sidebar-menu a i {
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .topbar h2 {
            font-weight: 700;
            color: #1a1f2e;
            margin: 0;
        }

        .card-custom {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .card-custom .card-header {
            background: transparent;
            border-bottom: 1px solid #f0f0f0;
            padding: 20px 25px;
            font-weight: 600;
            color: #1a1f2e;
        }

        .table th {
            background: #f8fafc;
            color: #374151;
            font-weight: 600;
            border: none;
            padding: 15px;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-color: #f0f0f0;
        }

        .status-pending {
            background: #fff7ed;
            color: #f7941d;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-sukses {
            background: #f0fdf4;
            color: #10b981;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-selesai {
            background: #eff6ff;
            color: #3b82f6;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .filter-card {
            background: white;
            border-radius: 16px;
            padding: 20px 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .form-control,
        .form-select {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 8px 15px;
            font-size: 0.9rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #f7941d;
            box-shadow: 0 0 0 3px rgba(247, 148, 29, 0.1);
        }

        .btn-kadi {
            background: #f7941d;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .btn-kadi:hover {
            background: #e8830d;
            color: white;
        }

        .btn-export {
            background: #10b981;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .btn-export:hover {
            background: #059669;
            color: white;
        }
         .logo-img {
            height: 55px;
            object-fit: contain;
            width: auto;
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">
    <div class="sidebar-brand">
        <img src="/images/Logowhite.png" alt="Logo Kadi" class="logo-img">
    </div>

    <nav class="sidebar-menu">
        <a href="{{ route('admin.kadi.dashboard') }}"
           class="{{ request()->routeIs('admin.kadi.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('admin.kadi.shops') }}"
           class="{{ request()->routeIs('admin.kadi.shops*') ? 'active' : '' }}">
            <i class="fas fa-store"></i> Manajemen Warung
        </a>
        <a href="{{ route('admin.kadi.transactions') }}"
           class="{{ request()->routeIs('admin.kadi.transactions') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i> Semua Transaksi
        </a>
        <a href="{{ route('admin.kadi.topup') }}"
           class="{{ request()->routeIs('admin.kadi.topup') ? 'active' : '' }}">
            <i class="fas fa-wallet"></i> Manajemen Top Up
        </a>
        <a href="{{ route('admin.kadi.blacklist') }}"
   class="{{ request()->routeIs('admin.kadi.blacklist') ? 'active' : '' }}">
    <i class="fas fa-ban"></i> Blacklist Customer
</a>
        <a href="{{ route('admin.kadi.export.csv') }}"
           class="{{ request()->routeIs('admin.kadi.export.csv') ? 'active' : '' }}">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#ef4444; padding:8px 20px; border-radius:8px; width:100%; font-size:0.85rem; cursor:pointer;">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
</aside>

    {{-- MAIN --}}
    <main class="main-content">

        <div class="topbar">
            <div>
                <h2>Semua Transaksi</h2>
                <small class="text-muted">{{ $transactions->total() }} total transaksi ditemukan</small>
            </div>
            {{-- Export CSV dengan filter yang aktif --}}
            <a href="{{ route('admin.kadi.export.csv', request()->query()) }}" class="btn btn-export">
                <i class="fas fa-download me-2"></i> Export CSV
            </a>
        </div>

        {{-- FILTER --}}
        <div class="filter-card">
            <form action="{{ route('admin.kadi.transactions') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-500" style="font-size:0.85rem; font-weight:600;">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>PENDING
                            </option>
                            <option value="SUKSES" {{ request('status') === 'SUKSES' ? 'selected' : '' }}>SUKSES
                            </option>
                            <option value="SELESAI" {{ request('status') === 'SELESAI' ? 'selected' : '' }}>SELESAI
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-500" style="font-size:0.85rem; font-weight:600;">Warung</label>
                        <select name="shop_id" class="form-select">
                            <option value="">Semua Warung</option>
                            @foreach ($shops as $shop)
                                <option value="{{ $shop->id }}"
                                    {{ request('shop_id') == $shop->id ? 'selected' : '' }}>
                                    {{ $shop->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-500" style="font-size:0.85rem; font-weight:600;">Dari
                            Tanggal</label>
                        <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-500" style="font-size:0.85rem; font-weight:600;">Sampai
                            Tanggal</label>
                        <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-kadi w-100">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.kadi.transactions') }}" class="btn btn-outline-secondary rounded-3">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- TABEL --}}
        <div class="card-custom">
            <div class="card-header">
                <i class="fas fa-receipt me-2 text-warning"></i>
                Daftar Transaksi
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Warung</th>
                            <th>Nama Siswa</th>
                            <th>Item Pesanan</th>
                            <th>No. Telepon</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                            <tr>
                                <td><small class="text-muted">#{{ $tx->id }}</small></td>
                                <td>
                                    <span class="fw-semibold" style="font-size:0.85rem;">{{ $tx->shop->name }}</span>
                                </td>
                                <td>{{ $tx->cashier_name }}</td>
                                <td>
                                    @php
                                        $items = is_array($tx->items) ? $tx->items : json_decode($tx->items, true);
                                    @endphp
                                    @if (is_array($items))
                                        @foreach ($items as $item)
                                            <small>{{ $item['name'] }} x{{ $item['quantity'] ?? 1 }}</small><br>
                                        @endforeach
                                    @else
                                        <small>{{ $tx->items }}</small>
                                    @endif
                                </td>
                                <td><small>{{ $tx->phone ?? '-' }}</small></td>
                                <td><strong>Rp {{ number_format($tx->total, 0, ',', '.') }}</strong></td>
                                <td>
                                    @if ($tx->status === 'PENDING')
                                        <span class="status-pending">PENDING</span>
                                    @elseif($tx->status === 'SUKSES')
                                        <span class="status-sukses">SUKSES ✅</span>
                                    @else
                                        <span class="status-selesai">{{ $tx->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $tx->created_at->format('d M Y') }}</small><br>
                                    <small class="text-muted">{{ $tx->created_at->format('H:i') }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-receipt fa-2x mb-3 d-block opacity-25"></i>
                                    Tidak ada transaksi ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center p-4">
                <small class="text-muted">
                    Menampilkan {{ $transactions->firstItem() ?? 0 }}–{{ $transactions->lastItem() ?? 0 }}
                    dari {{ $transactions->total() }} transaksi
                </small>
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('swal'))
        <script>
            Swal.fire({
                icon: "{{ session('swal.type') }}",
                title: "{{ session('swal.title') }}",
                text: "{{ session('swal.text') }}",
                confirmButtonColor: "#f7941d",
            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
