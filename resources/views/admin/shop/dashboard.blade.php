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
        @media (max-width: 768px) {
    .dashboard-container {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        border-right: none;
        border-bottom: 1px solid #eee;
        padding: 20px 15px;
    }

    .balance-section {
        margin-bottom: 20px;
    }

    .top-singko-box {
        margin-top: 10px;
        margin-bottom: 15px;
    }

    .main-content {
        padding: 20px 15px;
    }

    .page-title {
        font-size: 1.6rem;
    }

    /* Sembunyiin kolom yang tidak penting di HP */
    .table-custom th:nth-child(4),
    .table-custom td:nth-child(4) {
        display: none; /* sembunyiin No Telepon */
    }

    .table-custom th:nth-child(5),
    .table-custom td:nth-child(5) {
        display: none; /* sembunyiin Total */
    }

    .table-custom td {
        padding: 12px 6px;
        font-size: 0.8rem;
    }

    .table-custom th {
        padding: 10px 6px;
        font-size: 0.8rem;
    }

    /* Filter tanggal */
    .main-content form > div:first-child {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .brand-logo img {
        height: 45px;
    }

    /* Shortcut buttons wrap */
    .main-content form {
        gap: 6px !important;
    }
}
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
            width: 280px;
            /* Lebarkan dikit biar muat Top Singko */
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

        .balance-label {
            font-size: 0.9rem;
            color: #666;
        }

        .balance-amount {
            font-size: 1.6rem;
            font-weight: 700;
            color: #000;
        }

        /* Menu Links (Tambah Stok, dll) */
        .sidebar-menu a {
            display: block;
            color: #999;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 15px;
            transition: 0.3s;
        }

        .sidebar-menu a:hover {
            color: #f7941d;
        }

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

        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #000;
        }

        .brand-logo img {
            height: 65px;
            width: auto;
            object-fit: contain;
        }

        /* TABS Custom Style */
        .nav-tabs {
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 20px;
        }

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

        .nav-link:hover {
            border-color: transparent;
            color: #f7941d;
        }

        /* TABEL DENGAN GARIS VERTIKAL (Sesuai Gambar) */
        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

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
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #eee;
            }

            .header-area {
                flex-direction: column-reverse;
            }

            .table-responsive {
                overflow-x: auto;
            }
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
                <a href="{{ route('dashboard', ['tab' => 'stok']) }}">
    <i class="fa-solid fa-box me-2"></i> Manajemen Produk
</a>
                {{-- Tambah ini --}}
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalKasir">
                    <i class="fa-solid fa-cash-register me-2"></i> Kasir Manual
                </a>
            </div>

            @php
                $topSingko = $transactions->sortByDesc('total')->first();
            @endphp

            <div class="top-singko-box">
                <div class="top-singko-title"><i class="fa-solid fa-crown"></i> Top Singko</div>
                @if ($topSingko)
                    <div class="top-singko-name">{{ $topSingko->cashier_name }}</div>
                    <div class="top-singko-phone">{{ $topSingko->phone }}</div>
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

            <h1 class="page-title">
                Transaksi
                <span id="pending-badge" class="d-none badge rounded-pill ms-2"
                    style="background:#f7941d; font-size:0.8rem; vertical-align:middle;">
                    0 Pending
                </span>
            </h1>

            <ul class="nav nav-tabs" id="dashboardTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="history-tab" data-bs-toggle="tab" data-bs-target="#history"
                        type="button" role="tab" aria-controls="history" aria-selected="true">History</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="stok-tab" data-bs-toggle="tab" data-bs-target="#stok" type="button"
                        role="tab" aria-controls="stok" aria-selected="false">Stok</button>
                </li>
            </ul>

            <div class="tab-content" id="dashboardTabContent">

                <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">

    <form method="GET" action="{{ route('dashboard') }}"
        class="d-flex align-items-center gap-2 mb-4 flex-wrap">
        <div style="background:#fff7ed; border:1px solid #fed7aa; border-radius:10px; padding:8px 16px;
            display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <i class="fa-regular fa-calendar" style="color:#f7941d;"></i>
            <input type="date" name="dari" value="{{ $dari }}" class="border-0 bg-transparent"
                style="outline:none; font-size:0.9rem; color:#555;">
            <span style="color:#ccc;">—</span>
            <input type="date" name="sampai" value="{{ $sampai }}" class="border-0 bg-transparent"
                style="outline:none; font-size:0.9rem; color:#555;">
            <button type="submit"
                style="background:#f7941d; color:white; border:none; border-radius:8px;
                   padding:5px 16px; font-size:0.85rem; font-weight:600; cursor:pointer;">
                Cari
            </button>
        </div>
        <a href="{{ route('dashboard', ['dari' => now()->format('Y-m-d'), 'sampai' => now()->format('Y-m-d')]) }}"
            style="background:{{ request('dari') == now()->format('Y-m-d') && request('sampai') == now()->format('Y-m-d') ? '#f7941d' : 'white' }};
            color:{{ request('dari') == now()->format('Y-m-d') ? 'white' : '#555' }};
            border:1px solid #eee; border-radius:8px; padding:6px 14px;
            font-size:0.82rem; font-weight:600; text-decoration:none;">
            Hari Ini
        </a>
        <a href="{{ route('dashboard', ['dari' => now()->startOfWeek()->format('Y-m-d'), 'sampai' => now()->format('Y-m-d')]) }}"
            style="background:white; color:#555; border:1px solid #eee; border-radius:8px;
            padding:6px 14px; font-size:0.82rem; font-weight:600; text-decoration:none;">
            Minggu Ini
        </a>
        <a href="{{ route('dashboard', ['dari' => now()->startOfMonth()->format('Y-m-d'), 'sampai' => now()->format('Y-m-d')]) }}"
            style="background:white; color:#555; border:1px solid #eee; border-radius:8px;
            padding:6px 14px; font-size:0.82rem; font-weight:600; text-decoration:none;">
            Bulan Ini
        </a>
    </form>

    <div id="table-wrapper">
        @include('admin.shop.partials.transaction-table')
    </div>
</div>

                <div class="tab-pane fade" id="stok" role="tabpanel" aria-labelledby="stok-tab">

                    {{-- Stats --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 border text-center">
                                <div style="font-size:1.6rem; font-weight:700;">{{ $products->count() }}</div>
                                <div class="text-muted small">Total Produk</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 border text-center">
                                <div style="font-size:1.6rem; font-weight:700; color:#10b981;">
                                    {{ $products->where('is_available', true)->count() }}
                                </div>
                                <div class="text-muted small">Tersedia</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 border text-center">
                                <div style="font-size:1.6rem; font-weight:700; color:#ef4444;">
                                    {{ $products->where('stock', '<=', 5)->count() }}
                                </div>
                                <div class="text-muted small">Stok Menipis</div>
                            </div>
                        </div>
                    </div>

                    {{-- Header + Tombol Tambah --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Daftar Produk — </h5>
                        <button class="btn btn-sm fw-bold px-4 rounded-3" style="background:#f7941d; color:white;"
                            data-bs-toggle="modal" data-bs-target="#modalTambah">
                            + Tambah Produk
                        </button>
                    </div>

                    {{-- Grid Produk --}}
                    @if ($products->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <div style="font-size:3rem; opacity:0.2;">📦</div>
                            <p class="mt-2">Belum ada produk. Tambah sekarang!</p>
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach ($products as $product)
                                <div class="col-md-3 col-sm-6">
                                    <div class="border rounded-4 overflow-hidden"
                                        style="box-shadow:0 2px 10px rgba(0,0,0,0.05); transition:0.2s;"
                                        onmouseover="this.style.transform='translateY(-3px)'"
                                        onmouseout="this.style.transform='translateY(0)'">

                                        {{-- Gambar --}}
                                        @if ($product->image)
                                            @if (str_starts_with($product->image, '/images/'))
                                                <img src="{{ asset($product->image) }}"
                                                    style="width:100%; height:140px; object-fit:cover;">
                                            @else
                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                    style="width:100%; height:140px; object-fit:cover;">
                                            @endif
                                        @else
                                            <div
                                                style="width:100%; height:140px; background:#f8f9fa;
                                    display:flex; align-items:center; justify-content:center;
                                    font-size:2.5rem; color:#ddd;">
                                                🍽️</div>
                                        @endif

                                        <div class="p-3">
                                            <div class="fw-semibold mb-1" style="font-size:0.9rem;">
                                                {{ $product->name }}</div>
                                            <div style="color:#f7941d; font-weight:700; font-size:1rem;">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </div>
                                            <div class="mb-2 {{ $product->stock <= 5 ? 'text-danger fw-semibold' : 'text-muted' }}"
                                                style="font-size:0.8rem;">
                                                Stok: {{ $product->stock }} {{ $product->stock <= 5 ? '⚠️' : '' }}
                                            </div>

                                            {{-- Toggle --}}
                                            <form action="{{ route('admin.shop.products.toggle', $product->id) }}"
                                                method="POST" class="mb-2">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm w-100 rounded-3
                                    {{ $product->is_available ? 'btn-success' : 'btn-outline-secondary' }}"
                                                    style="font-size:0.8rem;">
                                                    {{ $product->is_available ? '✅ Tersedia' : '❌ Nonaktif' }}
                                                </button>
                                            </form>

                                            {{-- Edit + Hapus --}}
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-outline-warning w-100 rounded-3"
                                                    style="font-size:0.8rem;"
                                                    onclick="editProduk(
                                        {{ $product->id }},
                                        '{{ addslashes($product->name) }}',
                                        {{ $product->price }},
                                        {{ $product->stock }},
                                        {{ $product->is_available ? 1 : 0 }}
                                    )">
                                                    ✏️ Edit
                                                </button>
                                                <form
                                                    action="{{ route('admin.shop.products.destroy', $product->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus {{ addslashes($product->name) }}?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-3"
                                                        style="font-size:0.8rem;">🗑️</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>

            </div>

        </main>
    </div>

    {{-- MODAL TAMBAH PRODUK --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header rounded-top-4" style="background:#f7941d; color:white;">
                    <h5 class="modal-title fw-bold">➕ Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        style="filter:brightness(0) invert(1);"></button>
                </div>
                <form action="{{ route('admin.shop.products.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Produk <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3"
                                placeholder="contoh: Nasi Goreng" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control rounded-3"
                                    placeholder="5000" min="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Stok</label>
                                <input type="number" name="stock" class="form-control rounded-3" placeholder="50"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Produk</label>
                            <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                            <small class="text-muted">Max 2MB. JPG/PNG/WEBP</small>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_available" value="1" class="form-check-input"
                                id="availableTambah" checked>
                            <label class="form-check-label" for="availableTambah">Langsung tersedia</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-3"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn rounded-3 fw-bold px-4"
                            style="background:#f7941d; color:white;">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT PRODUK --}}
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header rounded-top-4" style="background:#f7941d; color:white;">
                    <h5 class="modal-title fw-bold">✏️ Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        style="filter:brightness(0) invert(1);"></button>
                </div>
                <form id="formEdit" method="POST" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Produk</label>
                            <input type="text" name="name" id="editName" class="form-control rounded-3"
                                required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Harga (Rp)</label>
                                <input type="number" name="price" id="editPrice" class="form-control rounded-3"
                                    min="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Stok</label>
                                <input type="number" name="stock" id="editStock" class="form-control rounded-3"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Baru</label>
                            <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_available" value="1" class="form-check-input"
                                id="editAvailable">
                            <label class="form-check-label" for="editAvailable">Produk tersedia</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-3"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn rounded-3 fw-bold px-4"
                            style="background:#f7941d; color:white;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL KASIR MANUAL --}}
    <div class="modal fade" id="modalKasir" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4">
                <div class="modal-header" style="background:#f7941d; color:white;">
                    <h5 class="modal-title fw-bold">🧾 Kasir Manual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        style="filter:brightness(0) invert(1);"></button>
                </div>
                <form action="{{ route('admin.shop.kasir.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">

                        {{-- Info Siswa --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Siswa <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="cashier_name" class="form-control rounded-3"
                                    placeholder="Nama lengkap siswa" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. Telepon</label>
                                <input type="text" name="phone" class="form-control rounded-3"
                                    placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Catatan</label>
                                <input type="text" name="notes" class="form-control rounded-3"
                                    placeholder="Catatan tambahan (opsional)">
                            </div>
                        </div>

                        <hr>

                        {{-- Pilih Produk --}}
                        <h6 class="fw-bold mb-3">🛒 Pilih Produk</h6>
                        <div class="row g-3" id="produk-list">
                            @foreach ($shop->products()->where('is_available', true)->where('stock', '>', 0)->get() as $product)
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 d-flex align-items-center gap-3"
                                        id="card-product-{{ $product->id }}">

                                        {{-- Checkbox --}}
                                        <input type="checkbox" name="items[]" value="{{ $product->id }}"
                                            class="form-check-input product-check"
                                            style="width:20px; height:20px; cursor:pointer;"
                                            data-id="{{ $product->id }}" data-price="{{ $product->price }}"
                                            data-name="{{ $product->name }}" onchange="updateTotal()">

                                        {{-- Info Produk --}}
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold">{{ $product->name }}</div>
                                            <div class="text-warning fw-bold">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </div>
                                            <small class="text-muted">Stok: {{ $product->stock }}</small>
                                        </div>

                                        {{-- Quantity --}}
                                        <div style="width:80px;">
                                            <input type="number" name="quantities[{{ $product->id }}]"
                                                class="form-control form-control-sm rounded-3 qty-input"
                                                value="1" min="1" max="{{ $product->stock }}"
                                                data-id="{{ $product->id }}" data-price="{{ $product->price }}"
                                                onchange="updateTotal()" disabled>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Total --}}
                        <div class="mt-4 p-3 rounded-3 text-end"
                            style="background:#fff7ed; border:1px solid #fed7aa;">
                            <span class="fw-semibold">Total: </span>
                            <span class="fw-bold fs-4 text-warning" id="total-kasir">Rp 0</span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-3"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn rounded-3 fw-bold px-4"
                            style="background:#f7941d; color:white;">
                            ✅ Proses Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- TOAST NOTIF --}}
    <div id="notif-bar"
        style="display:none; position:fixed; top:20px; right:20px; z-index:9999;
            width:320px; background:white; border-radius:16px;
            box-shadow:0 8px 30px rgba(0,0,0,0.15); border-left:4px solid #f7941d;
            padding:16px 20px; animation: slideIn 0.3s ease;">
        <div class="d-flex align-items-start gap-3">
            <span style="font-size:1.4rem;">🛎️</span>
            <div class="flex-grow-1">
                <div style="font-weight:700; font-size:0.9rem; color:#1a1f2e;">Pesanan Baru!</div>
                <div id="notif-text" style="font-size:0.8rem; color:#666; margin-top:3px;"></div>
            </div>
            <button onclick="document.getElementById('notif-bar').style.display='none'"
                style="background:none; border:none; color:#999; font-size:1.1rem; cursor:pointer; padding:0; line-height:1;">✕</button>
        </div>
    </div>

    <style>
        @keyframes slideIn {
            from {
                transform: translateX(100px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // Auto buka tab stok kalau dari redirect product
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('tab') === 'stok') {
        const stokTab = new bootstrap.Tab(document.getElementById('stok-tab'));
        stokTab.show();
    }

    @if(session('swal'))
    Swal.fire({
        icon: "{{ session('swal.type') }}",
        title: "{{ session('swal.title') }}",
        text: "{{ session('swal.text') }}",
        confirmButtonColor: "#f7941d",
    });
    @endif
</script>
    {{-- Audio notif (pakai tone dari browser, tidak butuh file) --}}
    <script>
        function playNotifSound() {
            const ctx = new(window.AudioContext || window.webkitAudioContext)();
            const oscillator = ctx.createOscillator();
            const gainNode = ctx.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(ctx.destination);

            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(880, ctx.currentTime);
            oscillator.frequency.setValueAtTime(660, ctx.currentTime + 0.1);

            gainNode.gain.setValueAtTime(0.3, ctx.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.5);

            oscillator.start(ctx.currentTime);
            oscillator.stop(ctx.currentTime + 0.5);
        }

        let lastPendingCount = 0;
        let isFirstLoad = true;

        function checkNotifications() {
            fetch("{{ route('admin.notifications') }}", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const badge = document.getElementById('pending-badge');
                    const notifBar = document.getElementById('notif-bar');
                    const notifText = document.getElementById('notif-text');

                    if (data.pending_count > 0) {
                        badge.classList.remove('d-none');
                        badge.textContent = data.pending_count + ' Pending';

                        // Ada pesanan BARU masuk
                        if (!isFirstLoad && data.pending_count > lastPendingCount) {
                            playNotifSound();

                            if (data.latest) {
                                notifText.innerHTML =
                                    '<strong>' + data.latest.cashier_name + '</strong>' +
                                    ' — Rp ' + Number(data.latest.total).toLocaleString('id-ID') +
                                    '<br><span style="color:#999;">' + data.latest.created_at + '</span>';
                            }
                            notifBar.style.display = 'block';
                            setTimeout(() => {
                                notifBar.style.display = 'none';
                            }, 8000);

                            // Auto refresh tabel
                            refreshTable();
                        }

                        lastPendingCount = data.pending_count;
                    } else {
                        badge.classList.add('d-none');
                        lastPendingCount = 0;
                    }

                    isFirstLoad = false;
                })
                .catch(err => console.log('Notif error:', err));
        }

        function refreshTable() {
            const params = new URLSearchParams(window.location.search);
            fetch("{{ route('dashboard') }}?" + params.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.html) {
                        document.getElementById('table-wrapper').innerHTML = data.html;
                    }
                })
                .catch(err => console.log('Refresh error:', err));
        }

        const notifInterval = setInterval(checkNotifications, 10000);
        checkNotifications();
    </script>

    <script>
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.product-check').forEach(function(checkbox) {
                const id = checkbox.dataset.id;
                const price = parseInt(checkbox.dataset.price);
                const qtyInput = document.querySelector(`.qty-input[data-id="${id}"]`);

                if (checkbox.checked) {
                    qtyInput.disabled = false;
                    const qty = parseInt(qtyInput.value) || 1;
                    total += price * qty;
                } else {
                    qtyInput.disabled = true;
                    qtyInput.value = 1;
                }
            });

            document.getElementById('total-kasir').textContent =
                'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
    <script>
        function editProduk(id, name, price, stock, isAvailable) {
            document.getElementById('formEdit').action = `/admin/shop/products/${id}`;
            document.getElementById('editName').value = name;
            document.getElementById('editPrice').value = price;
            document.getElementById('editStock').value = stock;
            document.getElementById('editAvailable').checked = isAvailable === 1;
            new bootstrap.Modal(document.getElementById('modalEdit')).show();
        }
    </script>

</body>

</html>
