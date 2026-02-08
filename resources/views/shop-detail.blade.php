<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KADI - Kantin Warung Ladesh</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* --- CONFIG UTAMA --- */
        :root {
            --primary-orange: #f7931e;
            --light-orange: #fff5eb;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* --- NAVBAR CUSTOM --- */
        .navbar-kadi {
            background: white;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .logo-text {
            font-weight: bold;
            font-size: 24px;
            letter-spacing: 2px;
        }

        .search-box {
            border: 1px solid var(--primary-orange);
            border-radius: 5px;
            padding: 5px 15px;
            width: 100%;
            max-width: 300px;
        }

        .search-box input {
            border: none;
            outline: none;
            width: 85%;
        }

        .search-box i {
            color: #ccc;
        }

        /* --- CARD PRODUK --- */
        .card-menu {
            border: none;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .card-menu:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }

        .menu-title {
            color: var(--primary-orange);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .menu-desc {
            font-size: 0.85rem;
            color: #6c757d;
            line-height: 1.4;
            height: 40px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .menu-price {
            color: var(--primary-orange);
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .btn-add {
            border: 1px solid var(--primary-orange);
            color: var(--primary-orange);
            border-radius: 50px;
            padding: 5px 25px;
            font-size: 0.9rem;
            transition: all 0.3s;
            background: white;
        }

        .btn-add:hover {
            background: var(--primary-orange);
            color: white;
        }

        .crown-icon {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%) rotate(15deg);
            font-size: 2.5rem;
            color: #ffd700;
            z-index: 10;
            filter: drop-shadow(0 2px 2px rgba(0, 0, 0, 0.1));
        }

        .decoration-wave {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 200px;
            height: 200px;
            background: var(--primary-orange);
            border-radius: 0 100% 0 0;
            opacity: 0.9;
            z-index: -1;
        }

        .page-title {
            font-size: 1.5rem;
        }

        @media(max-width: 768px) {
            .page-title {
                font-size: 1.2rem;
            }

            .search-box {
                display: none;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar-kadi sticky-top">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('customer.menu') }}" class="text-decoration-none">
                    <div class="logo-text text-dark">
                        K <i class="bi bi-egg-fried text-warning"></i> DI
                    </div>
                </a>
            </div>

            <div class="d-none d-md-block text-center flex-grow-1">
                <h4 class="m-0"><span class="text-warning">Kantin</span> Warung Ladesh</h4>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="search-box d-flex align-items-center d-none d-lg-flex">
                    <input type="text" placeholder="Maem apa...">
                    <i class="bi bi-search"></i>
                </div>
                <div class="position-relative cursor-pointer" data-bs-toggle="modal" data-bs-target="#modalKeranjang"
                    style="cursor: pointer;">
                    <i class="bi bi-cart3 fs-4"></i>
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                        {{ count(session('cart', [])) }}
                    </span>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center"
                        style="width: 35px; height: 35px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <span class="fw-bold d-none d-sm-block">{{ auth()->user()->name ?? 'Hyuu' }}</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-5 mb-5">

        <div class="d-block d-md-none text-center mb-4">
            <h4 class="fw-bold"><span class="text-warning">Kantin</span> Warung Ladesh</h4>
        </div>

        <div class="row g-4">

            <div class="col-12 col-md-4">
                <div class="card-menu p-3 text-center d-flex flex-column h-100">
                    <img src="https://via.placeholder.com/300x200?text=Es+TeaJus"
                        class="card-img-top mx-auto w-75 rounded" alt="TeaJus">
                    <div class="card-body p-0 pt-3 d-flex flex-column flex-grow-1">
                        <h5 class="menu-title">Es TeaJus</h5>
                        <p class="menu-desc">Teh kemasan sachet dengan kombinasi es yang segar.</p>
                        <div class="mt-auto">
                            <h4 class="menu-price">3000</h4>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="shop_id" value="1">
                                <input type="hidden" name="menu" value="Es TeaJus">
                                <input type="hidden" name="harga" value="3000">
                                <input type="hidden" name="image"
                                    value="https://via.placeholder.com/300x200?text=Es+TeaJus">

                                <button type="submit" class="btn btn-add mt-2">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4 position-relative">
                <div class="crown-icon">
                    <i class="bi bi-crown"></i>
                </div>

                <div class="card-menu p-3 text-center d-flex flex-column h-100 border-warning border border-2">
                    <img src="https://via.placeholder.com/300x200?text=Gorengan"
                        class="card-img-top mx-auto w-75 rounded" alt="Gorengan">
                    <div class="card-body p-0 pt-3 d-flex flex-column flex-grow-1">
                        <h5 class="menu-title">Gorengan <i class="bi bi-star-fill text-warning fs-6"></i></h5>
                        <p class="menu-desc">Gorengan hangat cocok untuk pengganjal lapar.</p>
                        <div class="mt-auto">
                            <h4 class="menu-price">1000</h4>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="shop_id" value="1">
                                <input type="hidden" name="menu" value="Gorengan">
                                <input type="hidden" name="harga" value="1000">
                                <input type="hidden" name="image"
                                    value="https://via.placeholder.com/300x200?text=Gorengan">

                                <button type="submit" class="btn btn-add mt-2">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card-menu p-3 text-center d-flex flex-column h-100">
                    <img src="https://via.placeholder.com/300x200?text=Ayam+Goyeng"
                        class="card-img-top mx-auto w-75 rounded" alt="Ayam">
                    <div class="card-body p-0 pt-3 d-flex flex-column flex-grow-1">
                        <h5 class="menu-title">Ayam Goyeng</h5>
                        <p class="menu-desc">Ayam ayam apa yang lucu? Ayam goyeng.</p>
                        <div class="mt-auto">
                            <h4 class="menu-price">8000</h4>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="shop_id" value="1">
                                <input type="hidden" name="menu" value="Ayam Goyeng">
                                <input type="hidden" name="harga" value="8000">
                                <input type="hidden" name="image"
                                    value="https://via.placeholder.com/300x200?text=Ayam+Goyeng">

                                <button type="submit" class="btn btn-add mt-2">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-center align-items-center mt-5 gap-3 text-secondary">
            <span>Recent</span>
            <span class="fw-bold text-dark">1</span>
            <button class="btn btn-warning btn-sm text-white px-3 rounded-1">Next</button>
        </div>

    </div>

    <div class="decoration-wave"></div>

    <!-- MODAL KERANJANG (FIXED VERSION) -->
    <div class="modal fade" id="modalKeranjang" tabindex="-1" aria-labelledby="modalKeranjangLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="modalKeranjangLabel">🛒 Keranjang Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session('cart') && count(session('cart')) > 0)
                        <div class="list-group list-group-flush">
                            @foreach (session('cart') as $id => $item)
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $item['name'] }}</h6>
                                        <small class="text-secondary">Rp {{ number_format($item['price']) }}</small>
                                    </div>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <hr class="my-3">
                        <div class="d-flex justify-content-between fw-bold mb-3">
                            <span>Total Bayar:</span>
                            <span class="text-warning">Rp {{ number_format(array_sum(array_column(session('cart'), 'price'))) }}</span>
                        </div>

                        {{-- LINK KE HALAMAN KONFIRMASI ORDER --}}
                        <a href="{{ route('order.show') }}" class="btn btn-warning w-100 text-white fw-bold rounded-pill py-2">
                            Pesan Sekarang & Bayar
                        </a>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-cart-x fs-1 text-secondary opacity-50"></i>
                            <p class="text-secondary mt-2">Keranjang lu masih kosong, bro!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto buka modal kalau ada session sukses
        @if (session('success'))
            var myModal = new bootstrap.Modal(document.getElementById('modalKeranjang'));
            myModal.show();
        @endif
    </script>
</body>

</html>
