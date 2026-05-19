<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan — KADI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #fff; overflow-x: hidden; }

        .navbar-kadi {
            background: white;
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .logo-text {
            font-weight: 700;
            font-size: 26px;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
        }

        .decoration-wave {
            position: fixed;
            bottom: 0; left: 0;
            width: 250px; height: 150px;
            background: #ff9f1c;
            border-top-right-radius: 100%;
            z-index: -1;
        }

        .tx-card {
            border: 1px solid #f0f0f0;
            border-radius: 16px;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            transition: 0.2s;
            margin-bottom: 15px;
        }

        .tx-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .status-pending  { background:#fff7ed; color:#f7941d; padding:4px 12px; border-radius:6px; font-size:0.8rem; font-weight:600; }
        .status-sukses   { background:#f0fdf4; color:#10b981; padding:4px 12px; border-radius:6px; font-size:0.8rem; font-weight:600; }
        .status-siap    { background:#ecfdf5; color:#10b981; padding:4px 12px; border-radius:6px; font-size:0.8rem; font-weight:600; }
        .status-selesai  { background:#eff6ff; color:#3b82f6; padding:4px 12px; border-radius:6px; font-size:0.8rem; font-weight:600; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar-kadi sticky-top">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="{{ route('customer.menu') }}" class="text-decoration-none">
            <div class="logo-text text-dark">
                K <i class="bi bi-x-diamond-fill text-warning mx-1"></i> DI
            </div>
        </a>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('customer.menu') }}" class="btn btn-outline-warning rounded-pill btn-sm px-3">
                <i class="bi bi-shop me-1"></i> Menu
            </a>
            <div class="d-flex align-items-center gap-2">
                <div style="width:35px;height:35px;background:#e9ecef;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-person-fill text-secondary"></i>
                </div>
                <span class="fw-medium d-none d-sm-block" style="font-size:0.9rem;">
                    {{ auth()->user()->name }}
                </span>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container py-5" style="max-width: 700px;">

    {{-- Header --}}
    <div class="mb-4">
        <h2 class="fw-bold">📋 Riwayat Pesanan</h2>
        <p class="text-muted">Semua pesanan yang pernah kamu buat</p>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="text-center p-3 rounded-3 border">
                <div class="fw-bold fs-4">{{ $transactions->total() }}</div>
                <small class="text-muted">Total Pesanan</small>
            </div>
        </div>
        <div class="col-4">
            <div class="text-center p-3 rounded-3 border">
                <div class="fw-bold fs-4 text-success">
                    {{ $transactions->getCollection()->where('status','SELESAI')->count() }}
                </div>
                <small class="text-muted">Sukses</small>
            </div>
        </div>
        <div class="col-4">
            <div class="text-center p-3 rounded-3 border">
                <div class="fw-bold fs-4 text-warning">
                    {{ $transactions->getCollection()->where('status','PENDING')->count() + $transactions->getCollection()->where('status','SIAP')->count() }}
                </div>
                <small class="text-muted">Pending</small>
            </div>
        </div>
    </div>

    {{-- List Transaksi --}}
    @forelse($transactions as $tx)
    <div class="tx-card">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
                <span class="fw-bold">#{{ $tx->id }}</span>
                <span class="text-muted ms-2" style="font-size:0.85rem;">{{ $tx->shop->name }}</span>
            </div>
           @if($tx->status === 'PENDING')
    <span class="status-pending"> PENDING</span>
@elseif($tx->status === 'SIAP')
    <span class="status-siap"> SIAP DIAMBIL</span>
@elseif($tx->status === 'SUKSES')
    <span class="status-sukses">SUKSES</span>
@elseif($tx->status === 'SELESAI')
    <span class="status-selesai"> SELESAI</span>
@elseif($tx->status === 'DIBATALKAN')
    <span style="background:#fef2f2;color:#ef4444;padding:4px 12px;border-radius:6px;font-size:0.8rem;font-weight:600;">❌ DIBATALKAN</span>
@endif
        </div>

        {{-- Items --}}
        @php
            $items = is_array($tx->items) ? $tx->items : json_decode($tx->items, true);
        @endphp
        <div class="mb-2">
            @if(is_array($items))
                @foreach($items as $item)
                    <small class="text-muted">{{ $item['name'] }} x{{ $item['quantity'] ?? 1 }}</small>
                    @if(!$loop->last) <span class="text-muted mx-1">·</span> @endif
                @endforeach
            @endif
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-bold text-warning">Rp {{ number_format($tx->total, 0, ',', '.') }}</span>
                <small class="text-muted ms-2">{{ $tx->created_at->format('d M Y H:i') }}</small>
            </div>
            @if($tx->confirmation_token)
<div class="d-flex gap-2">
    <a href="{{ route('transactions.confirmByQR', $tx->confirmation_token) }}"
       class="btn btn-sm btn-outline-warning rounded-pill px-3">
        Detail
    </a>
    @if($tx->status === 'PENDING')
    <button type="button"
        class="btn btn-sm btn-outline-danger rounded-pill px-3"
        onclick="confirmCancel({{ $tx->id }})">
        Batalkan
    </button>
    @endif
</div>
@endif
        </div>
    </div>
    @empty
    <div class="text-center py-5 text-muted">
        <i class="bi bi-receipt display-1 opacity-25"></i>
        <p class="mt-3">Belum ada pesanan nih! Yuk pesan sekarang.</p>
        <a href="{{ route('customer.menu') }}" class="btn btn-warning rounded-pill text-white px-4">
            Lihat Menu
        </a>
    </div>
    @endforelse

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $transactions->links('pagination::bootstrap-5') }}
    </div>

</div>

<div class="decoration-wave"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmCancel(id) {
    Swal.fire({
        icon: 'warning',
        title: 'Batalkan Pesanan?',
        text: 'Pesanan ini akan dibatalkan dan tidak bisa dikembalikan.',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Batalkan!',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('cancelForm-' + id).submit();
        }
    });
}
</script>

@foreach($transactions as $tx)
@if($tx->status === 'PENDING')
<form id="cancelForm-{{ $tx->id }}"
      action="{{ route('transactions.cancel', $tx->id) }}"
      method="POST" style="display:none;">
    @csrf
    @method('PATCH')
</form>
@endif
@endforeach

@if(session('swal'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: "{{ session('swal.type') }}",
            title: "{{ session('swal.title') }}",
            text: "{{ session('swal.text') }}",
            confirmButtonColor: "#f7941d",
        });
    });
</script>
@endif
</body>
</html>
