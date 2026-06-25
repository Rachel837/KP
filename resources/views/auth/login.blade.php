<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krema Track - Masuk</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <style>
        :root {
            --primary: #2b4c6f;
            --primary-hover: #1e3550;
            --accent: #d97706; /* Warm amber */
            --accent-light: #fef3c7;
            --bg-gradient-start: #f8fafc;
            --bg-gradient-end: #f1f5f9;
            --card-border: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
            min-height: 100vh;
            color: var(--text-dark);
        }

        .split-container {
            display: flex;
            min-height: 100vh;
        }

        /* Left Panel - Dark & Elegant Banner */
        .left-panel {
            flex: 1.2;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(217, 119, 6, 0.12) 0%, rgba(217, 119, 6, 0) 70%);
            pointer-events: none;
        }

        .left-panel-content {
            max-width: 500px;
            margin: auto 0;
            position: relative;
            z-index: 2;
        }

        .left-panel-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 2rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            letter-spacing: -0.5px;
            margin-bottom: 40px;
        }

        .left-panel-logo i {
            color: var(--accent);
            font-size: 2.4rem;
        }

        .left-panel-logo span {
            background: linear-gradient(to right, #ffffff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .left-panel-badge {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.8);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        /* Right Panel - Login Card Form */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: radial-gradient(circle at 70% 70%, rgba(43, 76, 111, 0.03) 0%, transparent 60%);
        }

        .login-card {
            background: white;
            border-radius: 28px;
            border: 1px solid var(--card-border);
            padding: 48px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.06);
            position: relative;
        }

        .btn-back-home {
            position: absolute;
            top: 24px;
            left: 24px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-back-home:hover {
            color: var(--primary);
            transform: translateX(-2px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 36px;
            margin-top: 12px;
        }

        .login-header h2 {
            font-weight: 800;
            font-size: 1.85rem;
            color: #0f172a;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Custom Input Groups */
        .input-group-custom {
            margin-bottom: 24px;
        }

        .input-group-custom label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            text-transform: capitalize;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.15rem;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .form-control-custom {
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            padding: 14px 16px 14px 48px;
            font-size: 0.95rem;
            width: 100%;
            box-sizing: border-box;
            background-color: #f8fafc;
            color: var(--text-dark);
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            background-color: white;
            box-shadow: 0 0 0 4px rgba(43, 76, 111, 0.12);
            outline: none;
        }

        .form-control-custom:focus + .input-icon {
            color: var(--primary);
        }

        /* Alert Styling matching Dashboard */
        .alert-custom {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.85rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid;
            text-align: left;
        }

        .alert-custom-error {
            background-color: #ffebee;
            color: #c62828;
            border-color: #ffcdd2;
        }

        .alert-custom-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-color: #c8e6c9;
        }

        .error-input {
            border: 1.5px solid #ef4444 !important;
            background-color: #fef2f2 !important;
        }

        /* Buttons & Footer Link */
        .btn-login-custom {
            background-color: var(--primary);
            color: white !important;
            font-weight: 700;
            border-radius: 14px;
            padding: 14px;
            width: 100%;
            border: none;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(43, 76, 111, 0.15);
        }

        .btn-login-custom:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(43, 76, 111, 0.25);
        }

        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--primary);
        }

        .register-footer {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #f1f5f9;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .register-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        .footer-copyright {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.4);
            margin-top: auto;
        }

        /* Responsive styling */
        @media (max-width: 991px) {
            .split-container {
                flex-direction: column;
            }
            .left-panel {
                padding: 40px;
                flex: none;
                min-height: auto;
            }
            .left-panel-logo {
                margin-bottom: 20px;
            }
            .left-panel-content p {
                font-size: 1rem;
            }
            .footer-copyright {
                display: none;
            }
            .right-panel {
                padding: 30px 20px;
            }
            .login-card {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>

<div class="split-container">
    <!-- Left Section: Branding -->
    <div class="left-panel">
        <a href="{{ url('/') }}" class="left-panel-logo">
            <i class="ti ti-flame"></i>
            <span>Krema Track</span>
        </a>
        
        <div class="left-panel-content">
            <div class="left-panel-badge">
                <i class="ti ti-activity"></i>
                <span>Monitoring Pelayanan Kremasi</span>
            </div>
            <h1 class="display-6 fw-bold mb-3 text-white">Sistem Transparansi Jadwal Kremasi</h1>
            <p class="lead text-white-50">Silakan masuk menggunakan akun koordinasi Anda untuk mengelola jadwal, menyusun laporan pembakaran, dan memantau status pemrosesan kremasi jenazah secara real-time.</p>
        </div>
        
        <div class="footer-copyright">
            <span>&copy; {{ date('Y') }} Krema Track. Semua Hak Dilindungi.</span>
        </div>
    </div>

    <!-- Right Section: Login Form -->
    <div class="right-panel">
        <div class="login-card">
            <!-- Back to Home -->
            <a href="{{ url('/') }}" class="btn-back-home">
                <i class="ti ti-arrow-back-up"></i>
                <span>Kembali ke Beranda</span>
            </a>

            <div class="login-header">
                <h2>Selamat Datang</h2>
                <p>Masuk untuk mengelola data Krema Track</p>
            </div>

            <!-- Alerts -->
            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="alert-custom alert-custom-success" id="successAlert">
                    <i class="ti ti-circle-check" style="font-size: 1.25rem;"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('successAlert');
                        if (alert) alert.style.display = 'none';
                    }, 5000);
                </script>
            @endif

            {{-- Notifikasi Error --}}
            @if(session('error'))
                <div class="alert-custom alert-custom-error" id="errorAlert">
                    <i class="ti ti-circle-x" style="font-size: 1.25rem;"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            {{-- Validasi Error dari Form --}}
            @if($errors->any())
                <div class="alert-custom alert-custom-error">
                    <i class="ti ti-alert-circle" style="font-size: 1.25rem;"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Input -->
                <div class="input-group-custom">
                    <label for="email">email</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            value="{{ old('email') }}"
                            class="form-control-custom @error('email') error-input @enderror"
                            placeholder="nama@email.com"
                            required>
                        <i class="ti ti-mail input-icon"></i>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="input-group-custom">
                    <label for="password">password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            class="form-control-custom @error('password') error-input @enderror"
                            placeholder="••••••••"
                            required>
                        <i class="ti ti-lock input-icon"></i>
                    </div>
                    @error('password')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-login-custom">MASUK</button>
            </form>

            <a href="#" class="forgot-link">Lupa Password?</a>

        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>