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
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">

                <div class="card shadow-sm border-0 rounded-4 text-center">
                    <div class="card-header bg-success text-white py-4 rounded-top-4">
                        <h3 class="mb-0 fw-bold">🎉 Pesanan Berhasil!</h3>
                        <p class="mb-0 mt-1 opacity-75">Tunjukkan QR Code ini ke Admin Kantin</p>
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
                                <span class="fw-bold text-success">Rp
                                    {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span id="status-badge">
                                    <span class="badge bg-warning text-dark">{{ $transaction->status }}</span>
                                </span>
                            </div>
                        </div>

                        {{-- Tambah ini SETELAH div detail pesanan --}}
                        <div id="confirmed-alert" class="alert alert-success d-none mt-3 fw-bold text-center">
                            🎉 Pesanan kamu sudah dikonfirmasi oleh Admin Kantin!
                            <br><small>Silakan ambil pesananmu di warung.</small>
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
                                    <span>{{ $item['name'] }} <small
                                            class="text-muted">x{{ $item['quantity'] ?? 1 }}</small></span>
                                    <span class="fw-medium">Rp
                                        {{ number_format($item['subtotal'] ?? $item['price'], 0, ',', '.') }}</span>
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
                            <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-3 py-2 fw-bold">
                                Kembali ke Dashboard
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
        const transactionId = {{ $transaction->id }};
        const checkUrl = "{{ route('order.checkStatus', $transaction->id) }}";
        let isConfirmed = false;

        function checkOrderStatus() {
            if (isConfirmed) return;

            fetch(checkUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'SUKSES') {
                        isConfirmed = true;

                        // Update badge status di halaman
                        document.getElementById('status-badge').innerHTML =
                            '<span class="badge bg-success">✅ DIKONFIRMASI</span>';

                        // Tampilkan alert sukses
                        const alertBox = document.getElementById('confirmed-alert');
                        alertBox.classList.remove('d-none');
                        alertBox.scrollIntoView({
                            behavior: 'smooth'
                        });

                        // Stop polling
                        clearInterval(pollingInterval);
                    }
                })
                .catch(err => console.log('Polling error:', err));
        }

        // Jalankan polling setiap 5 detik
        const pollingInterval = setInterval(checkOrderStatus, 5000);

        // Jalankan sekali langsung saat load
        checkOrderStatus();
    </script>
</body>

</html>
