<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - KADI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fff5eb 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .status-pill {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .status-pending  { background:#fff7ed; color:#f7941d; }
        .status-siap     { background:#ecfdf5; color:#10b981; }
        .status-selesai  { background:#eff6ff; color:#3b82f6; }

        @media print {
            body * { visibility: hidden; }
            .card, .card * { visibility: visible; }
            .card { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none !important; }
            .btn, a, #confirmed-alert { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow-sm border-0 rounded-4 text-center">

                    {{-- Header: sama untuk semua metode bayar --}}
                    <div class="card-header bg-warning text-white py-4 rounded-top-4">
                        <h3 class="mb-0 fw-bold">🎉 Pesanan Diterima!</h3>
                        <p class="mb-0 mt-1 opacity-75">
                            @if($transaction->payment_method === 'saldo')
                                Tunjukkan QR ini ke admin kantin · Saldo dipotong saat pesanan selesai
                            @else
                                Tunjukkan QR Code ini ke Admin Kantin untuk konfirmasi
                            @endif
                        </p>
                    </div>

                    <div class="card-body p-4">

                        {{-- QR Code (untuk semua metode) --}}
                        <div class="bg-light rounded-3 p-3 mb-3 d-inline-block">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($qrUrl) }}"
                                alt="QR Code Pesanan" class="rounded" />
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i>
                                Tunjukkan QR ini ke admin kantin untuk konfirmasi pesanan
                            </small>
                        </div>

                        {{-- Info saldo belum dipotong --}}
                        @if($transaction->payment_method === 'saldo')
                        <div class="alert alert-warning py-2 mb-3" style="font-size:0.82rem;">
                            💰 <strong>Saldo belum dipotong.</strong> Saldo akan dipotong otomatis setelah admin kantin menyelesaikan pesananmu.
                        </div>
                        @endif

                        {{-- Status badge realtime --}}
                        <div class="mb-3">
                            <span id="status-badge">
                                <span class="status-pill status-pending">⏳ PENDING</span>
                            </span>
                        </div>

                        {{-- Alert saat SIAP --}}
                        <div id="alert-siap" class="alert alert-success d-none mb-3 fw-bold text-center">
                            🍱 Pesananmu sedang disiapkan! Segera ke warung untuk mengambil.
                        </div>

                        {{-- Alert saat SELESAI --}}
                        <div id="alert-selesai" class="alert alert-primary d-none mb-3 fw-bold text-center">
                            ✅ Pesanan selesai! Saldo sudah terpotong.
                        </div>

                        {{-- Detail Pesanan --}}
                        <div class="bg-light rounded-3 p-3 mb-3 text-start">
                            <h6 class="fw-bold mb-3">📋 Detail Pesanan</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">No. Pesanan</span>
                                <span class="fw-bold text-primary">#{{ $transaction->id }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Warung</span>
                                <span class="fw-medium">{{ $transaction->shop->name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total</span>
                                <span class="fw-bold text-success">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Metode</span>
                                <span>{{ $transaction->payment_method === 'saldo' ? '💰 Saldo' : '💵 Cash' }}</span>
                            </div>
                        </div>

                        {{-- Items --}}
                        <div class="bg-light rounded-3 p-3 mb-3 text-start">
                            <h6 class="fw-bold mb-3">🛒 Item Pesanan</h6>
                            @php
                                $items = is_array($transaction->items)
                                    ? $transaction->items
                                    : json_decode($transaction->items, true);
                            @endphp
                            @foreach ($items as $item)
                                <div class="d-flex justify-content-between mb-1">
                                    <span>{{ $item['name'] }} <small class="text-muted">x{{ $item['quantity'] ?? 1 }}</small></span>
                                    <span class="fw-medium">Rp {{ number_format($item['subtotal'] ?? $item['price'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Catatan --}}
                        @if ($transaction->notes)
                            <div class="alert alert-warning text-start py-2 mb-3">
                                📝 {{ $transaction->notes }}
                            </div>
                        @endif

                        {{-- Tombol --}}
                        <div class="d-grid gap-2">
                            <button onclick="window.print()" class="btn btn-outline-warning rounded-3 py-2 fw-bold">
                                Lihat Struk
                            </button>
                            <a href="{{ route('customer.profil') }}" class="btn btn-outline-secondary rounded-3 py-2">
                                 Lihat Riwayat Pesanan
                            </a>
                            <a href="{{ route('customer.menu') }}" class="btn btn-outline-secondary rounded-3 py-2">
                                Pesan Lagi
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const checkUrl = "{{ route('order.checkStatus', $transaction->id) }}";
        let lastStatus = 'PENDING';

        function checkOrderStatus() {
            fetch(checkUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(data => {
                    if (data.status === lastStatus) return;
                    lastStatus = data.status;

                    const badge = document.getElementById('status-badge');

                    if (data.status === 'SIAP') {
                        badge.innerHTML = '<span class="status-pill status-siap">🍱 SIAP DIAMBIL</span>';
                        document.getElementById('alert-siap').classList.remove('d-none');
                        document.getElementById('alert-siap').scrollIntoView({ behavior: 'smooth' });
                    }

                    if (data.status === 'SELESAI') {
                        badge.innerHTML = '<span class="status-pill status-selesai">✅ SELESAI</span>';
                        document.getElementById('alert-siap').classList.add('d-none');
                        document.getElementById('alert-selesai').classList.remove('d-none');
                        clearInterval(pollingInterval);
                    }

                    if (data.status === 'DIBATALKAN') {
                        badge.innerHTML = '<span class="status-pill" style="background:#fef2f2;color:#ef4444;">❌ DIBATALKAN</span>';
                        clearInterval(pollingInterval);
                    }
                })
                .catch(err => console.log('Polling error:', err));
        }

        const pollingInterval = setInterval(checkOrderStatus, 4000);
        checkOrderStatus();
    </script>
</body>

</html>
