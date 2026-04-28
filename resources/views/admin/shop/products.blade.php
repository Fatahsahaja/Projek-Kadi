<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk — {{ $shop->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 280px;
            padding: 40px 25px;
            border-right: 1px solid #eee;
            display: flex;
            flex-direction: column;
            background: #fff;
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

        .balance-label {
            font-size: 0.9rem;
            color: #666;
        }

        .balance-amount {
            font-size: 1.6rem;
            font-weight: 700;
            color: #000;
        }

        .sidebar-menu a {
            display: block;
            color: #999;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 15px;
            transition: 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            color: #f7941d;
        }

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

        /* MAIN */
        .main-content {
            flex: 1;
            padding: 40px 50px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #000;
            margin-bottom: 25px;
        }

        /* PRODUCT CARDS */
        .product-card {
            background: white;
            border: 1px solid #f0f0f0;
            border-radius: 16px;
            overflow: hidden;
            transition: 0.2s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            background: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #ddd;
        }

        .product-img img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .product-body {
            padding: 15px;
        }

        .product-name {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 5px;
        }

        .product-price {
            color: #f7941d;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .product-stock {
            font-size: 0.8rem;
            color: #888;
        }

        .stock-low {
            color: #ef4444 !important;
            font-weight: 600;
        }

        /* FORM MODAL */
        .modal-header {
            background: #f7941d;
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .form-label {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 10px 15px;
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
            padding: 10px 25px;
            font-weight: 600;
        }

        .btn-kadi:hover {
            background: #e8830d;
            color: white;
        }

        .toggle-available {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">

        {{-- SIDEBAR --}}
        <aside class="sidebar">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="user-avatar"><i class="fa-solid fa-user"></i></div>
                <div class="user-info">
                    <h4>{{ $shop->name }}</h4>
                    <p>Admin</p>
                </div>
            </div>

            <div class="mb-4">
                <div class="balance-label">Tabungan</div>
                <div class="balance-amount">Rp {{ number_format($shop->balance, 0, ',', '.') }}</div>
            </div>

            <div class="sidebar-menu">
                <a href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-chart-bar me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.shop.products') }}" class="active">
                    <i class="fa-solid fa-box me-2"></i> Manajemen Produk
                </a>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="margin-top: auto;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="main-content">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none small">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                    <h1 class="page-title mb-0 mt-1">📦 Manajemen Produk</h1>
                </div>
                <button class="btn btn-kadi" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fas fa-plus me-2"></i> Tambah Produk
                </button>
            </div>

            {{-- STATS --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="p-3 rounded-3 border text-center">
                        <div style="font-size:1.8rem; font-weight:700;">{{ $products->count() }}</div>
                        <div class="text-muted small">Total Produk</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-3 border text-center">
                        <div style="font-size:1.8rem; font-weight:700; color:#10b981;">
                            {{ $products->where('is_available', true)->count() }}
                        </div>
                        <div class="text-muted small">Produk Tersedia</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-3 border text-center">
                        <div style="font-size:1.8rem; font-weight:700; color:#ef4444;">
                            {{ $products->where('stock', '<=', 5)->count() }}
                        </div>
                        <div class="text-muted small">Stok Menipis (≤5)</div>
                    </div>
                </div>
            </div>

            {{-- PRODUCT GRID --}}
            @if ($products->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-box-open fa-3x mb-3 opacity-25"></i>
                    <p>Belum ada produk. Tambah produk pertama!</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-md-3 col-sm-6">
                            <div class="product-card">
                                {{-- Gambar --}}
                                <div class="product-img">
                                    @if ($product->image)
                                        @if (str_starts_with($product->image, '/images/'))
                                            {{-- Gambar lama dari public/images --}}
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            {{-- Gambar baru dari storage --}}
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}">
                                        @endif
                                    @else
                                        🍽️
                                    @endif
                                </div>

                                <div class="product-body">
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                    <div class="product-stock {{ $product->stock <= 5 ? 'stock-low' : '' }}">
                                        Stok: {{ $product->stock }}
                                        @if ($product->stock <= 5)
                                            ⚠️
                                        @endif
                                    </div>

                                    {{-- Toggle Available --}}
                                    <form action="{{ route('admin.shop.products.toggle', $product->id) }}"
                                        method="POST" class="mt-2">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn btn-sm w-100 rounded-3
                                {{ $product->is_available ? 'btn-success' : 'btn-outline-secondary' }}">
                                            {{ $product->is_available ? '✅ Tersedia' : '❌ Tidak Tersedia' }}
                                        </button>
                                    </form>

                                    {{-- Aksi --}}
                                    <div class="d-flex gap-2 mt-2">
                                        <button class="btn btn-sm btn-outline-warning w-100 rounded-3"
                                            onclick="editProduk(
                                    {{ $product->id }},
                                    '{{ addslashes($product->name) }}',
                                    {{ $product->price }},
                                    {{ $product->stock }},
                                    {{ $product->is_available ? 1 : 0 }}
                                )">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.shop.products.destroy', $product->id) }}"
                                            method="POST" onsubmit="return confirm('Hapus {{ $product->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </main>
    </div>

    {{-- MODAL TAMBAH PRODUK --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header rounded-top-4">
                    <h5 class="modal-title fw-bold">➕ Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.shop.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                placeholder="contoh: Nasi Goreng" required>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" placeholder="5000"
                                    min="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stock" class="form-control" placeholder="50"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label">Foto Produk</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Max 2MB. Format: JPG, PNG, WEBP</small>
                        </div>
                        <div class="form-check mt-2">
                            <input type="checkbox" name="is_available" value="1" class="form-check-input"
                                id="availableTambah" checked>
                            <label class="form-check-label" for="availableTambah">Produk langsung tersedia</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-3"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-kadi">Tambah Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT PRODUK --}}
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header rounded-top-4">
                    <h5 class="modal-title fw-bold">✏️ Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEdit" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="editPrice" class="form-control"
                                    min="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stock" id="editStock" class="form-control"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label">Foto Produk Baru</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                        </div>
                        <div class="form-check mt-2">
                            <input type="checkbox" name="is_available" value="1" class="form-check-input"
                                id="editAvailable">
                            <label class="form-check-label" for="editAvailable">Produk tersedia</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-3"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-kadi">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SweetAlert --}}
    @if (session('swal'))
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editProduk(id, name, price, stock, isAvailable) {
            // Set action form ke route update
            document.getElementById('formEdit').action = `/admin/shop/products/${id}`;

            // Isi field
            document.getElementById('editName').value = name;
            document.getElementById('editPrice').value = price;
            document.getElementById('editStock').value = stock;
            document.getElementById('editAvailable').checked = isAvailable === 1;

            // Buka modal
            new bootstrap.Modal(document.getElementById('modalEdit')).show();
        }
    </script>
</body>

</html>
