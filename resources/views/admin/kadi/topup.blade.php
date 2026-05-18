<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Saldo — KADI</title>
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
        .table th { background: #f8fafc; color: #374151; font-weight: 600; border: none; padding: 15px; }
        .table td { padding: 15px; vertical-align: middle; border-color: #f0f0f0; }

        .stat-card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); }
        .stat-value { font-size: 1.8rem; font-weight: 700; }
        .stat-label { font-size: 0.85rem; color: #6b7280; margin-top: 4px; }

        .badge-pending { background: #fff7ed; color: #f7941d; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .badge-approved { background: #f0fdf4; color: #10b981; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .badge-rejected { background: #fef2f2; color: #ef4444; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }

        .metode-badge { padding: 3px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; }
        .metode-qris { background: #eff6ff; color: #3b82f6; }
        .metode-dana { background: #eff6ff; color: #0066cc; }
        .metode-gopay { background: #f0fdf4; color: #00aa5b; }
        .metode-cash { background: #f0fdf4; color: #059669; }

        .tab-filter { display: flex; gap: 8px; margin-bottom: 20px; }
        .tab-filter a { padding: 8px 20px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; color: #6b7280; background: white; border: 1px solid #e5e7eb; transition: 0.2s; }
        .tab-filter a.active { background: #f7941d; color: white; border-color: #f7941d; }
        .tab-filter a:hover:not(.active) { border-color: #f7941d; color: #f7941d; }
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

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="font-weight:700;color:#1a1f2e;margin:0;">Manajemen Saldo</h2>
            <small class="text-muted">Kelola top up dan refund saldo siswa</small>
        </div>
        @if($pendingCount + $refundPendingCount > 0)
        <span class="badge bg-danger fs-6 px-3 py-2">
            {{ $pendingCount + $refundPendingCount }} Menunggu Persetujuan
        </span>
        @endif
    </div>

    {{-- TAB SWITCH --}}
    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('admin.kadi.topup', ['tab' => 'topup']) }}"
           class="btn {{ $activeTab === 'topup' ? 'btn-warning text-white' : 'btn-outline-secondary' }} rounded-pill px-4 fw-semibold">
            <i class="fas fa-wallet me-2"></i> Top Up
            @if($pendingCount > 0)
                <span class="badge bg-white text-warning ms-1">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.kadi.topup', ['tab' => 'refund']) }}"
           class="btn {{ $activeTab === 'refund' ? 'btn-warning text-white' : 'btn-outline-secondary' }} rounded-pill px-4 fw-semibold">
            <i class="fas fa-hand-holding-usd me-2"></i> Refund
            @if($refundPendingCount > 0)
                <span class="badge bg-white text-warning ms-1">{{ $refundPendingCount }}</span>
            @endif
        </a>
    </div>

    {{-- ══════════════════════════════════════ --}}
    {{-- TAB: TOP UP                            --}}
    {{-- ══════════════════════════════════════ --}}
    @if($activeTab === 'topup')

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ $pendingCount }}</div>
                <div class="stat-label">Menunggu</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value text-success">{{ $approvedCount }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value text-danger">{{ $rejectedCount }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value" style="color:#f7941d;">
                    Rp {{ number_format($totalApproved, 0, ',', '.') }}
                </div>
                <div class="stat-label">Total Disetujui</div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="tab-filter">
        <a href="{{ route('admin.kadi.topup', ['tab'=>'topup']) }}"
           class="{{ !request('topup_status') ? 'active' : '' }}">Semua</a>
        <a href="{{ route('admin.kadi.topup', ['tab'=>'topup','topup_status'=>'PENDING']) }}"
           class="{{ request('topup_status')==='PENDING' ? 'active' : '' }}">Pending</a>
        <a href="{{ route('admin.kadi.topup', ['tab'=>'topup','topup_status'=>'APPROVED']) }}"
           class="{{ request('topup_status')==='APPROVED' ? 'active' : '' }}">Disetujui</a>
        <a href="{{ route('admin.kadi.topup', ['tab'=>'topup','topup_status'=>'REJECTED']) }}"
           class="{{ request('topup_status')==='REJECTED' ? 'active' : '' }}">Ditolak</a>
    </div>

    {{-- TABLE TOP UP --}}
    <div class="card-custom">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-wallet me-2 text-warning"></i> Daftar Permintaan Top Up</span>
            <small class="text-muted">{{ $topups->total() }} request</small>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th><th>Siswa</th><th>Nominal</th><th>Metode</th>
                        <th>Saldo Sekarang</th><th>Waktu</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topups as $topup)
                    <tr>
                        <td><small class="text-muted">#{{ $topup->id }}</small></td>
                        <td>
                            <div class="fw-semibold">{{ $topup->user->name }}</div>
                            <small class="text-muted">{{ $topup->user->phone }}</small>
                        </td>
                        <td><span class="fw-bold text-success">Rp {{ number_format($topup->amount, 0, ',', '.') }}</span></td>
                        <td>
                            <span class="metode-badge metode-{{ $topup->metode }}">
                                @if($topup->metode === 'qris') 🔲 QRIS
                                @elseif($topup->metode === 'dana') 💙 DANA
                                @elseif($topup->metode === 'gopay') 💚 GoPay
                                @else 💵 Cash @endif
                            </span>
                        </td>
                        <td>Rp {{ number_format($topup->user->balance, 0, ',', '.') }}</td>
                        <td><small class="text-muted">{{ $topup->created_at->format('d M Y H:i') }}</small></td>
                        <td>
                            @if($topup->status === 'PENDING') <span class="badge-pending"> PENDING</span>
                            @elseif($topup->status === 'APPROVED') <span class="badge-approved">APPROVED</span>
                            @else <span class="badge-rejected">REJECTED</span>
                            @endif
                        </td>
                        <td>
                            @if($topup->status === 'PENDING')
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.kadi.topup.approve', $topup->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success rounded-2"
                                        onclick="return confirm('Approve top up Rp {{ number_format($topup->amount, 0, ',', '.') }} untuk {{ $topup->user->name }}?')">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.kadi.topup.reject', $topup->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2"
                                        onclick="return confirm('Tolak request ini?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                            @elseif($topup->status === 'APPROVED')
                                <small class="text-muted">{{ $topup->approved_at?->format('d M H:i') }}</small>
                            @else
                                <small class="text-muted">Ditolak</small>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-wallet fa-2x mb-3 d-block opacity-25"></i>
                            Belum ada permintaan top up
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 d-flex justify-content-center">
            {{ $topups->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- ══════════════════════════════════════ --}}
    {{-- TAB: REFUND                            --}}
    {{-- ══════════════════════════════════════ --}}
    @else

    {{-- STAT CARDS REFUND --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ $refundPendingCount }}</div>
                <div class="stat-label">Menunggu</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value text-success">{{ $refundApprovedCount }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value text-danger">{{ $refundRejectedCount }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value" style="color:#f7941d;">
                    Rp {{ number_format($totalRefunded, 0, ',', '.') }}
                </div>
                <div class="stat-label">Total Direfund</div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="tab-filter">
        <a href="{{ route('admin.kadi.topup', ['tab'=>'refund']) }}"
           class="{{ !request('refund_status') ? 'active' : '' }}">Semua</a>
        <a href="{{ route('admin.kadi.topup', ['tab'=>'refund','refund_status'=>'PENDING']) }}"
           class="{{ request('refund_status')==='PENDING' ? 'active' : '' }}">Pending</a>
        <a href="{{ route('admin.kadi.topup', ['tab'=>'refund','refund_status'=>'APPROVED']) }}"
           class="{{ request('refund_status')==='APPROVED' ? 'active' : '' }}">Disetujui</a>
        <a href="{{ route('admin.kadi.topup', ['tab'=>'refund','refund_status'=>'REJECTED']) }}"
           class="{{ request('refund_status')==='REJECTED' ? 'active' : '' }}">Ditolak</a>
    </div>

    {{-- TABLE REFUND --}}
    <div class="card-custom">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-hand-holding-usd me-2 text-warning"></i> Daftar Permintaan Refund</span>
            <small class="text-muted">{{ $refunds->total() }} request</small>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th><th>Siswa</th><th>Nominal</th><th>E-Wallet</th>
                        <th>No. Rekening</th><th>Waktu</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($refunds as $refund)
                    <tr>
                        <td><small class="text-muted">#{{ $refund->id }}</small></td>
                        <td>
                            <div class="fw-semibold">{{ $refund->user->name }}</div>
                            <small class="text-muted">{{ $refund->user->phone }}</small>
                        </td>
                        <td><span class="fw-bold text-success">Rp {{ number_format($refund->amount, 0, ',', '.') }}</span></td>
                        <td>
                            <span class="metode-badge" style="background:#eff6ff;color:#3b82f6;">
                                {{ $refund->ewallet_type }}
                            </span>
                        </td>
                        <td class="fw-medium">{{ $refund->ewallet_number }}</td>
                        <td><small class="text-muted">{{ $refund->created_at->format('d M Y H:i') }}</small></td>
                        <td>
                            @if($refund->status === 'PENDING') <span class="badge-pending">PENDING</span>
                            @elseif($refund->status === 'APPROVED') <span class="badge-approved">APPROVED</span>
                            @else <span class="badge-rejected">REJECTED</span>
                            @endif
                        </td>
                        <td>
                            @if($refund->status === 'PENDING')
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.kadi.refund.approve', $refund->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success rounded-2"
                                        onclick="return confirm('Setujui refund Rp {{ number_format($refund->amount, 0, ',', '.') }} ke {{ $refund->ewallet_type }} {{ $refund->ewallet_number }}?')">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-2"
                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $refund->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            {{-- Modal Tolak --}}
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
                                                    Saldo <strong>Rp {{ number_format($refund->amount, 0, ',', '.') }}</strong>
                                                    akan dikembalikan ke <strong>{{ $refund->user->name }}</strong>.
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
                                <small class="text-danger" title="{{ $refund->notes }}">{{ Str::limit($refund->notes, 25) }}</small>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-hand-holding-usd fa-2x mb-3 d-block opacity-25"></i>
                            Belum ada permintaan refund
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 d-flex justify-content-center">
            {{ $refunds->links('pagination::bootstrap-5') }}
        </div>
    </div>

    @endif

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
