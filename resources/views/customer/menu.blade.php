<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KADI - Menu Slider</title>
    <style>
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
            K<span class="coffee-icon">🍴</span>DI
        </div>
        <div class="user-profile">
            <div class="avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <span>{{ auth()->user()->name ?? 'Hyuu' }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit"
                    style="background:none; border:none; color:red; cursor:pointer; font-size:0.8rem; margin-left:5px;">(Logout)</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <h1 class="page-title">Mau Maem Apa Hari Ini?</h1>
        <p class="subtitle">Geser Untuk Melihat Warung Lainnya</p>

        <div class="slider-wrapper">

            <button class="nav-btn prev" onclick="scrollSlider(-1)">&#10094;</button>

            <div class="shops-grid" id="slider">

                {{-- CARD WARUNG LADESH --}}
                <div class="shop-card">
                    <div class="shop-tag">Warung Ladesh</div>
                    <div class="menu-title">Menu Tersedia</div>
                    <div class="menu-list">
                        <div class="menu-item">Es TeaJus ★</div>
                        <div class="menu-item normal">Gorengan</div>
                        <div class="menu-item normal">Ayam Goyeng</div>
                    </div>
                    {{-- LINK KE HALAMAN DETAIL WARUNG (shop-detail.blade.php) --}}
                    <a href="{{ route('shop.detail', ['shop_id' => 1]) }}"
                       class="btn-order text-decoration-none">Lihat Menu</a>
                </div>

                {{-- CARD WARUNG LAINNYA (Dummy) --}}
                <div class="shop-card">
                    <div class="shop-tag">Warung Bahagia</div>
                    <div class="menu-title">Menu Tersedia</div>
                    <div class="menu-list">
                        <div class="menu-item">Nasi Goreng</div>
                        <div class="menu-item normal">Mie Ayam</div>
                    </div>
                    <a href="{{ route('shop.detail', ['shop_id' => 2]) }}"
                       class="btn-order text-decoration-none">Lihat Menu</a>
                </div>

                <div class="shop-card">
                    <div class="shop-tag">Warung Jaya</div>
                    <div class="menu-title">Menu Tersedia</div>
                    <div class="menu-list">
                        <div class="menu-item">Sate Ayam</div>
                        <div class="menu-item normal">Es Campur</div>
                    </div>
                    <a href="{{ route('shop.detail', ['shop_id' => 3]) }}"
                       class="btn-order text-decoration-none">Lihat Menu</a>
                </div>

                <div class="shop-card">
                    <div class="shop-tag">Warung Maju</div>
                    <div class="menu-title">Menu Tersedia</div>
                    <div class="menu-list">
                        <div class="menu-item">Bakso</div>
                        <div class="menu-item normal">Es Teh Manis</div>
                    </div>
                    <a href="{{ route('shop.detail', ['shop_id' => 4]) }}"
                       class="btn-order text-decoration-none">Lihat Menu</a>
                </div>

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
</body>

</html>
