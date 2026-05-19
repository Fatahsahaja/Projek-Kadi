<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — KADI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --orange: #f7941d;
            --orange-light: #fff5eb;
            --orange-mid: #ffc570;
            --dark: #1a1a2e;
            --gray: #64748b;
            --border: #f0f0f0;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fafafa;
            min-height: 100vh;
            color: var(--dark);
        }

        /* NAVBAR */
        .navbar-kadi {
            background: white;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo-img {
            height: 36px;
            object-fit: contain;
        }

        /* HERO SECTION */
        .profile-hero {
            background: linear-gradient(135deg, #f7941d 0%, #ffc570 60%, #fff5eb 100%);
            padding: 40px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .profile-hero::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            top: -100px; right: -80px;
        }

        .profile-hero::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            bottom: -60px; left: -40px;
        }

        .avatar {
            width: 75px; height: 75px;
            background: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; font-weight: 800;
            color: var(--orange);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            flex-shrink: 0;
        }

        .hero-name {
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            margin: 0;
            text-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .hero-sub {
            color: rgba(255,255,255,0.85);
            font-size: 0.85rem;
            margin: 4px 0 0;
        }

        .hero-badge {
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 8px;
        }

        /* TAB NAVIGATION */
        .tab-nav {
            background: white;
            border-radius: 20px 20px 0 0;
            margin-top: -30px;
            position: relative;
            z-index: 10;
            padding: 20px 20px 0;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.05);
        }

        .tab-buttons {
            display: flex;
            gap: 8px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 0;
        }

        .tab-btn {
            padding: 10px 20px;
            border: none;
            background: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--gray);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.2s;
            border-radius: 8px 8px 0 0;
        }

        .tab-btn.active {
            color: var(--orange);
            border-bottom-color: var(--orange);
            background: var(--orange-light);
        }

        .tab-btn:hover:not(.active) {
            color: var(--dark);
            background: #f8f8f8;
        }

        /* CONTENT AREA */
        .tab-content-area {
            background: white;
            padding: 24px 20px 40px;
            min-height: 400px;
        }

        /* STAT CARDS */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--orange-light);
            border-radius: 14px;
            padding: 16px 12px;
            text-align: center;
        }

        .stat-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--orange);
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.72rem;
            color: var(--gray);
            margin-top: 4px;
            font-weight: 500;
        }

        /* DATA DIRI */
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
        }

        .info-item:last-child { border-bottom: none; }

        .info-label {
            font-size: 0.83rem;
            color: var(--gray);
            font-weight: 500;
        }

        .info-value {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--dark);
            text-align: right;
            max-width: 60%;
        }

        .info-empty {
            font-size: 0.83rem;
            color: #cbd5e1;
            font-style: italic;
        }

        /* WARUNG FAVORIT */
        .fav-card {
            background: linear-gradient(135deg, var(--orange-light), white);
            border: 1px solid #fde8cc;
            border-radius: 14px;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        /* RIWAYAT */
        .tx-item {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 10px;
            transition: 0.2s;
        }

        .tx-item:hover {
            border-color: var(--orange-mid);
            box-shadow: 0 4px 12px rgba(247,148,29,0.08);
        }

        .tx-shop { font-size: 0.82rem; color: var(--gray); }
        .tx-amount { font-weight: 700; color: var(--orange); }
        .tx-date { font-size: 0.78rem; color: #94a3b8; }

        .status-sukses { background:#f0fdf4; color:#10b981; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; }
        .status-pending { background:#fff7ed; color:#f7941d; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; }
        .status-batal { background:#fef2f2; color:#ef4444; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; }
        .status-selesai { background:#eff6ff; color:#3b82f6; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; }

        /* DOMPET */
        .wallet-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #2d2d44 100%);
            border-radius: 20px;
            padding: 28px 24px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .wallet-card::before {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            background: rgba(247,148,29,0.15);
            border-radius: 50%;
            top: -60px; right: -60px;
        }

        .wallet-card::after {
            content: '';
            position: absolute;
            width: 120px; height: 120px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            bottom: -30px; left: 20px;
        }

        .wallet-label {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.6);
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .wallet-balance {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            margin: 8px 0;
        }

        .wallet-name {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.5);
        }

        .wallet-chip {
            width: 40px; height: 30px;
            background: linear-gradient(135deg, var(--orange), var(--orange-mid));
            border-radius: 6px;
            position: absolute;
            right: 24px; top: 28px;
        }

        .topup-btn {
            background: linear-gradient(135deg, var(--orange), var(--orange-mid));
            border: none;
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            padding: 14px;
            width: 100%;
            border-radius: 12px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.2s;
            margin-bottom: 12px;
        }

        .topup-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(247,148,29,0.3);
        }

        .topup-info {
            background: var(--orange-light);
            border-radius: 12px;
            padding: 14px;
            font-size: 0.8rem;
            color: var(--gray);
            line-height: 1.6;
        }

        /* TOPUP MODAL */
        .topup-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .topup-modal {
            background: white;
            border-radius: 24px 24px 0 0;
            padding: 28px 24px 40px;
            width: 100%;
            max-width: 500px;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }

        .topup-handle {
            width: 40px; height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            margin: 0 auto 20px;
        }

        .nominal-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin: 16px 0;
        }

        .nominal-btn {
            border: 2px solid var(--border);
            background: white;
            border-radius: 10px;
            padding: 12px 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--dark);
            cursor: pointer;
            transition: 0.2s;
            text-align: center;
        }

        .nominal-btn:hover, .nominal-btn.selected {
            border-color: var(--orange);
            background: var(--orange-light);
            color: var(--orange);
        }

        .confirm-topup-btn {
            background: linear-gradient(135deg, var(--orange), var(--orange-mid));
            border: none;
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            padding: 14px;
            width: 100%;
            border-radius: 12px;
            font-size: 0.9rem;
            cursor: pointer;
            margin-top: 8px;
        }

        /* DECORATION */
        .deco-wave {
            position: fixed;
            bottom: 0; left: 0;
            width: 180px; height: 120px;
            background: var(--orange);
            border-top-right-radius: 100%;
            z-index: -1;
            opacity: 0.6;
        }

        @media (max-width: 576px) {
            .stat-value { font-size: 0.9rem; }
            .wallet-balance { font-size: 1.6rem; }
        }
    </style>
</head>
<body x-data="profilApp()" x-init="init()">

{{-- NAVBAR --}}
<nav class="navbar-kadi">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="{{ route('customer.menu') }}">
            <img src="{{ asset('images/Logo.png') }}" alt="KADI" class="logo-img">
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('customer.menu') }}" class="btn btn-outline-warning rounded-pill btn-sm px-3">
                <i class="bi bi-shop me-1"></i> Menu
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</button>
            </form>
        </div>
    </div>
</nav>

{{-- HERO --}}
<div class="profile-hero">
    <div class="container" style="max-width:500px; position:relative; z-index:2;">
        <div class="d-flex align-items-center gap-3">
            <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div>
                <h1 class="hero-name">{{ $user->name }}</h1>
                @if($nisData)
                    <p class="hero-sub">{{ $nisData->nama }}</p>
                    <span class="hero-badge">Kelas {{ $nisData->kelas }} · {{ $nisData->jurusan }}</span>
                @else
                    <p class="hero-sub">Customer KADI</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MAIN CARD --}}
<div class="container" style="max-width:500px; padding:0 16px;">
    <div class="tab-nav">
        <div class="tab-buttons">
            <button class="tab-btn" :class="{ active: tab === 'profil' }" @click="tab = 'profil'">
                <i class="bi bi-person me-1"></i> Profil
            </button>
            <button class="tab-btn" :class="{ active: tab === 'dompet' }" @click="tab = 'dompet'">
                <i class="bi bi-wallet2 me-1"></i> Dompet
            </button>
            <button class="tab-btn" :class="{ active: tab === 'riwayat' }" @click="tab = 'riwayat'">
                <i class="bi bi-receipt me-1"></i> Riwayat
            </button>
        </div>
    </div>

    <div class="tab-content-area">

        {{-- TAB PROFIL --}}
        <div x-show="tab === 'profil'" x-transition>

            {{-- Stat Cards --}}
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-value">Rp {{ number_format($totalPengeluaran/1000, 0) }}k</div>
                    <div class="stat-label">Total Jajan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $transactions->total() }}</div>
                    <div class="stat-label">Total Order</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value text-success" style="color:#10b981!important">
                        {{ $transactions->getCollection()->where('status','SUKSES', 'SELESAI')->count() }}
                    </div>
                    <div class="stat-label">Sukses</div>
                </div>
            </div>

            {{-- Warung Favorit --}}
            @if($warungFavorit)
            <div class="fav-card">
                <div>
                    <div style="font-size:0.75rem;color:var(--gray);font-weight:500;">⭐ Warung Favorit</div>
                    <div style="font-weight:700;margin-top:4px;">{{ $warungFavorit->shop->name }}</div>
                </div>
                <span style="background:var(--orange);color:white;padding:4px 12px;border-radius:20px;font-size:0.78rem;font-weight:700;">
                    {{ $warungFavorit->total }}x
                </span>
            </div>
            @endif

            {{-- Data Diri --}}
            <div style="font-weight:700;font-size:0.9rem;margin-bottom:12px;">📋 Data Diri</div>

            <div class="info-item">
                <span class="info-label">Nama Akun</span>
                <span class="info-value">{{ $user->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">No. Telepon</span>
                <span class="info-value">{{ $user->phone }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">NIS</span>
                @if($user->nis)
                    <span class="info-value">{{ $user->nis }}</span>
                @else
                    <span class="info-empty">Tanpa NIS</span>
                @endif
            </div>
            @if($nisData)
            <div class="info-item">
                <span class="info-label">Nama Lengkap</span>
                <span class="info-value">{{ $nisData->nama }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Kelas</span>
                <span class="info-value">{{ $nisData->kelas }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jurusan</span>
                <span class="info-value">{{ $nisData->jurusan }}</span>
            </div>
            @endif
        </div>

        {{-- TAB DOMPET --}}
        <div x-show="tab === 'dompet'" x-transition>
            <div class="wallet-card">
                <div class="wallet-chip"></div>
                <div class="wallet-label">Saldo KADI</div>
                <div class="wallet-balance">Rp {{ number_format($user->balance ?? 0, 0, ',', '.') }}</div>
                <div class="wallet-name">{{ $user->name }}</div>
            </div>

            <a href="{{ route('customer.topup') }}" class="topup-btn d-block text-center text-decoration-none">
                <i class="bi bi-plus-circle me-2"></i> Isi Saldo
            </a>

            {{-- Cek ada pending refund --}}
            @php
                $pendingRefund = \App\Models\RefundRequest::where('user_id', $user->id)
                    ->where('status', 'PENDING')->first();
            @endphp

            @if($pendingRefund)
            {{-- Ada refund pending --}}
            <div class="topup-info mb-3" style="background:#fff7ed; border:1px solid #fde8cc;">
                <strong>⏳ Refund Sedang Diproses</strong><br>
                Rp {{ number_format($pendingRefund->amount, 0, ',', '.') }} ke
                {{ $pendingRefund->ewallet_type }} {{ $pendingRefund->ewallet_number }}<br>
                <small class="text-muted">Menunggu konfirmasi admin KADI</small>
            </div>
            @else
            {{-- Form request refund --}}
            <div class="topup-info mb-3">
                <strong>💸 Refund Saldo ke E-Wallet</strong><br>
                Cairkan sisa saldo ke GoPay, DANA, OVO, atau ShopeePay kamu.
                Minimal refund <strong>Rp 10.000</strong>.
            </div>

            <div x-data="{ showRefund: false }">
                <button class="topup-btn" style="background:linear-gradient(135deg,#1a1f2e,#2d2d44);"
                        @click="showRefund = !showRefund">
                    <i class="bi bi-cash-stack me-2"></i>
                    <span x-text="showRefund ? 'Tutup Form Refund' : 'Ajukan Refund Saldo'"></span>
                </button>

                <div x-show="showRefund" x-transition class="mt-3 p-3 border rounded-3">
                    <form action="{{ route('customer.refund.store') }}" method="POST">
                        @csrf

                        @if(session('error'))
                        <div class="alert alert-danger py-2 small mb-3">{{ session('error') }}</div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nominal Refund</label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:0.85rem;">Rp</span>
                                <input type="number" name="amount" class="form-control"
                                       placeholder="Minimal 10.000"
                                       min="10000" max="{{ $user->balance }}"
                                       value="{{ old('amount') }}" required>
                            </div>
                            <small class="text-muted">Saldo tersedia: Rp {{ number_format($user->balance, 0, ',', '.') }}</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">E-Wallet Tujuan</label>
                            <select name="ewallet_type" class="form-select" required>
                                <option value="">Pilih E-Wallet</option>
                                <option value="GoPay"     {{ old('ewallet_type') === 'GoPay'     ? 'selected' : '' }}>GoPay</option>
                                <option value="DANA"      {{ old('ewallet_type') === 'DANA'      ? 'selected' : '' }}>DANA</option>
                                <option value="OVO"       {{ old('ewallet_type') === 'OVO'       ? 'selected' : '' }}>OVO</option>
                                <option value="ShopeePay" {{ old('ewallet_type') === 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nomor E-Wallet</label>
                            <input type="text" name="ewallet_number" class="form-control"
                                   placeholder="08xxxxxxxxxx"
                                   value="{{ old('ewallet_number', $user->phone) }}"
                                   minlength="10" maxlength="20" required>
                            <small class="text-muted">Nomor HP yang terdaftar di e-wallet</small>
                        </div>

                        <button type="submit" class="topup-btn"
                                style="background:linear-gradient(135deg,#ef4444,#f87171);"
                                onclick="return confirm('Ajukan refund? Saldo akan dibekukan hingga admin memproses.')">
                            <i class="bi bi-send me-2"></i> Kirim Permintaan Refund
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <div class="topup-info mt-3">
                <strong>ℹ️ Cara Isi Saldo:</strong><br>
                1. Pilih nominal yang ingin ditambahkan<br>
                2. Lakukan pembayaran ke Admin KADI<br>
                3. Admin akan mengkonfirmasi dan saldo otomatis bertambah
            </div>
        </div>

        {{-- TAB RIWAYAT --}}
        <div x-show="tab === 'riwayat'" x-transition>
            @forelse($transactions as $tx)
            <div class="tx-item">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <span style="font-weight:700;font-size:0.88rem;">#{{ $tx->id }}</span>
                        <span class="tx-shop ms-2">{{ $tx->shop->name }}</span>
                    </div>
                    @if($tx->status === 'SUKSES')
                        <span class="status-sukses">✅ SUKSES</span>
                    @elseif($tx->status === 'PENDING')
                        <span class="status-pending">⏳ PENDING</span>
                    @elseif($tx->status === 'DIBATALKAN')
                        <span class="status-batal">❌ BATAL</span>
                    @else
                        <span class="status-selesai">📦 SELESAI</span>
                    @endif
                </div>

                {{-- Metode bayar --}}
                <div class="mb-1">
                    <small style="color:#94a3b8;">
                        {{ $tx->payment_method === 'saldo' ? '💰 Saldo' : '💵 Cash (Kasir)' }}
                    </small>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-1">
                    <span class="tx-amount">Rp {{ number_format($tx->total, 0, ',', '.') }}</span>
                    <span class="tx-date">{{ $tx->created_at->format('d M Y · H:i') }}</span>
                </div>

                {{-- Tombol aksi --}}
                <div class="d-flex gap-2 mt-2">
                    <a href="{{ route('transactions.show', $tx->id) }}"
                       class="btn btn-sm btn-outline-warning rounded-pill px-3"
                       style="font-size:0.78rem;">
                        🧾 Detail
                    </a>

                    @if(in_array($tx->status, ['PENDING', 'SUKSES']) && $tx->payment_method === 'saldo' || $tx->status === 'PENDING')
                    <form action="{{ route('transactions.cancel', $tx->id) }}" method="POST"
                          onsubmit="return confirm('Batalkan pesanan ini?{{ $tx->payment_method === 'saldo' && $tx->status === 'SUKSES' ? ' Saldo akan dikembalikan.' : '' }}')">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                style="font-size:0.78rem;">
                            ❌ Batalkan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-5" style="color:#94a3b8;">
                <i class="bi bi-receipt" style="font-size:3rem;opacity:0.3;display:block;margin-bottom:12px;"></i>
                Belum ada riwayat jajan!
            </div>
            @endforelse

            <div class="d-flex justify-content-center mt-3">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</div>

{{-- TOPUP MODAL --}}
<div class="topup-modal-overlay" x-show="showTopup" x-transition @click.self="showTopup = false">
    <div class="topup-modal">
        <div class="topup-handle"></div>
        <h5 style="font-weight:800;margin-bottom:4px;">Isi Saldo</h5>
        <p style="font-size:0.82rem;color:var(--gray);margin-bottom:0;">Pilih nominal top up</p>

        <div class="nominal-grid">
            <button class="nominal-btn" :class="{ selected: nominal === 5000 }" @click="nominal = 5000">Rp 5.000</button>
            <button class="nominal-btn" :class="{ selected: nominal === 10000 }" @click="nominal = 10000">Rp 10.000</button>
            <button class="nominal-btn" :class="{ selected: nominal === 20000 }" @click="nominal = 20000">Rp 20.000</button>
            <button class="nominal-btn" :class="{ selected: nominal === 25000 }" @click="nominal = 25000">Rp 25.000</button>
            <button class="nominal-btn" :class="{ selected: nominal === 50000 }" @click="nominal = 50000">Rp 50.000</button>
            <button class="nominal-btn" :class="{ selected: nominal === 100000 }" @click="nominal = 100000">Rp 100.000</button>
        </div>

        <div x-show="nominal > 0" style="background:#f8fafc;border-radius:10px;padding:12px;margin-bottom:12px;font-size:0.83rem;">
            <div class="d-flex justify-content-between">
                <span style="color:var(--gray);">Nominal</span>
                <span style="font-weight:700;" x-text="'Rp ' + nominal.toLocaleString('id-ID')"></span>
            </div>
            <div class="d-flex justify-content-between mt-1">
                <span style="color:var(--gray);">Status</span>
                <span style="color:#f7941d;font-weight:600;">Menunggu konfirmasi admin</span>
            </div>
        </div>

        <button class="confirm-topup-btn" @click="requestTopup()" :disabled="nominal === 0">
            <i class="bi bi-send me-2"></i> Kirim Permintaan Top Up
        </button>
    </div>
</div>

<div class="deco-wave"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@vite(['resources/js/app.js'])
<script>
function profilApp() {
    return {
        tab: 'profil',
        showTopup: false,
        nominal: 0,

        init() {
            // Cek URL hash untuk default tab
            const hash = window.location.hash.replace('#', '');
            if (['profil', 'dompet', 'riwayat'].includes(hash)) {
                this.tab = hash;
            }
        },

        requestTopup() {
            if (this.nominal === 0) return;
            this.showTopup = false;
            alert(`Permintaan top up Rp ${this.nominal.toLocaleString('id-ID')} berhasil dikirim!\nTunggu konfirmasi dari Admin KADI.`);
            this.nominal = 0;
        }
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('swal'))
<script>
    Swal.fire({
        icon: "{{ session('swal.type') }}",
        title: "{{ session('swal.title') }}",
        text: "{{ session('swal.text') }}",
        confirmButtonColor: "#f7941d",
    });
</script>
@endif
</body>
</html>
