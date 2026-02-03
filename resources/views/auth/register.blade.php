<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - KADI Coffee</title>

    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh; /* Pakai min-height biar bisa di-scroll kalau layar pendek */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 2rem 0; /* Tambah padding atas bawah agar tidak mepet */
        }

        /* Container Card Utama */
        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            /* Hapus min-height fix, biarkan flex yang mengatur tinggi */
            display: flex;
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
            min-height: 600px; /* Sedikit lebih tinggi karena form register panjang */
        }

        /* Dekorasi Lingkaran */
        .circle-decoration {
            position: absolute;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
        }
        .circle-1 {
            width: 300px;
            height: 300px;
            top: -80px;
            right: -80px;
        }
        .circle-2 {
            width: 200px;
            height: 200px;
            bottom: -40px;
            left: -40px;
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
            text-transform: uppercase;
        }

        /* --- Sisi Kanan (Form) --- */
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
            margin-bottom: 1.5rem;
            text-align: center;
        }

        /* Style Input (Sama Persis Login) */
        .form-custom {
            background-color: #f5f5f5;
            border: none;
            border-radius: 0;
            border-left: 4px solid #f7931e;
            padding: 12px 15px; /* Sedikit padding lebih besar */
            margin-bottom: 1rem;
            color: #555;
            transition: all 0.3s;
        }

        .form-custom:focus {
            background-color: #fff;
            box-shadow: 0 0 8px rgba(247, 147, 30, 0.2);
            outline: none;
        }

        .form-custom::placeholder {
            color: #b0b0b0;
        }

        /* Tombol Utama */
        .btn-primary-custom {
            background: linear-gradient(90deg, #ffc570 0%, #f7931e 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-primary-custom:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            color: white;
            box-shadow: 0 5px 15px rgba(247, 147, 30, 0.3);
        }

        /* Link Text */
        .link-text {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #888;
            font-size: 0.9rem;
            text-decoration: none;
        }
        .link-text span {
            color: #f7931e;
            font-weight: 600;
        }
        .link-text:hover span {
            text-decoration: underline;
        }

        /* Responsive Mobile */
        @media (max-width: 768px) {
            .left-side {
                display: none;
            }
            .login-card {
                max-width: 450px;
                margin: 0 15px;
            }
            .right-side {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="login-card row g-0">

                <div class="col-md-6 left-side px-7">
                    <div class="circle-decoration circle-1"></div>
                    <div class="circle-decoration circle-2"></div>

                    <div class="welcome-text position-relative z-1">
                        <h2>JOIN</h2>
                        <p>OUR COMMUNITY</p> </div>
                </div>

                <div class="col-md-6 right-side">
                    <h3 class="login-title">Sign Up</h3>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <input type="text"
                                   class="form-control form-custom @error('name') is-invalid @enderror"
                                   name="name"
                                   placeholder="Nama Lengkap"
                                   value="{{ old('name') }}"
                                   required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="text"
                                   class="form-control form-custom @error('phone') is-invalid @enderror"
                                   name="phone"
                                   placeholder="No Telepon"
                                   value="{{ old('phone') }}"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="email"
                                   class="form-control form-custom @error('email') is-invalid @enderror"
                                   name="email"
                                   placeholder="Email Address"
                                   value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password"
                                   class="form-control form-custom @error('password') is-invalid @enderror"
                                   name="password"
                                   placeholder="Password"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password"
                                   class="form-control form-custom"
                                   name="password_confirmation"
                                   placeholder="Konfirmasi Password"
                                   required>
                        </div>

                        <input type="hidden" name="role" value="customer">

                        <button type="submit" class="btn btn-primary-custom">
                            Sign Up
                        </button>

                        <a href="{{ route('login') }}" class="link-text">
                            Sudah punya akun? <span>Login disini</span>
                        </a>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
