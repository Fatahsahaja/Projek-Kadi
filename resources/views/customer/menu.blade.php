<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KADI - Menu Slider</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (max-width: 576px) {
            .navbar {
                padding: 1rem 1.2rem;
            }

            .logo {
                font-size: 2rem;
            }

            .page-title {
                font-size: 1.4rem;
            }

            .subtitle {
                font-size: 0.8rem;
            }

            .shop-card {
                min-width: 260px;
                padding: 0 15px 20px 15px;
            }

            .shop-tag {
                font-size: 0.85rem;
                padding: 8px 18px;
            }

            .menu-title {
                font-size: 1.2rem;
            }

            .menu-item {
                font-size: 0.95rem;
            }

            .btn-order {
                padding: 8px 30px;
                font-size: 0.9rem;
            }

            .user-profile {
                font-size: 0.85rem;
            }

            .user-profile span {
                display: none;
                /* sembunyiin nama user di HP */
            }

            .decoration-blob {
                width: 180px;
                height: 120px;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff;
            min-height: 100vh;
            position: relative;
            padding-bottom: 100px;
            overflow-x: hidden;
        }

        .navbar {
            padding: 1.5rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 3rem;
            font-weight: bold;
            color: #000;
            display: flex;
            align-items: center;
            font-family: serif;
        }

        .coffee-icon {
            color: #f7931e;
            font-size: 2.5rem;
            margin: 0 5px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background-color: #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .slider-wrapper {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: background 0.3s;
        }

        .nav-btn:hover {
            background-color: #ff9800;
        }

        .nav-btn.prev {
            left: 0px;
        }

        .nav-btn.next {
            right: 0px;
        }

        @media (max-width: 768px) {
            .nav-btn {
                display: none;
            }
        }

        .page-title {
            margin-bottom: 0.5rem;
            color: #000;
            font-size: 2rem;
            font-weight: 500;
        }

        .subtitle {
            color: #333;
            margin-bottom: 2rem;
            font-family: 'Times New Roman', serif;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .shops-grid {
            display: flex;
            overflow-x: auto;
            gap: 30px;
            padding: 40px 20px;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            justify-content: flex-start;
        }

        .shops-grid::-webkit-scrollbar {
            display: none;
        }

        .shops-grid {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .shop-card {
            background: white;
            border-radius: 30px;
            padding: 0 20px 30px 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            position: relative;
            margin-top: 20px;
            transition: transform 0.3s;
            min-width: 300px;
            flex-shrink: 0;
            scroll-snap-align: center;
        }

        .shop-card:hover {
            transform: translateY(-10px);
        }

        .shop-tag {
            background-color: #ff9800;
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 1rem;
            display: inline-block;
            position: relative;
            top: -20px;
            box-shadow: 0 4px 10px rgba(255, 152, 0, 0.3);
            white-space: nowrap;
        }

        .menu-title {
            font-family: 'Times New Roman', serif;
            font-size: 1.5rem;
            margin: 10px 0 20px 0;
            color: #333;
        }

        .menu-list {
            min-height: 100px;
        }




        .menu-item {
            padding: 8px 0;
            color: #ffa726;
            font-size: 1.1rem;
        }

        .menu-item.normal {
            color: #ffcc80;
        }

        .btn-order {
            background: transparent;
            color: #000;
            border: 1px solid #000;
            padding: 10px 40px;
            border-radius: 50px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-order:hover {
            background: #000;
            color: white;
        }
        .logo-img {
            height: 55px;
            object-fit: contain;
            width: auto;
        }

        .decoration-blob {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 300px;
            height: 200px;
            background: #ff9800;
            border-top-right-radius: 100%;
            z-index: 1;
        }
    </style>
</head>

<body>

    <div class="decoration-blob"></div>

    <nav class="navbar">
        <div class="logo">
          <img src="/images/Logo.png" alt="Logo Kadi" class="logo-img">
        </div>
        <div class="user-profile">
            <div
                style="width:35px;height:35px;background:#f7941d;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <span style="color:white;font-weight:700;font-size:0.9rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
            </div>
            <a href="{{ route('customer.profil') }}" style="text-decoration:none;color:inherit;">
                <span>{{ auth()->user()->name ?? 'User' }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                  <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</button>
            </form>

        </div>
    </nav>

    <div class="container">
        <h1 class="page-title">Mau Maem Apa Hari Ini?</h1>
        <p class="subtitle">Geser Untuk Melihat Warung Lainnya</p>

        <div class="slider-wrapper">

            <button class="nav-btn prev" onclick="scrollSlider(-1)">&#10094;</button>

            <div class="shops-grid" id="slider">
                @forelse($shops as $shop)
                    <div class="shop-card">
                        <div class="shop-tag">{{ $shop->name }}</div>
                        <div class="menu-title">Menu Tersedia</div>
                        <div class="menu-list">
                            @forelse($shop->products as $product)
                                <div class="menu-item">{{ $product->name }}</div>
                            @empty
                                <div style="color:#ccc; font-size:0.9rem;">Belum ada menu</div>
                            @endforelse
                        </div>
                        <a href="{{ route('shop.detail', ['shop_id' => $shop->id]) }}"
                            class="btn-order text-decoration-none">Lihat Menu</a>
                    </div>
                @empty
                    <div style="color:#999; padding:40px;">Belum ada warung.</div>
                @endforelse
            </div>

            <button class="nav-btn next" onclick="scrollSlider(1)">&#10095;</button>
        </div>

    </div>

    <script>
        function scrollSlider(direction) {
            const slider = document.getElementById('slider');
            const scrollAmount = 340;

            slider.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#f7941d',
                });
            });
        </script>
    @endif
</body>

</html>
