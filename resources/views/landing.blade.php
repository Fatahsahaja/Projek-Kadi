<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KADI - Coffee Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* --- NAVBAR --- */
        .navbar-custom {
            background-color: white;
            /* Padding kiri-kanan disesuaikan biar mirip screenshot */
            padding: 0 40px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            height: 90px; /* Sedikit lebih tinggi biar lega */
        }

        /* Styling Container Logo */
        .brand-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        /* Styling Gambar Logo Sendiri */
        .logo-img {
            height: 90px; /* Sesuaikan angka ini kalau mau lebih besar/kecil */
            width: auto;
            object-fit: contain;
        }

        /* Menu Items */
        .menu-items {
            display: flex;
            gap: 25px;
            align-items: center;
            padding-right: 60px;
            margin-left: auto;
        }

        .nav-link-custom {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .nav-link-custom:hover {
            color: #f7941d;
        }

        .btn-home {
            background-color: #f7941d;
            color: white !important;
            border-radius: 8px;
            padding: 8px 25px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-home:hover {
            background-color: #d37b12;
        }

        /* --- HERO SECTION --- */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('/images/bg.png');
            background-size: cover;
            background-position: center;
            /* Pakai min-height biar aman di layar besar */
            min-height: calc(100vh - 90px);
            display: flex;
            align-items: center;
            padding-left: 8%;
        }

        .hero-content {
            margin-top: -30px;
        }

        .welcome-text {
            font-family: 'Times New Roman', serif;
            font-size: 4.5rem; /* Font besar sesuai gambar */
            color: white;
            font-weight: 400;
            margin-bottom: 25px;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.3);
            line-height: 1.1;
        }

        .btn-start-order {
            background-color: #f7941d;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 15px 40px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }



        @media (max-width: 768px) {
            .navbar-custom { padding: 0 20px; height: 70px; }
            .logo-img { height: 45px; } /* Kecilin logo di HP */
            .menu-items { display: none; }
            .welcome-text { font-size: 2.5rem; }
        }
    </style>
</head>
<body>

    <div class="navbar-custom">
        <a class="brand-logo" href="#">
            <img src="/images/Logo.png" alt="KADI Logo" class="logo-img">
        </a>

        <div class="menu-items">
            <a href="{{ route('home') ?? '#' }}" class="btn-home px-3">home</a>
            <a href="#" class="nav-link-custom px-3">help</a>
            <a href="#" class="nav-link-custom px-3">about us</a>
            <a href="{{ route('login') }}" class="nav-link-custom px-3">login</a>
        </div>
    </div>

    <section class="hero-section">
        <div class="hero-content">
            <h1 class="welcome-text">WELCOME TO KADI</h1>
            <a href="{{ route('login') }}" class="btn-start-order">START ORDER</a>
        </div>
    </section>

</body>
</html>
