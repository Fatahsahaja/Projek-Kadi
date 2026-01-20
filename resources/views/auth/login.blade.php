<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KADI Coffee</title>

    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f2f5; /* Background abu-abu muda agar card menonjol */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        /* Container Card Utama */
        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden; /* Supaya dekorasi tidak keluar card */
            width: 100%;
            max-width: 900px;
            min-height: 500px;
        }

        /* --- Sisi Kiri (Dekorasi Oranye) --- */
        .left-side {
            background: linear-gradient(135deg, #f7931e 0%, #ffc570 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            overflow: hidden;
        }

        /* Membuat efek lingkaran/gelembung di sisi kiri */
        .circle-decoration {
            position: absolute;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
        }
        .circle-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            right: -100px;
        }
        .circle-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            left: -50px;
        }

        .welcome-text h2 {
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .welcome-text p {
            font-weight: 300;
            letter-spacing: 2px;
            font-size: 1.2rem;
        }

        /* --- Sisi Kanan (Form Login) --- */
        .right-side {
            padding: 3rem;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-title {
            color: #f7931e;
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        /* Custom Input Style sesuai Gambar */
        .form-custom {
            background-color: #f5f5f5;
            border: none;
            border-radius: 0;
            border-left: 4px solid #f7931e; /* Garis oranye di kiri input */
            padding: 10px 15px;
            margin-bottom: 1.5rem;
            color: #555;
        }

        .form-custom:focus {
            background-color: #fff;
            box-shadow: 0 0 5px rgba(247, 147, 30, 0.3);
            outline: none;
        }

        /* Placeholder color */
        .form-custom::placeholder {
            color: #b0b0b0;
        }

        /* Tombol Login Gradient */
        .btn-login {
            background: linear-gradient(90deg, #ffc570 0%, #f7931e 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            color: white;
        }

        /* Separator OR */
        .separator {
            display: flex;
            align-items: center;
            text-align: center;
            color: #999;
            margin: 1.5rem 0;
            font-size: 0.8rem;
        }
        .separator::before, .separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ddd;
        }
        .separator:not(:empty)::before {
            margin-right: .5em;
        }
        .separator:not(:empty)::after {
            margin-left: .5em;
        }

        /* Tombol Sign Up */
        .btn-signup {
            background: linear-gradient(90deg, #ffc570 0%, #f7931e 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        .btn-signup:hover {
            color: white;
            opacity: 0.9;
        }

        /* Responsive Mobile */
        @media (max-width: 768px) {
            .left-side {
                display: none; /* Sembunyikan dekorasi di HP biar fokus login */
            }
            .login-card {
                max-width: 400px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="login-card row g-0">

                <div class="col-md-6 left-side">
                    <div class="circle-decoration circle-1"></div>
                    <div class="circle-decoration circle-2"></div>

                    <div class="welcome-text position-relative z-1">
                        <h2>WELCOME</h2>
                        <p>BACK</p>
                    </div>
                </div>

                <div class="col-md-6 right-side">
                    <h3 class="login-title">Login Page</h3>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf <div class="form-group">
                            <input type="text"
                                   class="form-control form-custom @error('email') is-invalid @enderror"
                                   name="email"
                                   placeholder="No Telepon"
                                   required
                                   autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password"
                                   class="form-control form-custom @error('password') is-invalid @enderror"
                                   name="password"
                                   placeholder="Password"
                                   required>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-login">
                            Login
                        </button>

                        <div class="separator">OR</div>

                        <a href="{{ route('register') }}" class="btn btn-signup">
                            Sign Up
                        </a>
                    </form>
                    </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
