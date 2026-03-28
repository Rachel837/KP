<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Krema Track - Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #e5e5e5;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left h1 {
            font-size: 60px;
            font-weight: bold;
        }

        .right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #cfcfcf;
            padding: 40px;
            width: 350px;
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 20px;
        }

        .input-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .input-group label {
            font-size: 12px;
            color: #666;
        }

        .input-group input {
            width: 100%;
            padding: 8px;
            border: none;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            background: #7ea6c7;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background: #6b94b3;
        }

        .forgot {
            display: block;
            margin-top: 15px;
            border: 1px solid #888;
            padding: 5px;
            font-size: 12px;
            text-decoration: none;
            color: #444;
        }

        .error {
            color: #d32f2f;
            background-color: #ffebee;
            font-size: 12px;
            margin-bottom: 15px;
            padding: 10px;
            border-left: 4px solid #d32f2f;
            border-radius: 2px;
            text-align: left;
        }

        .success {
            color: #388e3c;
            background-color: #e8f5e9;
            font-size: 12px;
            margin-bottom: 15px;
            padding: 10px;
            border-left: 4px solid #388e3c;
            border-radius: 2px;
            text-align: left;
        }

        .error-input {
            border: 1px solid #d32f2f !important;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="left">
        <h1>Krema<br>Track</h1>
    </div>

    <div class="right">
        <div class="login-box">
            <h2>SIGN IN</h2>

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="success" id="successAlert">
                    <strong>✓</strong> {{ session('success') }}
                </div>
                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('successAlert');
                        if (alert) alert.style.display = 'none';
                    }, 5000); // Hilang setelah 5 detik
                </script>
            @endif

            {{-- Notifikasi Error --}}
            @if(session('error'))
                <div class="error" id="errorAlert">
                    <strong>✗</strong> {{ session('error') }}
                </div>
            @endif

            {{-- Validasi Error dari Form --}}
            @if($errors->any())
                <div class="error">
                    <strong>{{ $errors->first() }}</strong>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <label for="username">email</label>
                    <input 
                        type="text" 
                        id="username"
                        name="email" 
                        placeholder="Karyawan" 
                        value="{{ old('email') }}"
                        class="@error('email') error-input @enderror"
                        required>
                    {{-- @error('email')
                        <span class="error" style="display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror --}}
                </div>

                <div class="input-group">
                    <label for="password">password</label>
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        class="@error('password') error-input @enderror"
                        required>
                    @error('password')
                        <span class="error" style="display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-login">LOGIN</button>
            </form>

            <a href="#" class="forgot">Forgot Password?</a>
        </div>
    </div>
</div>

</body>
</html>