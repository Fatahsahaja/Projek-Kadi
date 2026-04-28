<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Warung — KADI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
        .sidebar { width: 260px; min-height: 100vh; background: #1a1f2e; position: fixed; top: 0; left: 0; padding: 30px 0; z-index: 100; }
        .sidebar-brand { padding: 0 25px 30px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .sidebar-brand h4 { color: white; font-weight: 700; font-size: 1.3rem; margin: 0; }
        .sidebar-brand span { color: #f7941d; }
        .sidebar-menu a { display: flex; align-items: center; gap: 12px; padding: 12px 25px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: 0.2s; border-left: 3px solid transparent; }
        .sidebar-menu a:hover, .sidebar-menu a.active { color: white; background: rgba(247,148,29,0.1); border-left-color: #f7941d; }
        .sidebar-menu a i { width: 20px; text-align: center; }
        .sidebar-footer { position: absolute; bottom: 0; left: 0; right: 0; padding: 20px 25px; border-top: 1px solid rgba(255,255,255,0.1); }
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        .card-custom { background: white; border-radius: 16px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); border: none; }
        .card-custom .card-header { background: transparent; border-bottom: 1px solid #f0f0f0; padding: 20px 25px; font-weight: 600; color: #1a1f2e; }
        .card-custom .card-body { padding: 30px; }
        .form-label { font-weight: 500; color: #374151; font-size: 0.9rem; }
        .form-control { border: 1px solid #e5e7eb; border-radius: 10px; padding: 10px 15px; font-size: 0.9rem; }
        .form-control:focus { border-color: #f7941d; box-shadow: 0 0 0 3px rgba(247,148,29,0.1); }
        .btn-kadi { background: #f7941d; color: white; border: none; border-radius: 10px; padding: 12px 30px; font-weight: 600; }
        .btn-kadi:hover { background: #e8830d; color: white; }
        .section-divider { border: none; border-top: 2px dashed #f0f0f0; margin: 25px 0; }
        .section-title { font-weight: 600; color: #f7941d; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <h4>K<span>◆</span>DI</h4>
        <small style="color:rgba(255,255,255,0.4); font-size:0.75rem;">Super Admin Panel</small>
    </div>
    <nav class="sidebar-menu">
        <a href="{{ route('admin.kadi.dashboard') }}"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="{{ route('admin.kadi.shops') }}" class="active"><i class="fas fa-store"></i> Manajemen Warung</a>
        <a href="{{ route('admin.kadi.transactions') }}"><i class="fas fa-receipt"></i> Semua Transaksi</a>
        <a href="{{ route('admin.kadi.export.csv') }}"><i class="fas fa-file-csv"></i> Export CSV</a>
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

<main class="main-content">
    <div class="mb-4">
        <a href="{{ route('admin.kadi.shops') }}" class="text-muted text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
        <h2 class="fw-bold mt-2" style="color:#1a1f2e;">Edit Warung</h2>
    </div>

    <div class="card-custom">
        <div class="card-header">
            <i class="fas fa-edit me-2 text-warning"></i>
            Edit Data {{ $shop->name }}
        </div>
        <div class="card-body">

            @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.kadi.shops.update', $shop->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="section-title"><i class="fas fa-store me-2"></i> Data Warung</div>
                <div class="mb-4">
                    <label class="form-label">Nama Warung <span class="text-danger">*</span></label>
                    <input type="text" name="shop_name" class="form-control"
                           value="{{ old('shop_name', $shop->name) }}" required>
                </div>

                <hr class="section-divider">

                <div class="section-title"><i class="fas fa-user-tie me-2"></i> Akun Admin Kantin</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Admin <span class="text-danger">*</span></label>
                        <input type="text" name="admin_name" class="form-control"
                               value="{{ old('admin_name', $admin?->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="admin_phone" class="form-control"
                               value="{{ old('admin_phone', $admin?->phone) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="admin_email" class="form-control"
                               value="{{ old('admin_email', $admin?->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                        <input type="password" name="admin_password" class="form-control"
                               placeholder="Min. 8 karakter">
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-kadi">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
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
