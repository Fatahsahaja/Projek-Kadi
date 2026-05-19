<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi #{{ $transaction->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff5eb;
            min-height: 100vh;
        }

        @media print {

            /* Sembunyiin semua kecuali struk */
            body * {
                visibility: hidden;
            }

            #struk,
            #struk * {
                visibility: visible;
            }

            #struk {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* Sembunyiin tombol pas print */
            .btn,
            a {
                display: none !important;
            }

            /* Reset background */
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

                <a href="{{ auth()->user()->role === 'customer' ? route('customer.profil') : route('dashboard') }}" class="text-muted text-decoration-none small d-block mb-3">
                    ← Kembali
                </a>
                <div id="struk">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div
                            class="card-header text-white text-center py-4 rounded-top-4
                   {{ $transaction->status === 'SUKSES'
                       ? 'bg-success'
                       : ($transaction->status === 'PENDING'
                           ? 'bg-warning text-dark'
                           : ($transaction->status === 'SELESAI'
                               ? 'bg-primary'
                               : ($transaction->status === 'DIBATALKAN'
                                   ? 'bg-danger'
                                   : 'bg-secondary'))) }}">
                            <h4 class="mb-0 fw-bold">
                                @if ($transaction->status === 'SUKSES')
                                    ✅
                                @elseif($transaction->status === 'PENDING')
                                    ⏳
                                @elseif($transaction->status === 'SELESAI')
                                    📦
                                @elseif($transaction->status === 'DIBATALKAN')
                                    ❌
                                @else
                                    📋
                                @endif
                                Detail Transaksi
                            </h4>
                            <small>{{ $transaction->status }}</small>
                        </div>



                        <div class="card-body p-4">
                            {{-- STRUK SECTION - hanya muncul saat print --}}
                            <div class="text-center mb-3 d-none d-print-block">
                                <h5 class="fw-bold"> KADI — Kantin Digital</h5>
                                <small class="text-muted">================================</small>
                                <div class="text-start mt-2" style="font-family: monospace; font-size: 0.85rem;">
                                    <div>No. Pesanan : #{{ $transaction->id }}</div>
                                    <div>Nama : {{ $transaction->cashier_name ?? auth()->user()->name }}</div>
                                    <div>Warung : {{ $transaction->shop->name }}</div>
                                    <div>Tanggal : {{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                                    <div>Status : {{ $transaction->status }}</div>
                                    <div>Pembayaran : {{ $transaction->payment_method === 'saldo' ? 'Saldo KADI' : 'Cash (Kasir)' }}</div>
                                    <hr>
                                    @php
                                        $items = is_array($transaction->items)
                                            ? $transaction->items
                                            : json_decode($transaction->items, true);
                                    @endphp
                                    @foreach ($items as $item)
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $item['name'] }} x{{ $item['quantity'] ?? 1 }}</span>
                                            <span>Rp
                                                {{ number_format($item['subtotal'] ?? $item['price'], 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>TOTAL</span>
                                        <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                                    </div>
                                    <hr>
                                    <div class="text-center mt-2">Terima kasih! 😊</div>
                                    <div class="text-center"><small>Powered by KADI</small></div>
                                </div>
                            </div>


                            {{-- Detail --}}
                            <div class="bg-light rounded-3 p-3 mb-3">
                                <h6 class="fw-bold mb-3">📋 Informasi Pesanan</h6>
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
                                    <span class="text-muted">Tanggal</span>
                                    <span class="fw-medium">{{ $transaction->created_at->format('d M Y H:i') }}</span>
                                </div>
                                @if ($transaction->confirmed_at)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Dikonfirmasi</span>
                                        <span
                                            class="fw-medium text-success">{{ $transaction->confirmed_at->format('d M Y H:i') }}</span>
                                    </div>
                                @endif
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

                            {{-- Items --}}
                            <div class="bg-light rounded-3 p-3 mb-4">
                                <h6 class="fw-bold mb-3">🛒 Item Pesanan</h6>
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

                            {{-- Aksi admin --}}
                            @if (auth()->user()->role !== 'customer' && $transaction->status === 'SUKSES')
                                <form action="{{ route('transactions.update-status', $transaction->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="SELESAI">
                                    <button type="submit" class="btn btn-outline-primary w-100 rounded-3">
                                     Tandai Selesai
                                    </button>
                                </form>
                            @endif
                            @if ($transaction->status === 'SUKSES' || $transaction->status === 'SELESAI')

                            @endif
                            
                            <button onclick="window.print()" class="btn btn-outline-warning rounded-3 py-2 fw-bold w-100">
                                 Lihat Struk
                            </button>
                            <a href="{{ auth()->user()->role === 'customer' ? route('customer.profil') : route('dashboard') }}" class="btn btn-outline-secondary w-100 mt-2 rounded-3">
                                Kembali
                            </a>
                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
