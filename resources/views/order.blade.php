<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KADI - Konfirmasi Order</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f7931e 0%, #ffad60 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .order-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #f7931e;
            margin-bottom: 30px;
            text-align: center;
        }
        .order-detail {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .detail-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 1.2rem;
            color: #f7931e;
        }
        .label {
            color: #666;
        }
        .value {
            font-weight: 600;
            color: #333;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }
        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-confirm {
            background: linear-gradient(135deg, #f7931e 0%, #ffad60 100%);
            color: white;
        }
        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(247, 147, 30, 0.3);
        }
        .btn-cancel {
            background: #6c757d;
            color: white;
        }
        .btn-cancel:hover {
            background: #5a6268;
        }
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            margin-top: 15px;
            font-family: inherit;
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="order-card">
        <h1>📋 Konfirmasi Pesanan</h1>

        <div class="order-detail">
            <div class="detail-row">
                <span class="label">Kantin:</span>
                <span class="value">{{ $shop->name }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Menu:</span>
                <span class="value">{{ $nama_makanan }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Harga:</span>
                <span class="value">Rp {{ number_format($harga, 0, ',', '.') }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Total:</span>
                <span class="value">Rp {{ number_format($harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('order.store') }}">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <input type="hidden" name="items" value="{{ $nama_makanan }}">
            <input type="hidden" name="total" value="{{ $harga }}">

            <label style="color: #666; font-weight: 600;">Catatan (opsional):</label>
            <textarea name="notes" rows="3" placeholder="Contoh: Pedas level 3, ga pake kecap..."></textarea>

            <div class="btn-group">
                <a href="{{ route('customer.menu') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-confirm">Konfirmasi Order</button>
            </div>
        </form>
    </div>
</body>
</html>
