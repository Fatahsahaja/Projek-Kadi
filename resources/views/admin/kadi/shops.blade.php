<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Warung — KADI</title>
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

        .card-custom .card-body {
            padding: 25px;
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

        .btn-kadi {
            background: #f7941d;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .btn-kadi:hover {
            background: #e8830d;
            color: white;
        }

        .shop-badge {
            background: #fff7ed;
            color: #f7941d;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
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
                <h2>Manajemen Warung</h2>
                <small class="text-muted">Kelola warung dan akun admin kantin</small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.kadi.shops.trashed') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-trash-restore me-2"></i> Warung Terhapus
                </a>
                <a href="{{ route('admin.kadi.shops.create') }}" class="btn btn-kadi">
                    <i class="fas fa-plus me-2"></i> Tambah Warung
                </a>
            </div>
        </div>

        <div class="card-custom">
            <div class="card-header">
                <i class="fas fa-store me-2 text-warning"></i>
                Daftar Warung ({{ $shops->count() }} warung)
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Warung</th>
                                <th>Admin Kantin</th>
                                <th>Email Admin</th>
                                <th>Total Transaksi</th>
                                <th>Balance</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shops as $shop)
                                @php $admin = $shop->users->where('role', 'admin_kantin')->first(); @endphp
                                <tr>
                                    <td><span class="shop-badge">#{{ $shop->id }}</span></td>
                                    <td>
                                        <div class="fw-semibold">{{ $shop->name }}</div>
                                    </td>
                                    <td>{{ $admin?->name ?? '-' }}</td>
                                    <td>
                                        <small class="text-muted">{{ $admin?->email ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $shop->transactions_count }}
                                            transaksi</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">Rp
                                            {{ number_format($shop->balance, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.kadi.shops.edit', $shop->id) }}"
                                                class="btn btn-sm btn-outline-warning rounded-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.kadi.shops.delete', $shop->id) }}"
                                                method="POST" id="deleteShop-{{ $shop->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-2"
                                                    onclick="confirmDeleteShop({{ $shop->id }}, '{{ addslashes($shop->name) }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-store fa-2x mb-3 d-block opacity-25"></i>
                                        Belum ada warung. Tambah warung pertama!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
    <script>
        function confirmDeleteShop(id, name) {
            Swal.fire({
                icon: 'warning',
                title: 'Hapus Warung?',
                text: name + ' dan semua datanya akan dihapus permanen!',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteShop-' + id).submit();
                }
            });
        }
    </script>
</body>

</html>
