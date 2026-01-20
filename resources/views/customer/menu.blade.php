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
            background: #f5f5f5;
        }
        .navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .coffee-icon {
            color: #f7931e;
            font-size: 2rem;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }
        .logout-btn:hover {
            background: #c82333;
        }
        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 20px;
        }
        .page-title {
            text-align: center;
            margin-bottom: 1rem;
            color: #333;
            font-size: 2.5rem;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 3rem;
            font-style: italic;
            font-size: 1.1rem;
        }
        .shops-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }
        .shop-card {
            background: white;
            border-radius: 15px;
            padding: 0;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
        }
        .shop-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .shop-header {
            background: linear-gradient(135deg, #f7931e 0%, #ffad60 100%);
            color: white;
            padding: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 1.3rem;
        }
        .shop-body {
            padding: 25px;
        }
        .menu-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }
        .menu-item {
            padding: 10px 0;
            color: #555;
            font-size: 0.95rem;
        }
        .menu-item.special {
            color: #f7931e;
            font-weight: 600;
        }
        .btn-order {
            background: linear-gradient(135deg, #f7931e 0%, #ffad60 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 1rem;
        }
        .btn-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(247, 147, 30, 0.4);
            background: linear-gradient(135deg, #e07a0b 0%, #f7931e 100%);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            K<span class="coffee-icon">☕</span>DI
        </div>
        <div class="user-info">
            <span>Hi, <strong>{{ auth()->user()->name }}</strong></span>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <h1 class="page-title">🍔 Mau Makan Apa Hari Ini?</h1>
        <p class="subtitle">Bila nanti saat berpisah telah tiba</p>

        <div class="shops-grid">
            <!-- Warung Ladesh -->
            <div class="shop-card">
                <div class="shop-header">Warung Ladesh</div>
                <div class="shop-body">
                    <div class="menu-title">Menu</div>
                    <div class="menu-item special">Coca Cola ⭐</div>
                    <div class="menu-item">Fanta</div>

                    <!-- ✅ GANTI BAGIAN INI BRO! -->
                    <a href="{{ route('order.show', ['menu' => 'Coca Cola', 'harga' => 5000, 'shop_id' => 1]) }}"
                       class="btn-order">
                        Order
                    </a>
                </div>
            </div>

            <!-- Warung Mie Ayam -->
            <div class="shop-card">
                <div class="shop-header">Warung Mie Ayam</div>
                <div class="shop-body">
                    <div class="menu-title">Menu</div>
                    <div class="menu-item special">Mie Ayam Bakso ⭐</div>
                    <div class="menu-item">Mie Ayam Spesial</div>

                    <!-- ✅ GANTI BAGIAN INI BRO! -->
                    <a href="{{ route('order.show', ['menu' => 'Mie Ayam Bakso', 'harga' => 15000, 'shop_id' => 2]) }}"
                       class="btn-order">
                        Order
                    </a>
                </div>
            </div>

            <!-- Warteq -->
            <div class="shop-card">
                <div class="shop-header">Warteq</div>
                <div class="shop-body">
                    <div class="menu-title">Menu</div>
                    <div class="menu-item special">Nasi Goreng ⭐</div>

                    <!-- ✅ GANTI BAGIAN INI BRO! -->
                    <a href="{{ route('order.show', ['menu' => 'Nasi Goreng', 'harga' => 12000, 'shop_id' => 3]) }}"
                       class="btn-order">
                        Order
                    </a>
                </div>
            </div>

            <!-- Warung Ayam Geprek -->
            <div class="shop-card">
                <div class="shop-header">Warung Ayam Geprek</div>
                <div class="shop-body">
                    <div class="menu-title">Menu</div>
                    <div class="menu-item special">Ayam Geprek ⭐</div>
                    <div class="menu-item">Sambel Merah</div>

                    <!-- ✅ GANTI BAGIAN INI BRO! -->
                    <a href="{{ route('order.show', ['menu' => 'Ayam Geprek', 'harga' => 18000, 'shop_id' => 1]) }}"
                       class="btn-order">
                        Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
