<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Saldo — KADI</title>
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
            --green: #10b981;
            --blue: #3b82f6;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8f8fc;
            min-height: 100vh;
            color: var(--dark);
        }

        /* HEADER */
        .header {
            background: white;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .back-btn {
            width: 36px; height: 36px;
            border: none;
            background: var(--orange-light);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--orange);
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
        }

        .header-title {
            font-size: 1rem;
            font-weight: 700;
        }

        /* SALDO CARD */
        .saldo-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            margin: 20px 16px 0;
            border-radius: 20px;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        .saldo-card::before {
            content: '';
            position: absolute;
            width: 180px; height: 180px;
            background: rgba(247,148,29,0.12);
            border-radius: 50%;
            top: -60px; right: -40px;
        }

        .saldo-card::after {
            content: '';
            position: absolute;
            width: 100px; height: 100px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
            bottom: -20px; left: 20px;
        }

        .saldo-label {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.5);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .saldo-amount {
            font-size: 1.9rem;
            font-weight: 800;
            color: white;
            margin: 6px 0 4px;
        }

        .saldo-name {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.4);
        }

        .saldo-chip {
            position: absolute;
            right: 24px; top: 24px;
            width: 36px; height: 28px;
            background: linear-gradient(135deg, var(--orange), var(--orange-mid));
            border-radius: 5px;
            opacity: 0.9;
        }

        /* MAIN CONTAINER */
        .main { padding: 20px 16px 40px; max-width: 500px; margin: 0 auto; }

        /* SECTION TITLE */
        .section-title {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--gray);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        /* NOMINAL SECTION */
        .nominal-section { margin-bottom: 24px; }

        .nominal-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 12px;
        }

        .nominal-btn {
            border: 2px solid var(--border);
            background: white;
            border-radius: 12px;
            padding: 14px 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--dark);
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .nominal-btn:hover {
            border-color: var(--orange);
            background: var(--orange-light);
            color: var(--orange);
        }

        .nominal-btn.selected {
            border-color: var(--orange);
            background: var(--orange);
            color: white;
            transform: scale(1.03);
            box-shadow: 0 4px 15px rgba(247,148,29,0.3);
        }

        /* CUSTOM INPUT */
        .custom-input-wrap {
            position: relative;
        }

        .custom-input-wrap .prefix {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 700;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .custom-input {
            width: 100%;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px 14px 48px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--dark);
            background: white;
            transition: 0.2s;
            outline: none;
        }

        .custom-input:focus {
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(247,148,29,0.1);
        }

        .custom-input::placeholder { color: #cbd5e1; font-weight: 400; }

        /* METODE SECTION */
        .metode-section { margin-bottom: 24px; }

        .metode-card {
            background: white;
            border: 2px solid var(--border);
            border-radius: 16px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 10px;
            position: relative;
        }

        .metode-card:hover { border-color: #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.06); }

        .metode-card.selected {
            border-color: var(--orange);
            background: var(--orange-light);
        }

        .metode-logo {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
            font-weight: 900;
        }

        .logo-qris { background: #e8f4ff; }
        .logo-dana { background: #e8f4ff; color: #0066cc; }
        .logo-gopay { background: #e8fff4; color: #00aa5b; }

        .metode-info { flex: 1; }
        .metode-name { font-weight: 700; font-size: 0.9rem; }
        .metode-desc { font-size: 0.75rem; color: var(--gray); margin-top: 2px; }

        .metode-check {
            width: 22px; height: 22px;
            border: 2px solid var(--border);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: 0.2s;
            flex-shrink: 0;
        }

        .metode-card.selected .metode-check {
            background: var(--orange);
            border-color: var(--orange);
            color: white;
        }

        /* DETAIL BOX */
        .detail-box {
            background: white;
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 24px;
            border: 1px solid var(--border);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 0.85rem;
        }

        .detail-row:not(:last-child) { border-bottom: 1px solid #f8f8f8; }
        .detail-label { color: var(--gray); }
        .detail-value { font-weight: 700; }
        .detail-total { color: var(--orange); font-size: 1rem; }

        /* PAYMENT INSTRUCTION */
        .instruction-box {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid var(--border);
            display: none;
        }

        .instruction-box.show { display: block; }

        /* QRIS Box */
        .qris-box {
            text-align: center;
        }

        .qris-img {
            width: 180px; height: 180px;
            background: white;
            border: 3px solid var(--dark);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px;
            padding: 8px;
            position: relative;
        }

        .qris-pattern {
            width: 100%; height: 100%;
            background-image:
                repeating-linear-gradient(0deg, transparent, transparent 6px, #1a1a2e 6px, #1a1a2e 7px),
                repeating-linear-gradient(90deg, transparent, transparent 6px, #1a1a2e 6px, #1a1a2e 7px);
            border-radius: 8px;
            opacity: 0.15;
        }

        .qris-overlay {
            position: absolute;
            inset: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-direction: column;
        }

        .qris-logo-text {
            font-size: 1.2rem;
            font-weight: 900;
            color: var(--dark);
            letter-spacing: 2px;
        }

        .qris-sub {
            font-size: 0.65rem;
            color: var(--gray);
            margin-top: 2px;
        }

        /* E-wallet box */
        .ewallet-box { }

        .ewallet-number {
            background: var(--orange-light);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            margin: 12px 0;
        }

        .ewallet-number .label {
            font-size: 0.75rem;
            color: var(--gray);
            margin-bottom: 4px;
        }

        .ewallet-number .number {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: 2px;
        }

        .ewallet-number .name {
            font-size: 0.8rem;
            color: var(--gray);
            margin-top: 4px;
        }

        .copy-btn {
            background: white;
            border: 2px solid var(--orange);
            color: var(--orange);
            border-radius: 10px;
            padding: 10px 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            width: 100%;
            transition: 0.2s;
            margin-top: 4px;
        }

        .copy-btn:hover {
            background: var(--orange);
            color: white;
        }

        .steps {
            margin-top: 14px;
        }

        .step {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 10px;
            font-size: 0.82rem;
        }

        .step-num {
            width: 22px; height: 22px;
            background: var(--orange);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem;
            font-weight: 800;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .step-text { color: var(--gray); line-height: 1.5; }

        /* SUBMIT BTN */
        .submit-btn {
            background: linear-gradient(135deg, var(--orange), var(--orange-mid));
            border: none;
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            padding: 16px;
            width: 100%;
            border-radius: 14px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(247,148,29,0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(247,148,29,0.4);
        }

        .submit-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* SUCCESS OVERLAY */
        .success-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .success-overlay.show {
            display: flex;
        }

        .success-card {
            background: white;
            border-radius: 24px;
            padding: 36px 28px;
            text-align: center;
            max-width: 320px;
            width: 90%;
            animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes popIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .success-icon {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, #10b981, #34d399);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            font-size: 2rem;
        }

        .success-title { font-size: 1.2rem; font-weight: 800; margin-bottom: 8px; }
        .success-amount { font-size: 1.8rem; font-weight: 800; color: var(--orange); margin-bottom: 6px; }
        .success-desc { font-size: 0.82rem; color: var(--gray); line-height: 1.6; margin-bottom: 20px; }

        .success-btn {
            background: var(--orange);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 32px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <a href="{{ route('customer.profil') }}#dompet" class="back-btn">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="header-title">Isi Saldo</span>
    </div>

    {{-- SALDO CARD --}}
    <div style="max-width:500px;margin:0 auto;">
        <div class="saldo-card">
            <div class="saldo-chip"></div>
            <div class="saldo-label">Saldo KADI</div>
            <div class="saldo-amount">Rp {{ number_format($user->balance ?? 0, 0, ',', '.') }}</div>
            <div class="saldo-name">{{ $user->name }}</div>
        </div>
    </div>

    <div class="main">

        {{-- NOMINAL --}}
        <div class="nominal-section">
            <div class="section-title">Pilih Nominal</div>
            <div class="nominal-grid">
                <button class="nominal-btn" onclick="selectNominal(10000, this)">Rp 10.000</button>
                <button class="nominal-btn" onclick="selectNominal(20000, this)">Rp 20.000</button>
                <button class="nominal-btn" onclick="selectNominal(25000, this)">Rp 25.000</button>
                <button class="nominal-btn" onclick="selectNominal(50000, this)">Rp 50.000</button>
                <button class="nominal-btn" onclick="selectNominal(100000, this)">Rp 100.000</button>
                <button class="nominal-btn" onclick="selectNominal(200000, this)">Rp 200.000</button>
            </div>
            <div class="custom-input-wrap">
                <span class="prefix">Rp</span>
                <input type="number"
                       class="custom-input"
                       id="customInput"
                       placeholder="Nominal lainnya..."
                       min="10000" max="1000000"
                       oninput="customNominal(this.value)">
            </div>
        </div>

        {{-- METODE --}}
        <div class="metode-section">
            <div class="section-title">Pilih Metode</div>

            <div class="metode-card" id="card-qris" onclick="selectMetode('qris')">
                <div class="metode-logo logo-qris">
                    <span style="font-size:0.7rem;font-weight:900;color:#0066cc;letter-spacing:-1px;">QRIS</span>
                </div>
                <div class="metode-info">
                    <div class="metode-name">QRIS</div>
                    <div class="metode-desc">Scan QR dari semua aplikasi e-wallet</div>
                </div>
                <div class="metode-check" id="check-qris">
                    <i class="bi bi-check" style="font-size:0.8rem;"></i>
                </div>
            </div>

            <div class="metode-card" id="card-dana" onclick="selectMetode('dana')">
                <div class="metode-logo logo-dana">
                    <span style="font-size:1rem;font-weight:900;">D</span>
                </div>
                <div class="metode-info">
                    <div class="metode-name">DANA</div>
                    <div class="metode-desc">Transfer ke nomor DANA admin</div>
                </div>
                <div class="metode-check" id="check-dana">
                    <i class="bi bi-check" style="font-size:0.8rem;"></i>
                </div>
            </div>

            <div class="metode-card" id="card-gopay" onclick="selectMetode('gopay')">
                <div class="metode-logo logo-gopay">
                    <span style="font-size:0.75rem;font-weight:900;">GP</span>
                </div>
                <div class="metode-info">
                    <div class="metode-name">GoPay</div>
                    <div class="metode-desc">Transfer ke nomor GoPay admin</div>
                </div>
                <div class="metode-check" id="check-gopay">
                    <i class="bi bi-check" style="font-size:0.8rem;"></i>
                </div>
            </div>
        </div>

        {{-- INSTRUKSI QRIS --}}
        <div class="instruction-box qris-box" id="instr-qris">
            <div class="section-title" style="text-align:center;margin-bottom:16px;">Scan QR Berikut</div>
            <div class="qris-img">
                <div class="qris-pattern"></div>
                <div class="qris-overlay">
                    <div class="qris-logo-text">KADI</div>
                    <div class="qris-sub">Scan untuk bayar</div>
                </div>
            </div>
            <p style="font-size:0.78rem;color:var(--gray);text-align:center;margin-bottom:16px;">
                QR ini berlaku untuk semua aplikasi yang mendukung QRIS
            </p>
            <div class="steps">
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-text">Buka aplikasi e-wallet kamu (GoPay, Dana, OVO, dll)</div>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-text">Pilih menu "Scan QR" atau "Bayar"</div>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-text">Scan QR di atas dan masukkan nominal sesuai pilihan</div>
                </div>
                <div class="step">
                    <div class="step-num">4</div>
                    <div class="step-text">Saldo akan bertambah setelah Admin KADI mengkonfirmasi</div>
                </div>
            </div>
        </div>

        {{-- INSTRUKSI DANA --}}
        <div class="instruction-box ewallet-box" id="instr-dana">
            <div class="section-title" style="margin-bottom:12px;">Transfer ke DANA Admin</div>
            <div class="ewallet-number">
                <div class="label">Nomor DANA</div>
                <div class="number" id="dana-number">0812-3456-7890</div>
                <div class="name">Admin KADI</div>
            </div>
            <button class="copy-btn" onclick="copyNumber('0812-3456-7890')">
                <i class="bi bi-copy me-2"></i>Salin Nomor
            </button>
            <div class="steps" style="margin-top:16px;">
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-text">Buka aplikasi DANA kamu</div>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-text">Pilih "Kirim" → masukkan nomor di atas</div>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-text">Transfer nominal yang sudah kamu pilih</div>
                </div>
                <div class="step">
                    <div class="step-num">4</div>
                    <div class="step-text">Screenshot bukti transfer dan tunjukkan ke Admin KADI — saldo akan dikonfirmasi</div>
                </div>
            </div>
        </div>

        {{-- INSTRUKSI GOPAY --}}
        <div class="instruction-box ewallet-box" id="instr-gopay">
            <div class="section-title" style="margin-bottom:12px;">Transfer ke GoPay Admin</div>
            <div class="ewallet-number">
                <div class="label">Nomor GoPay</div>
                <div class="number" id="gopay-number">0856-7890-1234</div>
                <div class="name">Admin KADI</div>
            </div>
            <button class="copy-btn" onclick="copyNumber('0856-7890-1234')">
                <i class="bi bi-copy me-2"></i>Salin Nomor
            </button>
            <div class="steps" style="margin-top:16px;">
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-text">Buka aplikasi Gojek / GoPay kamu</div>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-text">Pilih "GoPay" → "Kirim" → masukkan nomor di atas</div>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-text">Transfer nominal yang sudah kamu pilih</div>
                </div>
                <div class="step">
                    <div class="step-num">4</div>
                    <div class="step-text">Screenshot bukti transfer dan tunjukkan ke Admin KADI — saldo akan dikonfirmasi</div>
                </div>
            </div>
        </div>

        {{-- DETAIL --}}
        <div class="detail-box" id="detail-box" style="display:none;">
            <div class="detail-row">
                <span class="detail-label">Nominal Top Up</span>
                <span class="detail-value" id="detail-nominal">-</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Metode</span>
                <span class="detail-value" id="detail-metode">-</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value" style="color:#f7941d;">Menunggu konfirmasi</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Saldo setelah top up</span>
                <span class="detail-value detail-total" id="detail-after">-</span>
            </div>
        </div>

        {{-- SUBMIT --}}
        <button class="submit-btn" id="submitBtn" disabled onclick="submitTopup()">
            <i class="bi"></i>Kirim Permintaan Top Up
        </button>

    </div>

    {{-- SUCCESS OVERLAY --}}
    <div class="success-overlay" id="successOverlay">
        <div class="success-card">
            <div class="success-icon">✅</div>
            <div class="success-title">Permintaan Terkirim!</div>
            <div class="success-amount" id="successAmount">Rp 0</div>
            <div class="success-desc">
                Permintaan top up kamu sudah dikirim ke Admin KADI.<br>
                Saldo akan bertambah setelah admin mengkonfirmasi pembayaran.
            </div>
            <button class="success-btn" onclick="window.location.href='{{ route('customer.profil') }}#dompet'">
                Kembali ke Dompet
            </button>
        </div>
    </div>

    <script>
        let selectedNominal = 0;
        let selectedMetode = '';
        const currentBalance = {{ $user->balance ?? 0 }};

        const metodeNames = {
            qris: 'QRIS',
            dana: 'DANA',
            gopay: 'GoPay'
        };

        function selectNominal(amount, btn) {
            selectedNominal = amount;
            document.getElementById('customInput').value = '';
            document.querySelectorAll('.nominal-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            updateDetail();
            checkReady();
        }

        function customNominal(val) {
            selectedNominal = parseInt(val) || 0;
            document.querySelectorAll('.nominal-btn').forEach(b => b.classList.remove('selected'));
            updateDetail();
            checkReady();
        }

        function selectMetode(metode) {
            selectedMetode = metode;

            // Reset semua card
            ['qris', 'dana', 'gopay'].forEach(m => {
                document.getElementById('card-' + m).classList.remove('selected');
                document.getElementById('check-' + m).style.background = '';
                document.getElementById('check-' + m).style.borderColor = '';
                document.getElementById('instr-' + m).classList.remove('show');
            });

            // Aktifkan yang dipilih
            document.getElementById('card-' + metode).classList.add('selected');
            document.getElementById('instr-' + metode).classList.add('show');

            updateDetail();
            checkReady();
        }

        function updateDetail() {
            if (selectedNominal > 0 && selectedMetode) {
                document.getElementById('detail-box').style.display = 'block';
                document.getElementById('detail-nominal').textContent = 'Rp ' + selectedNominal.toLocaleString('id-ID');
                document.getElementById('detail-metode').textContent = metodeNames[selectedMetode] || '-';
                document.getElementById('detail-after').textContent = 'Rp ' + (currentBalance + selectedNominal).toLocaleString('id-ID');
            }
        }

        function checkReady() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = !(selectedNominal >= 10000 && selectedMetode);
        }

        function copyNumber(number) {
            navigator.clipboard.writeText(number.replace(/-/g, '')).then(() => {
                alert('Nomor berhasil disalin!');
            });
        }

        function submitTopup() {
    if (!selectedNominal || !selectedMetode) return;

    fetch('{{ route("customer.topup.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            amount: selectedNominal,
            metode: selectedMetode
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('successAmount').textContent =
                'Rp ' + selectedNominal.toLocaleString('id-ID');
            document.getElementById('successOverlay').classList.add('show');
        }
    })
    .catch(err => console.error(err));
}
    </script>
</body>
</html>
