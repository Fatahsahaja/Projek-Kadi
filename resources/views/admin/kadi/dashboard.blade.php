<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin KADI — Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #1a1f2e;
            position: fixed;
            top: 0; left: 0;
            padding: 30px 0;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            margin: 0;
        }
        .sidebar-brand span { color: #f7941d; }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 25px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            color: white;
            background: rgba(247,148,29,0.1);
            border-left-color: #f7941d;
        }
        .sidebar-menu a i { width: 20px; text-align: center; }
        .sidebar-footer {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 20px 25px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* MAIN */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .topbar h2 { font-weight: 700; color: #1a1f2e; margin: 0; }
        .admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 8px 15px;
            border-radius: 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .admin-avatar {
            width: 35px; height: 35px;
            background: #f7941d;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 0.9rem;
        }

        /* STATS CARDS */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            border-left: 4px solid;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card.orange { border-color: #f7941d; }
        .stat-card.blue   { border-color: #3b82f6; }
        .stat-card.green  { border-color: #10b981; }
        .stat-card.red    { border-color: #ef4444; }
        .stat-icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 15px;
        }
        .stat-card.orange .stat-icon { background: #fff7ed; color: #f7941d; }
        .stat-card.blue   .stat-icon { background: #eff6ff; color: #3b82f6; }
        .stat-card.green  .stat-icon { background: #f0fdf4; color: #10b981; }
        .stat-card.red    .stat-icon { background: #fef2f2; color: #ef4444; }
        .stat-value { font-size: 1.8rem; font-weight: 700; color: #1a1f2e; }
        .stat-label { color: #6b7280; font-size: 0.85rem; margin-top: 5px; }

        /* CARDS */
        .card-custom {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            border: none;
        }
        .card-custom .card-header {
            background: transparent;
            border-bottom: 1px solid #f0f0f0;
            padding: 20px 25px;
            font-weight: 600;
            color: #1a1f2e;
        }
        .card-custom .card-body { padding: 25px; }

        /* SHOP CARDS */
        .shop-stat-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #e2e8f0;
        }
        .shop-stat-card h6 { color: #f7941d; font-weight: 600; margin-bottom: 8px; }
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

{{-- MAIN CONTENT --}}
<main class="main-content">

    {{-- TOPBAR --}}
    <div class="topbar">
        <div>
            <h2>Dashboard</h2>
            <small class="text-muted">Selamat datang, {{ auth()->user()->name }}</small>
        </div>
        <div class="admin-info">
            <div class="admin-avatar">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <div style="font-size:0.85rem; font-weight:600;">{{ auth()->user()->name }}</div>
                <div style="font-size:0.75rem; color:#6b7280;">Admin KADI</div>
            </div>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card orange">
                <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pendapatan</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card blue">
                <div class="stat-icon"><i class="fas fa-receipt"></i></div>
                <div class="stat-value">{{ number_format($totalTransaksi) }}</div>
                <div class="stat-label">Total Transaksi</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card green">
                <div class="stat-icon"><i class="fas fa-store"></i></div>
                <div class="stat-value">{{ $totalWarung }}</div>
                <div class="stat-label">Warung Aktif</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card red">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-value">{{ $totalPending }}</div>
                <div class="stat-label">Pesanan Pending</div>
            </div>
        </div>
    </div>

    {{-- GRAFIK + WARUNG --}}
    <div class="row g-4 mb-4">

        {{-- Grafik Transaksi --}}
        <div class="col-lg-8">
            <div class="card-custom mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-chart-bar me-2 text-warning"></i> Jumlah Transaksi 7 Hari Terakhir</span>
                    <small class="text-muted">per hari</small>
                </div>
                <div class="card-body">
                    <canvas id="grafikTransaksi" height="120"></canvas>
                </div>
            </div>
            <div class="card-custom">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-chart-line me-2 text-warning"></i> Pendapatan 7 Hari Terakhir</span>
                    <small class="text-muted">dalam Rupiah</small>
                </div>
                <div class="card-body">
                    <canvas id="grafikPendapatan" height="120"></canvas>
                </div>
            </div>
        </div>

        {{-- Ringkasan Warung --}}
        <div class="col-lg-4">
            <div class="card-custom h-100">
                <div class="card-header">
                    <i class="fas fa-store me-2 text-warning"></i>
                    Pendapatan per Warung
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        @foreach($shops as $shop)
                        <div class="shop-stat-card">
                            <h6>{{ $shop->name }}</h6>
                            <div class="d-flex justify-content-between text-sm">
                                <small class="text-muted">{{ $shop->transactions_count }} transaksi</small>
                                <small class="fw-bold">Rp {{ number_format($shop->transactions_sum_total ?? 0, 0, ',', '.') }}</small>
                            </div>
                            {{-- Progress bar --}}
                            @php
                                $persen = $totalPendapatan > 0
                                    ? ($shop->transactions_sum_total / $totalPendapatan) * 100
                                    : 0;
                            @endphp
                            <div class="progress mt-2" style="height:4px;">
                                <div class="progress-bar bg-warning" style="width:{{ $persen }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

{{-- SweetAlert --}}
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

{{-- Chart.js Grafik --}}
<script>
    const labels        = @json($grafik->pluck('tanggal'));
    const dataTransaksi = @json($grafik->pluck('total_transaksi'));
    const dataPendapatan = @json($grafik->pluck('total_pendapatan'));

    // ── BAR CHART: Jumlah Transaksi ──
    new Chart(document.getElementById('grafikTransaksi'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: dataTransaksi,
                backgroundColor: 'rgba(247,148,29,0.85)',
                borderColor: '#f7941d',
                borderWidth: 0,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} transaksi`
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                }
            }
        }
    });

    // ── LINE CHART: Pendapatan ──
    new Chart(document.getElementById('grafikPendapatan'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan',
                data: dataPendapatan,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.08)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3b82f6',
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` Rp ${ctx.parsed.y.toLocaleString('id-ID')}`
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: {
                        callback: val => 'Rp ' + val.toLocaleString('id-ID')
                    }
                }
            }
        }
    });
</script>

</body>
</html>
