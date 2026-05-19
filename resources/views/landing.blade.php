<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KADI - Sistem Pemesanan Kantin Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #fff; overflow-x: hidden; color: #1a1f2e; }

        /* ===== NAVBAR ===== */
        .navbar-kadi {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 18px 6%;
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #f5f5f5;
            transition: 0.3s;
        }
        .navbar-kadi.scrolled {
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .logo-img { height: 48px; width: auto; }
        .nav-links { display: flex; align-items: center; gap: 25px; }
        .nav-link-item {
            color: #555; text-decoration: none;
            font-weight: 500; font-size: 0.9rem; transition: 0.2s;
        }
        .nav-link-item:hover { color: #f7941d; }
        .btn-nav-login {
            color: #f7941d; border: 1.5px solid #f7941d;
            border-radius: 50px; padding: 8px 24px;
            font-weight: 600; font-size: 0.9rem;
            text-decoration: none; transition: 0.2s;
        }
        .btn-nav-login:hover { background: #fff5e6; color: #f7941d; }
        .btn-nav-daftar {
            background: #f7941d; color: white;
            border: none; border-radius: 50px;
            padding: 8px 24px; font-weight: 700;
            font-size: 0.9rem; text-decoration: none; transition: 0.2s;
        }
        .btn-nav-daftar:hover { background: #e8830d; color: white; transform: translateY(-1px); }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            background: #fff;
            display: flex; align-items: center;
            padding: 120px 6% 80px;
            position: relative; overflow: hidden;
        }

        /* Dekorasi subtle */
        .hero-deco-1 {
            position: absolute; top: -80px; right: -80px;
            width: 500px; height: 500px;
            background: #fff5e6;
            border-radius: 50%; z-index: 0;
        }
        .hero-deco-2 {
            position: absolute; bottom: -100px; left: -60px;
            width: 300px; height: 300px;
            background: #fff9f2;
            border-radius: 50%; z-index: 0;
        }
        .hero-deco-dot {
            position: absolute; top: 30%; left: 45%;
            width: 8px; height: 8px;
            background: #f7941d; border-radius: 50%; opacity: 0.4;
        }

        .hero-content { position: relative; z-index: 1; max-width: 580px; }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: #fff5e6; color: #f7941d;
            border: 1px solid #fde4bb;
            border-radius: 50px; padding: 7px 18px;
            font-size: 0.82rem; font-weight: 600;
            margin-bottom: 28px; letter-spacing: 0.3px;
        }

        .hero-title {
            font-size: 3.8rem; font-weight: 900;
            color: #1a1f2e; line-height: 1.1;
            margin-bottom: 20px;
        }
        .hero-title .orange { color: #f7941d; }

        .hero-desc {
            font-size: 1.05rem; color: #666;
            line-height: 1.8; margin-bottom: 40px;
            font-weight: 400;
        }

        .hero-cta { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }

        .btn-hero-main {
            background: #f7941d; color: white;
            border: none; border-radius: 50px;
            padding: 14px 36px; font-weight: 700;
            font-size: 1rem; text-decoration: none;
            box-shadow: 0 8px 25px rgba(247,148,29,0.35);
            transition: 0.3s; display: inline-flex;
            align-items: center; gap: 8px;
        }
        .btn-hero-main:hover {
            background: #e8830d; color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(247,148,29,0.45);
        }
        .btn-hero-ghost {
            color: #555; text-decoration: none;
            font-weight: 600; font-size: 0.95rem;
            display: inline-flex; align-items: center; gap: 6px;
            transition: 0.2s; padding: 14px 10px;
        }
        .btn-hero-ghost:hover { color: #f7941d; }
        .btn-hero-ghost .arrow {
            width: 32px; height: 32px;
            background: #f5f5f5; border-radius: 50%;
            display: flex; align-items: center;
            justify-content: center; font-size: 0.9rem;
            transition: 0.2s;
        }
        .btn-hero-ghost:hover .arrow { background: #fff5e6; }

        /* Stats */
        .hero-stats {
            display: flex; gap: 35px; margin-top: 55px;
            padding-top: 40px;
            border-top: 1px solid #f0f0f0;
        }
        .stat-num {
            font-size: 1.8rem; font-weight: 900; color: #f7941d; line-height: 1;
        }
        .stat-label { font-size: 0.78rem; color: #999; margin-top: 4px; }

        /* Phone mockup kanan */
        .hero-visual {
            position: absolute; right: 6%; top: 50%;
            transform: translateY(-50%); z-index: 1;
        }
        .phone-mockup {
            width: 250px; background: white;
            border-radius: 36px; padding: 12px;
            box-shadow: 0 25px 70px rgba(0,0,0,0.12),
                        0 0 0 1px rgba(0,0,0,0.05);
        }
        .phone-screen {
            background: #fafafa; border-radius: 26px;
            padding: 18px; min-height: 400px;
        }
        .mock-topbar {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 18px;
        }
        .mock-logo { font-weight: 900; color: #1a1f2e; font-size: 1rem; }
        .mock-logo span { color: #f7941d; }
        .mock-chip {
            background: #fff5e6; color: #f7941d;
            font-size: 0.65rem; font-weight: 700;
            padding: 3px 10px; border-radius: 50px;
        }
        .mock-section { font-size: 0.7rem; font-weight: 700; color: #333; margin-bottom: 12px; }
        .mock-card {
            background: white; border-radius: 14px;
            padding: 10px; margin-bottom: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            display: flex; align-items: center; gap: 10px;
        }
        .mock-img {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #fff5e6, #fde4bb);
            border-radius: 10px; display: flex;
            align-items: center; justify-content: center;
            font-size: 1.3rem; flex-shrink: 0;
        }
        .mock-name { font-size: 0.7rem; font-weight: 700; color: #333; }
        .mock-price { font-size: 0.65rem; color: #f7941d; font-weight: 600; }
        .mock-add {
            margin-left: auto; background: #f7941d;
            color: white; border: none; border-radius: 8px;
            width: 26px; height: 26px; font-size: 1rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .mock-cta {
            background: #f7941d; border-radius: 12px;
            padding: 10px; text-align: center;
            color: white; font-weight: 700; font-size: 0.72rem;
            margin-top: 10px;
        }

        /* ===== FEATURES ===== */
        .features { padding: 100px 6%; background: #fafafa; }

        .section-eyebrow {
            display: inline-block;
            background: #fff5e6; color: #f7941d;
            border: 1px solid #fde4bb;
            border-radius: 50px; padding: 5px 18px;
            font-size: 0.78rem; font-weight: 700;
            letter-spacing: 0.5px; text-transform: uppercase;
            margin-bottom: 14px;
        }
        .section-title {
            font-size: 2.4rem; font-weight: 800;
            color: #1a1f2e; line-height: 1.25; margin-bottom: 12px;
        }
        .section-title .orange { color: #f7941d; }
        .section-sub { font-size: 0.95rem; color: #888; line-height: 1.7; max-width: 480px; }

        .feat-card {
            background: white; border-radius: 20px;
            padding: 30px 28px; height: 100%;
            border: 1px solid #f0f0f0;
            transition: 0.3s;
        }
        .feat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 45px rgba(247,148,29,0.1);
            border-color: #fde4bb;
        }
        .feat-icon {
            width: 56px; height: 56px;
            background: #fff5e6; border-radius: 16px;
            display: flex; align-items: center;
            justify-content: center; font-size: 1.6rem;
            margin-bottom: 18px;
        }
        .feat-title { font-size: 1.05rem; font-weight: 700; color: #1a1f2e; margin-bottom: 8px; }
        .feat-desc { font-size: 0.88rem; color: #888; line-height: 1.7; }

        /* ===== BOTTOM CTA ===== */
        .bottom-cta {
            padding: 90px 6%;
            background: white;
            text-align: center;
            border-top: 1px solid #f0f0f0;
        }
        .cta-box {
            background: linear-gradient(135deg, #fff5e6 0%, #fff9f2 100%);
            border: 1px solid #fde4bb;
            border-radius: 30px; padding: 60px 40px;
            max-width: 700px; margin: 0 auto;
            position: relative; overflow: hidden;
        }
        .cta-box::before {
            content: '🍽️';
            position: absolute; top: -10px; right: 40px;
            font-size: 5rem; opacity: 0.12;
        }
        .cta-title {
            font-size: 2.2rem; font-weight: 900;
            color: #1a1f2e; margin-bottom: 12px;
        }
        .cta-title .orange { color: #f7941d; }
        .cta-desc { font-size: 0.95rem; color: #888; margin-bottom: 30px; line-height: 1.7; }
        .btn-cta-main {
            background: #f7941d; color: white;
            border: none; border-radius: 50px;
            padding: 14px 44px; font-weight: 700;
            font-size: 1rem; text-decoration: none;
            box-shadow: 0 8px 25px rgba(247,148,29,0.35);
            transition: 0.3s; display: inline-block;
        }
        .btn-cta-main:hover {
            background: #e8830d; color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(247,148,29,0.45);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #1a1f2e; padding: 28px 6%;
            display: flex; justify-content: space-between; align-items: center;
        }
        .footer-logo { color: white; font-weight: 800; font-size: 1.1rem; }
        .footer-logo span { color: #f7941d; }
        .footer-copy { color: #555; font-size: 0.82rem; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .hero-visual { display: none; }
            .hero-title { font-size: 3rem; }
        }
        @media (max-width: 768px) {
            .navbar-kadi { padding: 14px 20px; }
            .nav-link-item { display: none; }
            .hero { padding: 100px 20px 60px; }
            .hero-title { font-size: 2.2rem; }
            .hero-desc { font-size: 0.95rem; }
            .btn-hero-main { width: 100%; justify-content: center; }
            .btn-hero-ghost { width: 100%; justify-content: center; }
            .hero-cta { flex-direction: column; }
            .hero-stats { gap: 20px; }
            .stat-num { font-size: 1.5rem; }
            .features { padding: 60px 20px; }
            .section-title { font-size: 1.9rem; }
            .bottom-cta { padding: 60px 20px; }
            .cta-box { padding: 40px 25px; border-radius: 20px; }
            .cta-title { font-size: 1.8rem; }
            .btn-cta-main { width: 100%; text-align: center; }
            .footer { flex-direction: column; gap: 8px; text-align: center; }
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar-kadi" id="navbar">
    <a href="{{ route('home') }}">
        <img src="/images/Logo.png" alt="KADI" class="logo-img">
    </a>
    <div class="nav-links">
        <a href="#fitur" class="nav-link-item">Fitur</a>
        <a href="{{ route('login') }}" class="btn-nav-login">Masuk</a>
        <a href="{{ route('register') }}" class="btn-nav-daftar">Daftar</a>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-deco-1"></div>
    <div class="hero-deco-2"></div>
    <div class="hero-deco-dot"></div>

    <div class="hero-content">
        <div class="hero-badge">
             Kantin Digital Sekolah
        </div>

        <h1 class="hero-title">
            Pesan Makan<br>
            di Kantin Jadi<br>
            <span class="orange">Lebih Gampang</span>
        </h1>

        <p class="hero-desc">
            Tidak perlu antri. Tidak perlu uang tunai. Cukup pilih menu, bayar, tunjukkan QR — pesanan langsung diproses!
        </p>

        <div class="hero-cta">
            <a href="{{ route('login') }}" class="btn-hero-main">
             Mulai Pesan
            </a>
            <a href="{{ route('register') }}" class="btn-hero-ghost">
                <span class="arrow">→</span>
                Daftar Gratis
            </a>
        </div>

        <div class="hero-stats">
            <div>
                <div class="stat-num">6+</div>
                <div class="stat-label">Warung</div>
            </div>
            <div>
                <div class="stat-num">100%</div>
                <div class="stat-label">Comfort</div>
            </div>
            <div>
                <div class="stat-num">QR</div>
                <div class="stat-label">Konfirmasi Instan</div>
            </div>
        </div>
    </div>

    {{-- Phone Mockup --}}
    <div class="hero-visual">
        <div class="phone-mockup">
            <div class="phone-screen">
                <div class="mock-topbar">
                    <div class="mock-logo">K<span>✦</span>DI</div>
                    <div class="mock-chip">🛒 0</div>
                </div>
                <div class="mock-section">Menu Tersedia</div>
                <div class="mock-card">
                    <div class="mock-img">🍛</div>
                    <div>
                        <div class="mock-name">Nasi Goreng</div>
                        <div class="mock-price">Rp 10.000</div>
                    </div>
                    <button class="mock-add">+</button>
                </div>
                <div class="mock-card">
                    <div class="mock-img">🍗</div>
                    <div>
                        <div class="mock-name">Ayam Goyeng</div>
                        <div class="mock-price">Rp 8.000</div>
                    </div>
                    <button class="mock-add">+</button>
                </div>
                <div class="mock-card">
                    <div class="mock-img">🧋</div>
                    <div>
                        <div class="mock-name">Es TeaJus</div>
                        <div class="mock-price">Rp 3.000</div>
                    </div>
                    <button class="mock-add">+</button>
                </div>
                <div class="mock-cta">Lihat Keranjang</div>
            </div>
        </div>
    </div>
</section>

{{-- FEATURES --}}
<section class="features" id="fitur">
    <div class="row align-items-end mb-5 g-0">
        <div class="col-lg-5 mb-4 mb-lg-0">
            <span class="section-eyebrow">✨ Keunggulan</span>
            <h2 class="section-title">
                Kenapa Pakai<br>
                <span class="orange">KADI?</span>
            </h2>
            <p class="section-sub">Dirancang khusus untuk kebutuhan kantin sekolah — simpel, cepat, dan aman.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4 col-sm-6">
            <div class="feat-card">
                <div class="feat-icon">📱</div>
                <div class="feat-title">Pesan dari HP</div>
                <div class="feat-desc">Siswa pesan makanan langsung dari smartphone tanpa antri panjang di kantin.</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feat-card">
                <div class="feat-icon">🔲</div>
                <div class="feat-title">Detail Transaksi Dengan QR</div>
                <div class="feat-desc">Setiap pesanan generate QR unik. Dapat scan untuk melihat detail transaksi.</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feat-card">
                <div class="feat-icon">💰</div>
                <div class="feat-title">Pembayaran Praktis</div>
                <div class="feat-desc">Semua transaksi dapat tercatat secara sistematis. Balance warung terupdate otomatis setiap transaksi.</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feat-card">
                <div class="feat-icon">🏪</div>
                <div class="feat-title">Multi Warung</div>
                <div class="feat-desc">Kelola banyak warung dalam satu sistem. Tiap warung punya dashboard sendiri.</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feat-card">
                <div class="feat-icon">⚡</div>
                <div class="feat-title">Style Website Kantin Unik</div>
                <div class="feat-desc">Syle website memanjakan mata untuk pengguna website.</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feat-card">
                <div class="feat-icon">📊</div>
                <div class="feat-title">Laporan CSV</div>
                <div class="feat-desc">Lihat semua transaksi, filter by tanggal, dan export laporan ke CSV kapan saja.</div>
            </div>
        </div>
    </div>
</section>

{{-- BOTTOM CTA --}}
<section class="bottom-cta">
    <div class="cta-box">
        <h2 class="cta-title">
            Siap Mulai<br>
            <span class="orange">Pesan Sekarang?</span>
        </h2>
        <p class="cta-desc">Daftar gratis dan nikmati kemudahan pesan makan di kantin sekolah!</p>
        <a href="{{ route('register') }}" class="btn-cta-main">
            Daftar Sekarang — Gratis!
        </a>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer">
    <div class="footer-logo">K<span>✦</span>DI</div>
    <div class="footer-copy">© 2026 KADI — Sistem Pemesanan Kantin Digital</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 30) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href'))
                ?.scrollIntoView({ behavior: 'smooth' });
        });
    });
</script>
</body>
</html>
