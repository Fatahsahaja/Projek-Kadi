<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin KADI Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .shops-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .shop-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .shop-card h3 {
            color: #f7931e;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        th {
            background: #f7931e;
            color: white;
            padding: 15px;
            text-align: left;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-success {
            background: #4caf50;
            color: white;
        }
        .badge-warning {
            background: #ff9800;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏢 Dashboard Admin KADI</h1>
  <div class="d-flex align-items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        <h2>📊 Semua Toko</h2>
        <div class="shops-grid">
            @foreach($shops as $shop)
                <div class="shop-card">
                    <h3>{{ $shop->name }}</h3>
                    <p><strong>Total Transaksi:</strong> {{ $shop->transactions_count ?? 0 }}</p>
                    <p><strong>Total Pendapatan:</strong> Rp {{ number_format($shop->transactions_sum_total ?? 0, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>

        <h2>📝 Semua Transaksi</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Toko</th>
                    <th>Kasir</th>
                    <th>No Telepon</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr>
                    <td>#{{ $tx->id }}</td>
                    <td>{{ $tx->shop->name }}</td>
                    <td>{{ $tx->cashier_name }}</td>
                    <td>{{ $tx->phone }}</td>
                    <td><strong>Rp {{ number_format($tx->total, 0, ',', '.') }}</strong></td>
                           <td>
                    @if($tx->status === 'pending')
                        <form action="{{ route('transactions.updateStatus', $transaction->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin selesai?')">
                                ✓ Selesai
                            </button>
                        </form>

                        <form action="{{ route('transactions.updateStatus', $transaction->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin batalkan?')">
                                ✗ Batalkan
                            </button>
                        </form>
                    @else
                        <span class="badge badge-{{ $tx->status === 'completed' ? 'success' : 'secondary' }}">
                            {{ ucfirst($tx->status) }}
                        </span>
                    @endif
                </td>
                    <td>{{ $tx->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #999;">
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $transactions->links() }}
        </div>
    </div>
</body>
</html>
