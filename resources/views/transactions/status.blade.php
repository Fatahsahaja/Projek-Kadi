<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan - KADI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #fff5eb; min-height: 100vh; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card shadow-sm border-0 rounded-4 text-center">

                <div class="card-body p-5">
                    {{-- Status Icon --}}
                    <div id="status-icon" class="mb-4">
                        @if($transaction->status === 'SUKSES')
                            <div class="display-1">✅</div>
                        @else
                            <div class="spinner-border text-warning" style="width:4rem;height:4rem;" role="status"></div>
                        @endif
                    </div>

                    {{-- Status Text --}}
                    <h2 class="fw-bold mb-2" id="status-text">
                        @if($transaction->status === 'SUKSES')
                            Pesanan Selesai!
                        @else
                            Pesanan Sedang Diproses...
                        @endif
                    </h2>

                    <p class="text-muted mb-4" id="status-desc">
                        @if($transaction->status === 'SUKSES')
                            Pesananmu sudah siap, silakan ambil! 🎉
                        @else
                            Tunggu sebentar ya, admin kantin sedang memproses pesananmu
                        @endif
                    </p>

                    {{-- Status Badge --}}
                    <div class="mb-4">
                        <span id="status-badge" class="badge fs-6 px-4 py-2
                            {{ $transaction->status === 'SUKSES' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $transaction->status }}
                        </span>
                    </div>

                    {{-- Detail Pesanan --}}
                    <div class="bg-light rounded-3 p-3 text-start mb-4">
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
                    </div>

                    {{-- Item Pesanan --}}
                    <div class="bg-light rounded-3 p-3 text-start mb-4">
                        <h6 class="fw-bold mb-3">🛒 Item Pesanan</h6>
                        @php
                            $items = is_array($transaction->items)
                                ? $transaction->items
                                : json_decode($transaction->items, true);
                        @endphp
                        @foreach($items as $item)
                        <div class="d-flex justify-content-between mb-1">
                            <span>{{ $item['name'] }} <small class="text-muted">x{{ $item['quantity'] ?? 1 }}</small></span>
                            <span>Rp {{ number_format($item['subtotal'] ?? $item['price'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-3 w-100">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Polling status setiap 5 detik
    @if($transaction->status === 'PENDING')
    const checkUrl = "{{ route('order.checkStatus', $transaction->id) }}";

    function checkStatus() {
        fetch(checkUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'SUKSES') {
                // Update icon
                document.getElementById('status-icon').innerHTML = '<div class="display-1">✅</div>';

                // Update text
                document.getElementById('status-text').textContent = 'Pesanan Selesai!';
                document.getElementById('status-desc').textContent = 'Pesananmu sudah siap, silakan ambil! 🎉';

                // Update badge
                const badge = document.getElementById('status-badge');
                badge.textContent = 'SUKSES';
                badge.className = 'badge fs-6 px-4 py-2 bg-success';

                clearInterval(pollingInterval);
            }
        })
        .catch(err => console.log('Error:', err));
    }

    const pollingInterval = setInterval(checkStatus, 5000);
    checkStatus();
    @endif
</script>
</body>
</html>
