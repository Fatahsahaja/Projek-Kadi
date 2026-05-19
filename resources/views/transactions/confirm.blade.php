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

        .step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .step-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .step-dot.done   { background: #d1fae5; color: #10b981; }
        .step-dot.active { background: #f7941d; color: white; }
        .step-dot.next   { background: #f3f4f6; color: #9ca3af; }

        .step-line {
            height: 2px;
            width: 40px;
            background: #e5e7eb;
        }

        .step-line.done { background: #10b981; }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow-sm border-0 rounded-4">

                    {{-- Header warna beda sesuai status --}}
                    @if($transaction->status === 'PENDING')
                    <div class="card-header bg-warning text-white text-center py-4 rounded-top-4">
                        <h4 class="mb-0 fw-bold"> Konfirmasi Pesanan</h4>
                        <small>Crosscheck pesanan sebelum disiapkan</small>
                    </div>
                    @elseif($transaction->status === 'SIAP')
                    <div class="card-header text-white text-center py-4 rounded-top-4" style="background:#10b981;">
                        <h4 class="mb-0 fw-bold"> Pesanan Siap Diambil</h4>
                        <small>Konfirmasi setelah siswa mengambil pesanan</small>
                    </div>
                    @endif

                    <div class="card-body p-4">

                        {{-- Step Indicator --}}
                        <div class="step-indicator">
                            {{-- Step 1: Terima Pesanan --}}
                            <div class="text-center">
                                <div class="step-dot {{ in_array($transaction->status, ['SIAP','SELESAI']) ? 'done' : 'active' }}">
                                    {{ in_array($transaction->status, ['SIAP','SELESAI']) ? '✓' : '1' }}
                                </div>
                                <div style="font-size:0.65rem;color:#6b7280;margin-top:4px;">Terima</div>
                            </div>

                            <div class="step-line {{ $transaction->status === 'SIAP' ? 'done' : '' }}"></div>

                            {{-- Step 2: Siap --}}
                            <div class="text-center">
                                <div class="step-dot {{ $transaction->status === 'SIAP' ? 'active' : ($transaction->status === 'SELESAI' ? 'done' : 'next') }}">
                                    {{ $transaction->status === 'SELESAI' ? '✓' : '2' }}
                                </div>
                                <div style="font-size:0.65rem;color:#6b7280;margin-top:4px;">Siap</div>
                            </div>

                            <div class="step-line"></div>

                            {{-- Step 3: Selesai --}}
                            <div class="text-center">
                                <div class="step-dot next">3</div>
                                <div style="font-size:0.65rem;color:#6b7280;margin-top:4px;">Selesai</div>
                            </div>
                        </div>

                        {{-- Info status SIAP --}}
                        @if($transaction->status === 'SIAP')
                        <div class="alert alert-success py-2 mb-3" style="font-size:0.85rem;">
                             Pesanan ini <strong>sudah disiapkan</strong>. Klik tombol di bawah setelah siswa mengambil pesanan dan saldo akan terpotong.
                        </div>
                        @endif

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
                                <span class="text-muted">Metode Bayar</span>
                                <span class="fw-medium">
                                    {{ $transaction->payment_method === 'saldo' ? '💰 Saldo' : '💵 Cash' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total</span>
                                <span class="fw-bold text-success fs-5">
                                    Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                </span>
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
                                        <span class="badge bg-warning text-dark ms-1">x{{ $item['quantity'] ?? 1 }}</span>
                                    </span>
                                    <span>Rp {{ number_format($item['subtotal'] ?? $item['price'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between fw-bold mt-2">
                                <span>Total</span>
                                <span class="text-success">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- Tombol aksi sesuai status --}}
                        <form action="{{ route('transactions.processConfirm', $transaction->id) }}" method="POST">
                            @csrf
                            @if($transaction->status === 'PENDING')
                            <button type="submit" class="btn btn-warning w-100 py-3 fw-bold rounded-3 fs-5 text-white">
                                 Siapkan Pesanan
                            </button>
                            <p class="text-muted text-center mt-2" style="font-size:0.78rem;">
                                Stok akan berkurang. Saldo dipotong setelah siswa ambil.
                            </p>
                            @elseif($transaction->status === 'SIAP')
                            <button type="submit" class="btn btn-success w-100 py-3 fw-bold rounded-3 fs-5">
                                 Siswa Sudah Ambil — Selesaikan
                            </button>
                            @if($transaction->payment_method === 'saldo')
                            <p class="text-muted text-center mt-2" style="font-size:0.78rem;">
                                Saldo Rp {{ number_format($transaction->total, 0, ',', '.') }} akan dipotong dari akun siswa.
                            </p>
                            @endif
                            @endif
                        </form>

                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100 mt-2 rounded-3">
                            Kembali ke Dashboard
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('swal'))
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
