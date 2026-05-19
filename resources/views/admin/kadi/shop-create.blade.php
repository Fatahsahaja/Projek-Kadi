<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Warung — KADI</title>
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
            padding: 30px;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #f7941d;
            box-shadow: 0 0 0 3px rgba(247, 148, 29, 0.1);
        }

        .btn-kadi {
            background: #f7941d;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }

        .btn-kadi:hover {
            background: #e8830d;
            color: white;
        }

        .section-divider {
            border: none;
            border-top: 2px dashed #f0f0f0;
            margin: 25px 0;
        }

        .section-title {
            font-weight: 600;
            color: #f7941d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
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
                <button type="submit"
                    style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#ef4444; padding:8px 20px; border-radius:8px; width:100%; font-size:0.85rem; cursor:pointer;">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="main-content">
        <div class="mb-4">
            <a href="{{ route('admin.kadi.shops') }}" class="text-muted text-decoration-none">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <h2 class="fw-bold mt-2" style="color:#1a1f2e;">Tambah Warung Baru</h2>
        </div>

        <div class="card-custom">
            <div class="card-header">
                <i class="fas fa-store me-2 text-warning"></i>
                Form Tambah Warung + Akun Admin Kantin
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.kadi.shops.store') }}" method="POST">
                    @csrf

                    {{-- DATA WARUNG --}}
                    <div class="section-title">
                        <i class="fas fa-store me-2"></i> Data Warung
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Nama Warung <span class="text-danger">*</span></label>
                        <input type="text" name="shop_name" class="form-control" placeholder="contoh: Kantin Bu Sari"
                            value="{{ old('shop_name') }}" required>
                    </div>

                    <hr class="section-divider">

                    {{-- DATA ADMIN KANTIN --}}
                    <div class="section-title">
                        <i class="fas fa-user-tie me-2"></i> Akun Admin Kantin
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Admin <span class="text-danger">*</span></label>
                            <input type="text" name="admin_name" class="form-control"
                                placeholder="Nama lengkap admin" value="{{ old('admin_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="admin_phone" class="form-control" placeholder="08xxxxxxxxxx"
                                value="{{ old('admin_phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="admin_email" class="form-control" placeholder="admin@kantin.com"
                                autocomplete="off" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="admin_password" class="form-control"
                                placeholder="Min. 8 karakter" autocomplete="new-password" required>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-kadi">
                            <i class="fas fa-plus me-2"></i> Buat Warung
                        </button>
                        <a href="{{ route('admin.kadi.shops') }}" class="btn btn-outline-secondary rounded-3 px-4">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
