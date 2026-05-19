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

        @media print {
            body * {
                visibility: hidden;
            }

            .card,
            .card * {
                visibility: visible;
            }

            .card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none !important;
            }

            .btn,
            a,
            #confirmed-alert {
                display: none !important;
            }

            body {
                background: white !important;
            }
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">

                <div class="card shadow-sm border-0 rounded-4 text-center">
                    @if($transaction->payment_method === 'saldo')
                    {{-- ===== BAYAR SALDO: langsung SUKSES ===== --}}
                    <div class="card-header bg-success text-white py-4 rounded-top-4">
                        <h3 class="mb-0 fw-bold">🎉 Pembayaran Berhasil!</h3>
                        <p class="mb-0 mt-1 opacity-75">Saldo kamu telah dipotong · Pesanan sedang diproses</p>
                    </div>

                    <div class="card-body p-4">

                        {{-- Badge sukses --}}
                        <div class="mb-4">
                            <span class="display-1">✅</span>
                            <p class="mt-2 text-success fw-bold fs-5">Pembayaran via Saldo Diterima!</p>
                            <p class="text-muted small">Tunjukkan halaman ini atau No. Pesanan ke admin kantin.</p>
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
                                <span class="text-muted">Total Dibayar</span>
                                <span class="fw-bold text-success">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Metode</span>
                                <span class="badge bg-success"> Saldo</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Status</span>
                                <span class="badge bg-success"> SUKSES</span>
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
                            <button onclick="window.print()" class="btn btn-outline-success rounded-3 py-2 fw-bold">
                                 Lihat Struk
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-3 py-2 fw-bold">
                                Kembali ke Dashboard
                            </a>
                            <a href="{{ route('customer.menu') }}" class="btn btn-outline-secondary rounded-3 py-2">
                                Pesan Lagi
                            </a>
                        </div>

                    </div>

                    @else
                    {{-- ===== BAYAR CASH: tampil QR + polling ===== --}}
                    <div class="card-header bg-success text-white py-4 rounded-top-4">
                        <h3 class="mb-0 fw-bold">🎉 Pesanan Berhasil!</h3>
                        <p class="mb-0 mt-1 opacity-75">Tunjukkan QR Code ini ke Admin Kantin untuk konfirmasi</p>
                    </div>

                    <div class="card-body p-4">

                        {{-- QR Code --}}
                        <div class="bg-light rounded-3 p-3 mb-4 d-inline-block">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($qrUrl) }}"
                                alt="QR Code Pesanan" class="rounded" />
                        </div>
                        <div class="mt-2 mb-2">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i>
                                Tunjukkan QR ini ke admin kantin untuk konfirmasi pesanan
                            </small>
                        </div>

                        {{-- Detail Pesanan --}}
                        <div class="bg-light rounded-3 p-3 mb-3 text-start">
                            <h6 class="fw-bold mb-3">📋 Detail Pesanan</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">No. Pesanan</span>
                                <span class="fw-medium">#{{ $transaction->id }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Warung</span>
                                <span class="fw-medium">{{ $transaction->shop->name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total</span>
                                <span class="fw-bold text-success">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Metode</span>
                                <span class="badge bg-secondary">Cash</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span id="status-badge">
                                    <span class="badge bg-warning text-dark">{{ $transaction->status }}</span>
                                </span>
                            </div>
                        </div>

                        {{-- Alert konfirmasi admin --}}
                        <div id="confirmed-alert" class="alert alert-success d-none mt-3 fw-bold text-center">
                            🎉 Pesanan kamu sudah dikonfirmasi oleh Admin Kantin!
                            <br><small>Silakan ambil pesananmu di warung.</small>
                        </div>

                        {{-- Items --}}
                        <div class="bg-light rounded-3 p-3 mb-3 text-start">
                            <h6 class="fw-bold mb-3"> Item Pesanan</h6>
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

                        <div class="d-grid gap-2">
                            <button onclick="window.print()" class="btn btn-outline-success rounded-3 py-2">
                                 Lihat Struk
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-3 py-2 fw-bold">
                                Kembali ke Dashboard
                            </a>
                            <a href="{{ route('customer.menu') }}" class="btn btn-outline-secondary rounded-3 py-2">
                                Pesan Lagi
                            </a>
                        </div>

                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @if($transaction->payment_method === 'qr')
    <script>
        const checkUrl = "{{ route('order.checkStatus', $transaction->id) }}";
        let isConfirmed = false;

        function checkOrderStatus() {
            if (isConfirmed) return;

            fetch(checkUrl, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'SUKSES') {
                        isConfirmed = true;
                        document.getElementById('status-badge').innerHTML =
                            '<span class="badge bg-success"> DIKONFIRMASI</span>';
                        const alertBox = document.getElementById('confirmed-alert');
                        alertBox.classList.remove('d-none');
                        alertBox.scrollIntoView({ behavior: 'smooth' });
                        clearInterval(pollingInterval);
                    }
                })
                .catch(err => console.log('Polling error:', err));
        }

        const pollingInterval = setInterval(checkOrderStatus, 5000);
        checkOrderStatus();
    </script>
    @endif
</body>

</html>
