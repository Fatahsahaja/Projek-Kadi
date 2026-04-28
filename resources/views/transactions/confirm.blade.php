<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - KADI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff5eb;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-warning text-white text-center py-4 rounded-top-4">
                        <h4 class="mb-0 fw-bold">🔍 Konfirmasi Pesanan</h4>
                        <small>Crosscheck pesanan sebelum konfirmasi</small>
                    </div>

                    <div class="card-body p-4">

                        {{-- Detail Pesanan --}}
                        <div class="bg-light rounded-3 p-3 mb-3">
                            <h6 class="fw-bold mb-3">📋 Detail Pesanan</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">No. Pesanan</span>
                                <span class="fw-bold">#{{ $transaction->id }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Nama Siswa</span>
                                <span class="fw-medium">{{ $transaction->cashier_name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Warung</span>
                                <span class="fw-medium">{{ $transaction->shop->name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total</span>
                                <span class="fw-bold text-success fs-5">Rp
                                    {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </div>
                            @if ($transaction->notes)
                                <div class="alert alert-warning py-2 mb-0 mt-2">
                                    📝 {{ $transaction->notes }}
                                </div>
                            @endif
                        </div>

                        {{-- Item Pesanan --}}
                        <div class="bg-light rounded-3 p-3 mb-4">
                            <h6 class="fw-bold mb-3">🛒 Item yang Dipesan</h6>
                            @php
                                $items = is_array($transaction->items)
                                    ? $transaction->items
                                    : json_decode($transaction->items, true);
                            @endphp
                            @foreach ($items as $item)
                                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                    <span class="fw-medium">
                                        {{ $item['name'] }}
                                        <span
                                            class="badge bg-warning text-dark ms-1">x{{ $item['quantity'] ?? 1 }}</span>
                                    </span>
                                    <span>Rp
                                        {{ number_format($item['subtotal'] ?? $item['price'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between fw-bold mt-2">
                                <span>Total</span>
                                <span class="text-success">Rp
                                    {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- Tombol Konfirmasi --}}
                        <form action="{{ route('transactions.processConfirm', $transaction->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 py-3 fw-bold rounded-3 fs-5">
                                ✅ Konfirmasi Pesanan Selesai
                            </button>
                        </form>

                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100 mt-2 rounded-3">
                            Batal
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert setelah konfirmasi --}}
    @if (session('swal'))
        <script>
            Swal.fire({
                icon: "{{ session('swal.type') }}",
                title: "{{ session('swal.title') }}",
                text: "{{ session('swal.text') }}",
                confirmButtonColor: "#3085d6",
            });
        </script>
    @endif
</body>

</html>
