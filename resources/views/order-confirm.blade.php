<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - KADI</title>
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
            <div class="col-lg-6 col-md-8">

                <!-- Back Button -->
                <a href="{{ url()->previous() }}" class="btn btn-link text-dark mb-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-warning text-white text-center py-4 rounded-top-4">
                        <h3 class="mb-0 fw-bold"><i class="bi bi-receipt-cutoff"></i> Konfirmasi Pesanan</h3>
                    </div>

                    <div class="card-body p-4">

                        <!-- Info Warung -->
                        <div class="alert alert-light border-0 mb-4">
                            <h5 class="mb-0">
                                <i class="bi bi-shop text-warning"></i>
                                <strong>{{ $shop->name }}</strong>
                            </h5>
                        </div>

                        <!-- Detail Pesanan -->
                        <h6 class="text-secondary mb-3 fw-bold">📋 Detail Pesanan:</h6>
                        <div class="mb-4">
                            @if (isset($cart) && count($cart) > 0)
                                @foreach ($cart as $item)
                                    <div
                                        class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                        <div>
                                            <span class="fw-semibold">{{ $item['name'] }}</span>
                                            <span
                                                class="badge bg-warning text-dark ms-2">x{{ $item['quantity'] ?? 1 }}</span>
                                        </div>
                                        <span class="text-warning fw-bold">Rp
                                            {{ number_format($item['subtotal'] ?? $item['price'], 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <span class="fw-semibold">-</span>
                                    <span class="text-warning fw-bold">Rp
                                        {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>

                        <hr class="my-4">

                        <!-- Total Bayar -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Total Bayar:</h4>
                            <h3 class="mb-0 text-warning fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                        </div>

                        <!-- Form Submit Order -->
                        <form action="{{ route('order.store') }}" method="POST" id="order-form">
                            @csrf
                            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                            <input type="hidden" name="items" value="{{ json_encode($cart) }}">
                            <input type="hidden" name="total" value="{{ $total }}">

                            <!-- Catatan Opsional -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-chat-left-text text-warning"></i> Catatan untuk kantin (opsional)
                                </label>
                                <textarea name="notes" class="form-control border-2" rows="3"
                                    placeholder="Contoh: Pedes dikit ya, ga pake cabe..."></textarea>
                            </div>

                            {{-- Pilihan Metode Bayar --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-wallet2 text-warning"></i> Metode Pembayaran
                                </label>

                                {{-- Saldo --}}
                                <div class="form-check border rounded-3 p-3 mb-2"
                                     id="opt-saldo"
                                     style="cursor:pointer; border-color:#dee2e6 !important;"
                                     onclick="selectMetode('saldo')">
                                    <input class="form-check-input" type="radio"
                                           name="payment_method" value="saldo"
                                           id="pay-saldo" required>
                                    <label class="form-check-label w-100" for="pay-saldo" style="cursor:pointer;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="fw-bold">💰 Bayar Pakai Saldo</span><br>
                                                <small class="text-muted">
                                                    Saldo kamu:
                                                    <span class="fw-bold text-success">
                                                        Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}
                                                    </span>
                                                </small>
                                            </div>
                                            @if(auth()->user()->balance >= $total)
                                                <span class="badge bg-success">Cukup ✓</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Cukup</span>
                                            @endif
                                        </div>
                                    </label>
                                </div>

                                {{-- QR / Tunai --}}
                                <div class="form-check border rounded-3 p-3"
                                     id="opt-qr"
                                     style="cursor:pointer; border-color:#dee2e6 !important;"
                                     onclick="selectMetode('qr')">
                                    <input class="form-check-input" type="radio"
                                           name="payment_method" value="qr"
                                           id="pay-qr">
                                    <label class="form-check-label w-100" for="pay-qr" style="cursor:pointer;">
                                        <span class="fw-bold">💵 Bayar Cash (di Kasir)</span><br>
                                        <small class="text-muted">Bayar langsung ke admin kantin saat ambil pesanan</small>
                                    </label>
                                </div>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger mb-3">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger mb-3">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Tombol Bayar -->
                            <button type="submit"
                                class="btn btn-warning w-100 py-3 fw-bold text-white rounded-3 shadow-sm">
                                <i class="bi bi-credit-card"></i> Konfirmasi & Bayar Sekarang
                            </button>
                        </form>

                    </div>
                </div>

                <!-- Info Tambahan -->
                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i>
                        Pesanan akan diproses setelah pembayaran dikonfirmasi
                    </small>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function selectMetode(metode) {
    document.getElementById('pay-saldo').checked = metode === 'saldo';
    document.getElementById('pay-qr').checked    = metode === 'qr';

    // Highlight border yang dipilih
    document.getElementById('opt-saldo').style.borderColor = metode === 'saldo' ? '#f7941d' : '#dee2e6';
    document.getElementById('opt-qr').style.borderColor    = metode === 'qr'    ? '#f7941d' : '#dee2e6';
}

// Validasi: pastikan metode sudah dipilih sebelum submit
document.getElementById('order-form').addEventListener('submit', function(e) {
    const selected = document.querySelector('input[name="payment_method"]:checked');
    if (!selected) {
        e.preventDefault();
        alert('Pilih metode pembayaran terlebih dahulu!');
    }
});
</script>
</body>


</html>
