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
                        @if(isset($cart) && count($cart) > 0)
                            @foreach($cart as $item)
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <div>
                                        <span class="fw-semibold">{{ $item['name'] }}</span>
                                    </div>
                                    <span class="text-warning fw-bold">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <span class="fw-semibold">{{ $nama_makanan }}</span>
                                <span class="text-warning fw-bold">Rp {{ number_format($harga, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>

                    <hr class="my-4">

                    <!-- Total Bayar -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Total Bayar:</h4>
                        <h3 class="mb-0 text-warning fw-bold">Rp {{ number_format($harga, 0, ',', '.') }}</h3>
                    </div>

                    <!-- Form Submit Order -->
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <input type="hidden" name="items" value="{{ $nama_makanan }}">
                        <input type="hidden" name="total" value="{{ $harga }}">

                        <!-- Catatan Opsional -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-chat-left-text text-warning"></i> Catatan untuk kantin (opsional)
                            </label>
                            <textarea name="notes" class="form-control border-2" rows="3"
                                placeholder="Contoh: Pedes dikit ya, ga pake cabe..."></textarea>
                        </div>

                        <!-- Tombol Bayar -->
                        <button type="submit" class="btn btn-warning w-100 py-3 fw-bold text-white rounded-3 shadow-sm">
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
</body>
</html>
