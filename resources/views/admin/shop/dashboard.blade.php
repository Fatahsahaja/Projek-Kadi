<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard {{ $shop->name }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: white;
            color: #333;
            overflow-x: hidden;
        }

        /* --- LAYOUT UTAMA --- */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR KIRI --- */
        .sidebar {
            width: 280px; /* Lebarkan dikit biar muat Top Singko */
            padding: 40px 25px;
            border-right: 1px solid #eee;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            background-color: #ff6b6b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .user-info h4 {
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
        }

        .user-info p {
            font-size: 0.8rem;
            color: #999;
            margin: 0;
        }

        /* Balance Section */
        .balance-section {
            margin-bottom: 40px;
        }
        .balance-label { font-size: 0.9rem; color: #666; }
        .balance-amount { font-size: 1.6rem; font-weight: 700; color: #000; }

        /* Menu Links (Tambah Stok, dll) */
        .sidebar-menu a {
            display: block;
            color: #999;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 15px;
            transition: 0.3s;
        }
        .sidebar-menu a:hover { color: #f7941d; }

        /* TOP SINGKO CARD */
        .top-singko-box {
            background: #fff9f0;
            border: 1px solid #ffeeba;
            border-radius: 12px;
            padding: 15px;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .top-singko-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #d37b12;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .top-singko-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
        }
        .top-singko-phone {
            font-size: 0.8rem;
            color: #777;
        }

        /* Tombol Logout */
        .btn-logout {
            margin-top: auto;
            border: 1px solid #ff4d4d;
            color: #ff4d4d;
            background: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            width: 100%;
            transition: 0.3s;
        }
        .btn-logout:hover {
            background: #ff4d4d;
            color: white;
        }

        /* --- CONTENT KANAN --- */
        .main-content {
            flex: 1;
            padding: 40px 50px;
        }

        /* Header Area */
        .header-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .page-title { font-size: 2.2rem; font-weight: 700; color: #000; }
        .brand-logo img { height: 65px; width: auto; object-fit: contain; }

        /* TABS Custom Style */
        .nav-tabs { border-bottom: 2px solid #f0f0f0; margin-bottom: 20px; }
        .nav-link {
            border: none;
            color: #bbb;
            font-weight: 600;
            font-size: 1.2rem;
            padding: 10px 25px;
            background: transparent;
        }
        .nav-link.active {
            color: #f7941d;
            border-bottom: 3px solid #f7941d;
            background: transparent;
        }
        .nav-link:hover { border-color: transparent; color: #f7941d; }

        /* TABEL DENGAN GARIS VERTIKAL (Sesuai Gambar) */
        .table-custom { width: 100%; border-collapse: separate; border-spacing: 0; }

        .table-custom th {
            font-weight: 700;
            color: #000;
            padding: 15px 10px;
            border-bottom: 1px solid #ddd;
            /* Garis vertikal ungu tipis di header */
            border-right: 1px solid rgba(100, 50, 255, 0.1);
        }

        .table-custom td {
            padding: 20px 10px;
            vertical-align: top;
            color: #555;
            font-size: 0.9rem;
            /* Garis vertikal ungu tipis di body */
            border-right: 1px solid rgba(100, 50, 255, 0.1);
        }

        /* Hilangkan border kanan di kolom terakhir */
        .table-custom th:last-child,
        .table-custom td:last-child {
            border-right: none;
        }

        /* Status Styling */
        .status-siap {
            background-color: #f7941d;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .status-selesai {
            color: #4caf50;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        @media (max-width: 768px) {
            .dashboard-container { flex-direction: column; }
            .sidebar { width: 100%; border-right: none; border-bottom: 1px solid #eee; }
            .header-area { flex-direction: column-reverse; }
            .table-responsive { overflow-x: auto; }
        }
    </style>
</head>
<body>

    <div class="dashboard-container">

        <aside class="sidebar">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="user-info">
                    <h4>{{ $shop->name }}</h4>
                    <p>Admin</p>
                </div>
            </div>

            <div class="balance-section">
                <div class="balance-label">Tabungan</div>
                <div class="balance-amount">
                    Rp {{ number_format($shop->balance, 0, ',', '.') }}
                </div>
            </div>

            <div class="sidebar-menu">
                <a href="#"><i class="fa-solid fa-plus-circle me-2"></i> Tambah Stok</a>
            </div>

            @php
                $topSingko = $transactions->sortByDesc('total')->first();
            @endphp

            <div class="top-singko-box">
                <div class="top-singko-title"><i class="fa-solid fa-crown"></i> Top Singko</div>
                @if($topSingko)
                    <div class="top-singko-name">{{ $topSingko->cashier_name }}</div> <div class="top-singko-phone">{{ $topSingko->phone }}</div>
                    <div class="text-dark fw-bold mt-1">Rp {{ number_format($topSingko->total, 0, ',', '.') }}</div>
                @else
                    <div class="text-muted small">Belum ada data</div>
                @endif
            </div>

            <form method="POST" action="{{ route('logout') }}" style="margin-top: auto;">
                @csrf
                <button type="submit" class="btn btn-logout">
                    Logout
                </button>
            </form>
        </aside>

        <main class="main-content">

            <div class="header-area">
                <div>
                    </div>
                <a class="brand-logo" href="#">
                    <img src="/images/Logo.png" alt="KADI Logo">
                </a>
            </div>

            <h1 class="page-title">Transaksi</h1>

            <ul class="nav nav-tabs" id="dashboardTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="true">History</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="stok-tab" data-bs-toggle="tab" data-bs-target="#stok" type="button" role="tab" aria-controls="stok" aria-selected="false">Stok</button>
                </li>
            </ul>

            <div class="mb-4 text-muted" style="font-size: 0.9rem;">
                <i class="fa-regular fa-calendar me-2"></i> 1 Jan 2020 - 13 Mar 2021
            </div>

            <div class="tab-content" id="dashboardTabContent">

                <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th style="width: 30%;">Food or Drink</th>
                                    <th>No Telepon</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $tx)
                                <tr>
                                    <td>
                                        {{ $tx->created_at->format('d M Y') }}<br>
                                        <small class="text-muted">{{ $tx->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>{{ $tx->cashier_name }}</td>
                                    <td>{{ Str::limit($tx->items, 50) }}</td>
                                    <td>{{ $tx->phone }}</td>
                                    <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                                    <td>
                                        @if($tx->status === 'SELESAI')
                                            <span class="status-selesai">SELESAI</span>
                                        @else
                                            <span class="status-siap">{{ $tx->status }}?</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada data transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>

                <div class="tab-pane fade" id="stok" role="tabpanel" aria-labelledby="stok-tab">
                    <div class="alert alert-light border text-center p-5">
                        <h4>📦 Data Stok</h4>
                        <p class="text-muted">Fitur manajemen stok akan muncul di sini.</p>
                        <button class="btn btn-warning text-white">Tambah Stok Baru</button>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
