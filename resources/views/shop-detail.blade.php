<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KADI - {{ $shop->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --orange: #ff9f1c;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #fff;
            overflow-x: hidden;
        }

        /* NAVBAR */
        .navbar-kadi {
            background: white;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo-img {
            height: 55px;
            width: auto;
            object-fit: contain;
        }

        .badge-cart {
            background: var(--orange);
            color: white;
            font-size: 0.65rem;
            position: absolute;
            top: -6px;
            right: -8px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
        }

        /* HERO */
        .shop-hero {
            background: linear-gradient(135deg, #fff7ed, #fff);
            padding: 40px 0 20px;
            border-bottom: 1px solid #f5f5f5;
        }

        /* CARD PRODUK */
        .card-menu {
            border: 1px solid #f0f0f0;
            border-radius: 20px;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.25s, box-shadow 0.25s;
            height: 100%;
            overflow: hidden;
        }

        .card-menu:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 35px rgba(255, 159, 28, 0.15);
        }

        .card-img-wrapper {
            padding: 12px 12px 0;
        }

        .card-img-top {
            height: 170px;
            object-fit: cover;
            border-radius: 14px;
            width: 100%;
        }

        .menu-title {
            font-weight: 600;
            font-size: 1rem;
            color: #222;
            margin-bottom: 4px;
        }

        .menu-price {
            color: var(--orange);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .btn-add {
            border: 1.5px solid var(--orange);
            color: var(--orange);
            background: transparent;
            border-radius: 50px;
            padding: 5px 28px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: 0.2s;
        }

        .btn-add:hover {
            background: var(--orange);
            color: white;
        }

        /* PAGINATION CUSTOM */
        .pagination-custom {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 40px;
        }

        .page-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1.5px solid #eee;
            background: white;
            color: #555;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: 0.2s;
        }

        .page-btn:hover {
            border-color: var(--orange);
            color: var(--orange);
        }

        .page-btn.active {
            background: var(--orange);
            color: white;
            border-color: var(--orange);
        }

        .page-btn.disabled {
            opacity: 0.35;
            pointer-events: none;
        }

        .page-btn-nav {
            padding: 0 18px;
            height: 38px;
            border-radius: 50px;
            border: 1.5px solid #eee;
            background: white;
            color: #555;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: 0.2s;
        }

        .page-btn-nav:hover {
            border-color: var(--orange);
            color: var(--orange);
        }

        .page-btn-nav.disabled {
            opacity: 0.35;
            pointer-events: none;
        }

        /* WAVE DECO */
        .decoration-wave {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 220px;
            height: 130px;
            background: var(--orange);
            border-top-right-radius: 100%;
            z-index: -1;
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar-kadi">
        <div class="container d-flex align-items-center justify-content-between">

            {{-- Logo --}}
            <a href="{{ route('customer.menu') }}" class="text-decoration-none">
                <img src="/images/Logo.png" alt="KADI" class="logo-img">
            </a>

            {{-- Right side --}}
            <div class="d-flex align-items-center gap-3">


                {{-- Divider --}}


                {{-- Cart --}}
                <div class="position-relative" data-bs-toggle="modal" data-bs-target="#modalKeranjang"
                    style="cursor:pointer;">
                    <i class="bi bi-cart3 fs-5 text-dark"></i>
                    <span class="position-absolute badge rounded-pill badge-cart">
                        {{ count(session('cart', [])) }}
                    </span>
                </div>

                {{-- Divider --}}
                <div style="width:1px; height:24px; background:#eee;"></div>

                {{-- User --}}
                <div class="d-flex align-items-center gap-2">
                    <div
                style="width:35px;height:35px;background:#f7941d;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <span style="color:white;font-weight:700;font-size:0.9rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
            </div>
                   <a href="{{ route('customer.profil') }}" style="text-decoration:none;color:inherit;">
                <span>{{ auth()->user()->name ?? 'User' }}</span>
            </a>
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                  <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</button>
            </form>
            </div>
        </div>
    </nav>

    {{-- SHOP HERO --}}
    <div class="shop-hero">
        <div class="container">
            <div class="d-flex align-items-center gap-3">
                <div
                    style="width:52px; height:52px; background:#fff7ed; border-radius:14px;
                        display:flex; align-items:center; justify-content:center; font-size:1.6rem;">
                    🍽️
                </div>
                <div>
                    <h2 class="fw-bold mb-0" style="font-size:1.5rem;">{{ $shop->name }}</h2>
                    <small class="text-muted">{{ $products->total() }} menu tersedia</small>
                </div>
            </div>
        </div>
    </div>

    {{-- PRODUK GRID --}}
    <div class="container py-5 mb-5">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                ⚠️ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card-menu text-center d-flex flex-column h-100">
                        <div class="card-img-wrapper">
                            @if ($product->image)
                                @if (str_starts_with($product->image, '/images/'))
                                    <img src="{{ asset($product->image) }}" class="card-img-top"
                                        alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                        alt="{{ $product->name }}">
                                @endif
                            @else
                                <img src="{{ asset('images/default.png' . $product->image) }}" class="card-img-top"
                                        alt="{{ $product->name }}">
                            @endif
                        </div>

                        <div class="card-body p-3 pt-2 d-flex flex-column">
                            <h5 class="menu-title">{{ $product->name }}</h5>

                            @if ($product->stock <= 5 && $product->stock > 0)
                                <span class="badge rounded-pill mb-2"
                                    style="background:#fff7ed; color:#f7941d; font-size:0.72rem;">
                                    Sisa {{ $product->stock }}
                                </span>
                            @endif

                            <div class="mt-auto">
                                <div class="menu-price mb-3">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>

                                @if ($product->stock > 0 && $product->is_available)
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-add w-100">+ Tambah</button>
                                    </form>
                                @else
                                    <button class="btn btn-add w-100" disabled
                                        style="opacity:0.4; cursor:not-allowed;">Habis</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div style="font-size:4rem; opacity:0.2;">🍽️</div>
                    <p class="text-muted mt-3">Belum ada menu tersedia.</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION CUSTOM --}}
        @if ($products->hasPages())
            <div class="pagination-custom">

                {{-- Prev --}}
                @if ($products->onFirstPage())
                    <span class="page-btn-nav disabled">
                        <i class="bi bi-chevron-left"></i> Prev
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="page-btn-nav">
                        <i class="bi bi-chevron-left"></i> Prev
                    </a>
                @endif

                {{-- Angka --}}
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if ($page == $products->currentPage())
                        <span class="page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="page-btn-nav">
                        Next <i class="bi bi-chevron-right"></i>
                    </a>
                @else
                    <span class="page-btn-nav disabled">
                        Next <i class="bi bi-chevron-right"></i>
                    </span>
                @endif

            </div>
        @endif

    </div>

    <div class="decoration-wave"></div>

    {{-- MODAL KERANJANG --}}
    <div class="modal fade" id="modalKeranjang" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">🛒 Keranjang Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if (session('cart') && count(session('cart')) > 0)
                        <div class="list-group list-group-flush">
                            @foreach (session('cart') as $id => $item)
                                <div
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div
                                            style="width:48px; height:48px; background:#f8f9fa;
                                            border-radius:10px; overflow:hidden;">
                                            <img src="{{ isset($item['image']) ? (str_starts_with($item['image'], '/images/') ? asset($item['image']) : asset('storage/' . $item['image'])) : 'https://via.placeholder.com/50' }}"
                                                class="w-100 h-100 object-fit-cover" alt="">
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="font-size:0.9rem;">{{ $item['name'] }}
                                            </div>
                                            <small class="text-muted">
                                                x{{ $item['quantity'] ?? 1 }} ·
                                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                                            </small>
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle"
                                            style="width:32px; height:32px; padding:0;">
                                            <i class="bi bi-trash" style="font-size:0.75rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <hr class="my-3">
                        <div class="d-flex justify-content-between fw-bold mb-4 fs-6">
                            <span>Total</span>
                            <span style="color:var(--orange);">
                                Rp
                                {{ number_format(array_sum(array_column(session('cart'), 'subtotal')), 0, ',', '.') }}
                            </span>
                        </div>

                        <a href="{{ route('order.show') }}" class="btn w-100 text-white fw-bold rounded-pill py-3"
                            style="background:var(--orange);">
                            Pesan Sekarang →
                        </a>
                    @else
                        <div class="text-center py-5">
                            <div style="font-size:3.5rem; opacity:0.2;">🛒</div>
                            <p class="text-muted mt-3">Keranjang kosong nih!</p>
                            <button class="btn btn-outline-warning rounded-pill px-4 mt-1"
                                data-bs-dismiss="modal">Mulai Belanja</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        @if (session('error'))
            // Ada error → scroll ke alert, jangan buka modal
            document.querySelector('.alert-danger')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        @elseif (session('success'))
            var myModal = new bootstrap.Modal(document.getElementById('modalKeranjang'));
            myModal.show();
        @endif
    </script>
</body>

</html>
