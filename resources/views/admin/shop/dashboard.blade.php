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
            width: 250px;
            padding: 40px 20px;
            border-right: 1px solid #eee; /* Garis tipis pemisah */
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background-color: #ff6b6b; /* Warna pink/merah kayak di gambar */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .user-avatar i {
            font-size: 40px;
            color: white;
        }

        .user-name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .balance-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .balance-amount {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 40px;
            color: #000;
        }

        .sidebar-menu {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .menu-link {
            color: #999;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .menu-link:hover {
            color: #f7941d;
        }

        /* Tombol Logout kita styling simpel */
        .btn-logout {
            margin-top: auto; /* Dorong ke paling bawah */
            border: 1px solid #ff4d4d;
            color: #ff4d4d;
            background: white;
            padding: 5px 20px;
            border-radius: 20px;
            font-size: 0.8rem;
            transition: 0.3s;
        }
        .btn-logout:hover {
            background: #ff4d4d;
            color: white;
        }

        /* --- CONTENT KANAN --- */
        .main-content {
            flex: 1;
            padding: 40px 60px;
        }

        /* Header Area (Logo di Kanan) */
        .header-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #000;
        }

        /* Logo Styling (Reuse yang tadi) */
        .brand-logo img {
            height: 60px;
            width: auto;
            object-fit: contain;
        }

        /* Tabs (History / Stok) */
        .nav-tabs {
            border-bottom: 2px solid #eee;
            margin-bottom: 30px;
        }

        .nav-link {
            border: none;
            color: #999;
            font-weight: 600;
            font-size: 1.2rem;
            padding-bottom: 10px;
            margin-right: 30px;
        }

        .nav-link.active {
            color: #f7941d; /* Warna Orange */
            border-bottom: 3px solid #f7941d;
            background: transparent;
        }

        /* Table Styling - Minimalis */
        .table-custom {
            width: 100%;
        }

        .table-custom th {
            font-weight: 600;
            color: #000;
            border-bottom: 1px solid #eee;
            padding: 15px 10px;
            font-size: 0.95rem;
        }

        .table-custom td {
            padding: 20px 10px;
            border-bottom: 1px solid #f5f5f5;
            color: #555;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        /* Status Badges */
        .status-text {
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-siap { color: #f7941d; } /* Orange */
        .status-selesai { color: #4caf50; } /* Hijau */

        /* Responsive Mobile */
        @media (max-width: 768px) {
            .dashboard-container { flex-direction: column; }
            .sidebar { width: 100%; border-right: none; border-bottom: 1px solid #eee; }
            .main-content { padding: 20px; }
            .header-area { flex-direction: column-reverse; gap: 20px; }
            .brand-logo { align-self: flex-end; }
        }
    </style>
</head>
<body>

    <div class="dashboard-container">

        <aside class="sidebar">
            <div class="user-avatar">
                <i class="fa-solid fa-user"></i>
            </div>

            <h3 class="user-name">{{ $shop->name }}</h3>

            <div class="balance-label">Tabungan</div>
            <div class="balance-amount">
                Rp {{ number_format($shop->balance, 0, ',', '.') }}
            </div>

            <div class="sidebar-menu">
                <a href="#" class="menu-link" style="color: #999;">Tambah Stok</a>
                <a href="#" class="menu-link" style="color: #999;">Top Singko</a>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="margin-top: auto;">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
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

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#">History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Stok</a>
                </li>
            </ul>

            <div class="mb-4 text-muted" style="font-size: 0.9rem;">
                <i class="fa-regular fa-calendar"></i> 1 Jan 20 - 13 Mar 21
            </div>

            <div class="table-responsive">
                <table class="table table-custom table-borderless">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name (Kasir)</th>
                            <th>Food or Drink</th>
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

                            <td style="max-width: 250px;">
                                {{ Str::limit($tx->items, 40) }}
                            </td>

                            <td>{{ $tx->phone }}</td>

                            <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>

                            <td>
                                @if($tx->status === 'SELESAI')
                                    <span class="status-text status-selesai">SELESAI</span>
                                @else
                                    <span class="status-text status-siap">{{ $tx->status }}?</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Belum ada riwayat transaksi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $transactions->links() }}
            </div>

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
