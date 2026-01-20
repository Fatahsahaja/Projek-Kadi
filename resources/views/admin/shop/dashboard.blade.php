<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard {{ $shop->name }}</title>
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
            margin-bottom: 20px;
        }
        .balance-card {
            background: linear-gradient(135deg, #f7931e 0%, #ffad60 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(247, 147, 30, 0.3);
        }
        .balance-card h2 {
            font-size: 3rem;
            margin-top: 10px;
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
        <h1>🏪 Dashboard {{ $shop->name }}</h1>
        <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                </form>

        <div class="balance-card">
            <p>Saldo Toko</p>
            <h2>Rp {{ number_format($shop->balance, 0, ',', '.') }}</h2>
        </div>

        <h2>📝 Transaksi Toko Ini</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kasir</th>
                    <th>Items</th>
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
                    <td>{{ $tx->cashier_name }}</td>
                    <td>{{ Str::limit($tx->items, 30) }}</td>
                    <td>{{ $tx->phone }}</td>
                    <td><strong>Rp {{ number_format($tx->total, 0, ',', '.') }}</strong></td>
                    <td>
                        <span class="badge badge-{{ $tx->status === 'SELESAI' ? 'success' : 'warning' }}">
                            {{ $tx->status }}
                        </span>
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
