<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blacklist Customer — KADI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
        .sidebar { width: 260px; min-height: 100vh; background: #1a1f2e; position: fixed; top: 0; left: 0; padding: 30px 0; z-index: 100; }
        .sidebar-brand { padding: 0 25px 30px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .sidebar-menu a { display: flex; align-items: center; gap: 12px; padding: 12px 25px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: 0.2s; border-left: 3px solid transparent; }
        .sidebar-menu a:hover, .sidebar-menu a.active { color: white; background: rgba(247,148,29,0.1); border-left-color: #f7941d; }
        .sidebar-menu a i { width: 20px; text-align: center; }
        .sidebar-footer { position: absolute; bottom: 0; left: 0; right: 0; padding: 20px 25px; border-top: 1px solid rgba(255,255,255,0.1); }
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        .card-custom { background: white; border-radius: 16px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); border: none; }
        .card-custom .card-header { background: transparent; border-bottom: 1px solid #f0f0f0; padding: 20px 25px; font-weight: 600; color: #1a1f2e; }
        .table th { background: #f8fafc; color: #374151; font-weight: 600; border: none; padding: 15px; }
        .table td { padding: 15px; vertical-align: middle; border-color: #f0f0f0; }
        .stat-card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); }
        .stat-value { font-size: 1.8rem; font-weight: 700; }
        .stat-label { font-size: 0.85rem; color: #6b7280; margin-top: 4px; }
        .badge-active { background: #f0fdf4; color: #10b981; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .badge-blacklisted { background: #fef2f2; color: #ef4444; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .logo-img { height: 55px; object-fit: contain; width: auto; }
        .blacklisted-row { background: #fef2f2 !important; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="/images/Logowhite.png" alt="Logo Kadi" class="logo-img">
    </div>
    <nav class="sidebar-menu">
        <a href="{{ route('admin.kadi.dashboard') }}" class="{{ request()->routeIs('admin.kadi.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('admin.kadi.shops') }}" class="{{ request()->routeIs('admin.kadi.shops*') ? 'active' : '' }}">
            <i class="fas fa-store"></i> Manajemen Warung
        </a>
        <a href="{{ route('admin.kadi.transactions') }}" class="{{ request()->routeIs('admin.kadi.transactions') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i> Semua Transaksi
        </a>
        <a href="{{ route('admin.kadi.topup') }}" class="{{ request()->routeIs('admin.kadi.topup*') ? 'active' : '' }}">
            <i class="fas fa-wallet"></i> Manajemen Saldo
        </a>
        <a href="{{ route('admin.kadi.blacklist') }}" class="{{ request()->routeIs('admin.kadi.blacklist*') ? 'active' : '' }}">
            <i class="fas fa-ban"></i> Blacklist Customer
        </a>
        <a href="{{ route('admin.kadi.export.csv') }}" class="{{ request()->routeIs('admin.kadi.export.csv') ? 'active' : '' }}">
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

<main class="main-content">

    <div class="mb-4">
        <h2 style="font-weight:700;color:#1a1f2e;margin:0;">Blacklist Customer</h2>
        <small class="text-muted">Kelola customer yang bermasalah</small>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card border-start border-4 border-success">
                <div class="stat-value text-success">{{ $activeCount }}</div>
                <div class="stat-label">Customer Aktif</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card border-start border-4 border-danger">
                <div class="stat-value text-danger">{{ $blacklistCount }}</div>
                <div class="stat-label">Di-blacklist</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card border-start border-4 border-warning">
                <div class="stat-value" style="color:#f7941d;">{{ $activeCount + $blacklistCount }}</div>
                <div class="stat-label">Total Customer</div>
            </div>
        </div>
    </div>

    {{-- FILTER & CARI --}}
    <div class="card-custom p-4 mb-4">
        <form action="{{ route('admin.kadi.blacklist') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-secondary">Filter</label>
                <select name="filter" class="form-select border-light-subtle rounded-3">
                    <option value="">Semua Customer</option>
                    <option value="active"      {{ request('filter') === 'active'      ? 'selected' : '' }}>Aktif</option>
                    <option value="blacklisted" {{ request('filter') === 'blacklisted' ? 'selected' : '' }}>Di-blacklist</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Cari</label>
                <input type="text" name="search" class="form-control border-light-subtle rounded-3"
                       value="{{ request('search') }}" placeholder="Nama atau no telepon...">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn fw-semibold w-100 rounded-3 py-2"
                        style="background:#ffc107; border:none; color:#1a1f2e;">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </div>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="card-custom">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-minus-circle text-danger me-2"></i> Daftar Customer</span>
            <small class="text-muted">{{ $customers->total() }} customer</small>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>No. Telepon</th>
                        <th>NIS</th>
                        <th>Total Order</th>
                        <th>Status</th>
                        <th>Alasan Blacklist</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr class="{{ $customer->is_blacklisted ? 'blacklisted-row' : '' }}">
                        <td><small class="text-muted">#{{ $customer->id }}</small></td>
                        <td>
                            <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                @if($customer->is_blacklisted)
                                    <span style="color:#ef4444;">🚫</span>
                                @endif
                                {{ $customer->name }}
                            </div>
                            @if($customer->blacklisted_at)
                                <small class="text-danger">Sejak {{ $customer->blacklisted_at->format('d M Y') }}</small>
                            @endif
                        </td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->nis ?? '—' }}</td>
                        <td>{{ $customer->transactions_count }}x</td>
                        <td>
                            @if(!$customer->is_blacklisted)
                                <span class="badge-active"><i class="fas fa-check me-1"></i> Aktif</span>
                            @else
                                <span class="badge-blacklisted"><i class="fas fa-ban me-1"></i> Di-blacklist</span>
                            @endif
                        </td>
                        <td>
                            <small class="{{ $customer->is_blacklisted ? 'text-danger' : 'text-muted' }}">
                                {{ $customer->blacklist_reason ?? '—' }}
                            </small>
                        </td>
                        <td class="text-center">
                            @if(!$customer->is_blacklisted)
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                    data-bs-toggle="modal" data-bs-target="#blacklistModal{{ $customer->id }}">
                                <i class="fas fa-ban me-1"></i> Blacklist
                            </button>

                            {{-- Modal Blacklist --}}
                            <div class="modal fade" id="blacklistModal{{ $customer->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow rounded-4">
                                        <div class="modal-header border-0">
                                            <h6 class="modal-title fw-bold text-danger">
                                                <i class="fas fa-ban me-2"></i> Blacklist Customer
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.kadi.blacklist.add', $customer->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body pt-0">
                                                <p class="text-muted small mb-3">
                                                    Customer <strong>{{ $customer->name }}</strong>
                                                    ({{ $customer->phone }}) tidak akan bisa checkout.
                                                </p>
                                                <label class="form-label small fw-semibold">
                                                    Alasan Blacklist <span class="text-danger">*</span>
                                                </label>
                                                <textarea name="reason" class="form-control rounded-3" rows="3" required
                                                    placeholder="Contoh: Sering membuat pesanan fiktif, tidak pernah mengambil pesanan..."></textarea>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill"
                                                        data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4">
                                                    🚫 Blacklist Sekarang
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @else
                            <form action="{{ route('admin.kadi.blacklist.remove', $customer->id) }}" method="POST"
                                  onsubmit="return confirm('Cabut blacklist {{ $customer->name }}? Customer bisa order lagi.')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="fas fa-undo me-1"></i> Pulihkan
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-users-slash fa-2x mb-3 d-block opacity-25"></i>
                            Belum ada data customer
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
        <div class="p-3 d-flex justify-content-center">
            {{ $customers->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('swal'))
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
