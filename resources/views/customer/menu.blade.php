<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KADI - Menu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff; /* Background putih bersih sesuai desain */
            min-height: 100vh;
            position: relative;
            padding-bottom: 100px; /* Space untuk dekorasi bawah */
        }

        /* Navbar Simple */
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
            font-family: serif; /* Font logo agak serif */
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

        /* Container Utama */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
            text-align: center;
            position: relative;
            z-index: 2; /* Supaya di atas dekorasi background */
        }

        /* Typography Judul */
        .page-title {
            margin-bottom: 0.5rem;
            color: #000;
            font-size: 2rem;
            font-weight: 500;
        }
        .subtitle {
            color: #333;
            margin-bottom: 4rem;
            font-family: 'Times New Roman', serif; /* Sesuai desain */
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Grid Card */
        .shops-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            padding: 20px 0;
        }

        /* Style Card yang Baru */
        .shop-card {
            background: white;
            border-radius: 30px; /* Sudut sangat bulat sesuai desain */
            padding: 0 20px 30px 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08); /* Shadow halus */
            position: relative;
            margin-top: 20px; /* Space untuk tag nama warung */
            transition: transform 0.3s;
        }
        .shop-card:hover {
            transform: translateY(-5px);
        }

        /* Label Warung (Pill Shape) */
        .shop-tag {
            background-color: #ff9800;
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 1rem;
            display: inline-block;
            position: relative;
            top: -20px; /* Membuat melayang di atas card */
            box-shadow: 0 4px 10px rgba(255, 152, 0, 0.3);
        }

        .menu-title {
            font-family: 'Times New Roman', serif;
            font-size: 1.5rem;
            margin: 10px 0 20px 0;
            color: #333;
        }

        .menu-list {
            min-height: 100px; /* Menjaga tinggi card seragam */
        }

        .menu-item {
            padding: 8px 0;
            color: #ffa726; /* Warna oranye emas */
            font-size: 1.1rem;
        }
        .menu-item.normal {
            color: #ffcc80; /* Warna lebih pudar untuk item biasa */
        }

        /* Tombol Order Outline (Pil) */
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

        /* Dekorasi Pojok Kiri Bawah (Orange Blob) */
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </div>
            <span>{{ auth()->user()->name ?? 'Hyuu' }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none; border:none; color:red; cursor:pointer; font-size:0.8rem; margin-left:5px;">(Logout)</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <h1 class="page-title">Mau Maem Apa Hari Ini?</h1>
        <p class="subtitle">Bila Nanti Saat Berpisah Telah Tiba</p>

        <div class="shops-grid">

            <div class="shop-card">
                <div class="shop-tag">Warung Ladesh</div>
                <div class="menu-title">Menu</div>
                <div class="menu-list">
                    <div class="menu-item">Coca Cola ★</div>
                    <div class="menu-item normal">Fanta</div>
                </div>
                <a href="{{ route('order.show', ['menu' => 'Coca Cola', 'harga' => 5000, 'shop_id' => 1]) }}" class="btn-order">Order</a>
            </div>

            <div class="shop-card">
                <div class="shop-tag">Warung Mie Ayam</div>
                <div class="menu-title">Menu</div>
                <div class="menu-list">
                    <div class="menu-item">Mie Ayam Bakso ★</div>
                    <div class="menu-item normal">Mie Ayam Spesial</div>
                </div>
                <a href="{{ route('order.show', ['menu' => 'Mie Ayam Bakso', 'harga' => 15000, 'shop_id' => 2]) }}" class="btn-order">Order</a>
            </div>

            <div class="shop-card">
                <div class="shop-tag">Warteg</div>
                <div class="menu-title">Menu</div>
                <div class="menu-list">
                    <div class="menu-item">Nasi Goreng ★</div>
                </div>
                <div style="height: 28px;"></div>
                <a href="{{ route('order.show', ['menu' => 'Nasi Goreng', 'harga' => 12000, 'shop_id' => 3]) }}" class="btn-order">Order</a>
            </div>

            <div class="shop-card">
                <div class="shop-tag">Warung Ayam Geprek</div>
                <div class="menu-title">Menu</div>
                <div class="menu-list">
                    <div class="menu-item">Ayam Geprek ★</div>
                    <div class="menu-item normal">Sambel Merah</div>
                </div>
                <a href="{{ route('order.show', ['menu' => 'Ayam Geprek', 'harga' => 18000, 'shop_id' => 1]) }}" class="btn-order">Order</a>
            </div>

        </div>
    </div>

</body>
</html>
