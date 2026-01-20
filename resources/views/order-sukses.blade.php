<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KADI - Order Berhasil</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .success-card {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
        }
        .checkmark {
            font-size: 5rem;
            margin-bottom: 20px;
            animation: pop 0.5s ease-out;
        }
        @keyframes pop {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        h1 {
            color: #28a745;
            margin-bottom: 15px;
        }
        p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .order-id {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 600;
            color: #333;
        }
        .btn-back {
            background: linear-gradient(135deg, #f7931e 0%, #ffad60 100%);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(247, 147, 30, 0.3);
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="checkmark">✅</div>
        <h1>Pesanan Berhasil!</h1>
        <p>Terima kasih! Pesanan kamu sudah kami terima dan sedang diproses.</p>

        @if(isset($order_id))
        <div class="order-id">
            Order ID: #{{ $order_id }}
        </div>
        @endif

        <p style="font-size: 0.9rem; color: #999;">
            Silakan tunggu pesanan kamu di kantin ya! 😊
        </p>

        <a href="{{ route('customer.menu') }}" class="btn-back">Kembali ke Menu</a>
    </div>
</body>
</html>
