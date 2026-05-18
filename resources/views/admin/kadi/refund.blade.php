<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Refund — Admin KADI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
        .sidebar {
            width: 260px; min-height: 100vh; background: #1a1f2e;
            position: fixed; top: 0; left: 0; padding: 30px 0; z-index: 100;
        }
        .sidebar-brand { padding: 0 25px 30px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .sidebar-brand h4 { color: white; font-weight: 700; font-size: 1.3rem; margin: 0; }
        .sidebar-brand span { color: #f7941d; }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 12px; padding: 12px 25px;
            color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;
            font-weight: 500; transition: 0.2s; border-left: 3px solid transparent;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            color: white; background: rgba(247,148,29,0.1); border-left-color: #f7941d;
        }
        .sidebar-menu a i { width: 20px; text-align: center; }
        .sidebar-footer {
            position: absolute; bottom: 0; left: 0; right: 0;
            padding: 20px 25px; border-top: 1px solid rgba(255,255,255,0.1);
        }
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .topbar h2 { font-weight: 700; color: #1a1f2e; margin: 0; }
        .stat-card {
            background: white; border-radius: 16px; padding: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05); border-left: 4px solid;
        }
        .stat-card.orange { border-color: #f7941d; }
        .stat-card.green  { border-color: #10b981; }
        .stat-card.red    { border-color: #ef4444; }
        .stat-card.blue   { border-color: #3b82f6; }
        .stat-icon {
            width: 45px; height: 45px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 12px;
        }
        .stat-card.orange .stat-icon { background: #fff7ed; color: #f7941d; }
        .stat-card.green  .stat-icon { background: #f0fdf4; color: #10b981; }
        .stat-card.red    .stat-icon { background: #fef2f2; color: #ef4444; }
        .stat-card.blue   .stat-icon { background: #eff6ff; color: #3b82f6; }
        .stat-value { font-size: 1.5rem; font-weight: 700; color: #1a1f2e; }
        .stat-label { color: #6b7280; font-size: 0.82rem; margin-top: 4px; }
        .card-custom {
            background: white; border-radius: 16px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05); border: none;
        }
        .card-custom .card-header {
            background: transparent; border-bottom: 1px solid #f0f0f0;
            padding: 18px 24px; font-weight: 600; color: #1a1f2e;
        }
        .badge-pending  { background: #fff7ed; color: #f7941d; }
        .badge-approved { background: #f0fdf4; color: #10b981; }
        .badge-rejected { background: #fef2f2; color: #ef4444; }
        .ewallet-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: #f0f7ff; color: #3b82f6;
            padding: 3px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600;
        }
        .logo-img {
            height: 55px;
            object-fit: contain;
            width: auto;
        }
    </style>
</head>
<body>

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

<main class="main-content">

    <div class="topbar">
        <div>
            <h2>Manajemen Refund</h2>
            <small class="text-muted">Kelola permintaan refund saldo siswa</small>
        </div>
    </div>

    {{-- STATS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card orange">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-value">{{ $pendingCount }}</div>
                <div class="stat-label">Menunggu</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card green">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-value">{{ $approvedCount }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card red">
                <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                <div class="stat-value">{{ $rejectedCount }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card blue">
                <div class="stat-icon"><i class="fas fa-hand-holding-usd"></i></div>
                <div class="stat-value">Rp {{ number_format($totalRefunded, 0, ',', '.') }}</div>
                <div class="stat-label">Total Direfund</div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card-custom mb-4">
        <div class="card-body p-3">
            <form method="GET" class="d-flex gap-3 align-items-end flex-wrap">
                <div>
                    <label class="form-label small fw-semibold mb-1">Status</label>
                    <select name="status" class="form-select form-select-sm" style="min-width:150px;">
                        <option value="">Semua Status</option>
                        <option value="PENDING"   {{ request('status') === 'PENDING'   ? 'selected' : '' }}>Menunggu</option>
                        <option value="APPROVED"  {{ request('status') === 'APPROVED'  ? 'selected' : '' }}>Disetujui</option>
                        <option value="REJECTED"  {{ request('status') === 'REJECTED'  ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning btn-sm text-white px-4">Filter</button>
                @if(request('status'))
                    <a href="{{ route('admin.kadi.refund') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                @endif
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card-custom">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-hand-holding-usd me-2 text-warning"></i>Daftar Permintaan Refund</span>
            <small class="text-muted">{{ $refunds->total() }} total</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:0.88rem;">
                    <thead style="background:#f8fafc;">
                        <tr>
                            <th class="ps-4 py-3">#</th>
                            <th>Siswa</th>
                            <th>Nominal</th>
                            <th>E-Wallet</th>
                            <th>No. Rekening</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($refunds as $refund)
                        <tr>
                            <td class="ps-4 py-3 text-muted">#{{ $refund->id }}</td>
                            <td>
                                <div class="fw-semibold">{{ $refund->user->name }}</div>
                                <small class="text-muted">{{ $refund->user->phone }}</small>
                            </td>
                            <td class="fw-bold text-success">
                                Rp {{ number_format($refund->amount, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="ewallet-badge">
                                    {{ $refund->ewallet_type }}
                                </span>
                            </td>
                            <td class="fw-medium">{{ $refund->ewallet_number }}</td>
                            <td>
                                @if($refund->status === 'PENDING')
                                    <span class="badge badge-pending px-3 py-2 rounded-pill">⏳ Menunggu</span>
                                @elseif($refund->status === 'APPROVED')
                                    <span class="badge badge-approved px-3 py-2 rounded-pill">✅ Disetujui</span>
                                @else
                                    <span class="badge badge-rejected px-3 py-2 rounded-pill">❌ Ditolak</span>
                                @endif
                            </td>
                            <td class="text-muted" style="font-size:0.8rem;">
                                {{ $refund->created_at->format('d M Y') }}<br>
                                {{ $refund->created_at->format('H:i') }}
                            </td>
                            <td class="text-center pe-4">
                                @if($refund->status === 'PENDING')
                                <div class="d-flex gap-2 justify-content-center">
                                    {{-- Approve --}}
                                    <form action="{{ route('admin.kadi.refund.approve', $refund->id) }}" method="POST"
                                          onsubmit="return confirm('Setujui refund Rp {{ number_format($refund->amount, 0, ',', '.') }} ke {{ $refund->ewallet_type }} {{ $refund->ewallet_number }}?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                            ✅ Setujui
                                        </button>
                                    </form>

                                    {{-- Reject --}}
                                    <button type="button" class="btn btn-sm btn-danger rounded-pill px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $refund->id }}">
                                        ❌ Tolak
                                    </button>
                                </div>

                                {{-- Modal Reject --}}
                                <div class="modal fade" id="rejectModal{{ $refund->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow rounded-4">
                                            <div class="modal-header border-0">
                                                <h6 class="modal-title fw-bold">Tolak Permintaan Refund</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.kadi.refund.reject', $refund->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body pt-0">
                                                    <p class="text-muted small mb-3">
                                                        Saldo Rp {{ number_format($refund->amount, 0, ',', '.') }}
                                                        akan dikembalikan ke akun <strong>{{ $refund->user->name }}</strong>.
                                                    </p>
                                                    <label class="form-label small fw-semibold">Alasan Penolakan (opsional)</label>
                                                    <textarea name="notes" class="form-control rounded-3" rows="3"
                                                        placeholder="Contoh: Nomor e-wallet tidak valid..."></textarea>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4">Tolak & Kembalikan Saldo</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @elseif($refund->status === 'APPROVED')
                                    <small class="text-muted">{{ $refund->approved_at?->format('d M H:i') }}</small>
                                @else
                                    <small class="text-danger" title="{{ $refund->notes }}">
                                        {{ Str::limit($refund->notes, 30) }}
                                    </small>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block opacity-25"></i>
                                Belum ada permintaan refund
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($refunds->hasPages())
            <div class="d-flex justify-content-center py-3">
                {{ $refunds->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
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
