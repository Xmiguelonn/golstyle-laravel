<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GolStyle — Acceso Admin</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background: #0f0f0f;
            background-image: radial-gradient(ellipse at top center, #1a1a1a 0%, #0f0f0f 65%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-brand {
            text-align: center;
            margin-bottom: 36px;
        }

        .login-brand .icon { font-size: 2.8rem; display: block; margin-bottom: 10px; }

        .login-brand h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #d4af37;
            text-transform: uppercase;
            letter-spacing: 4px;
        }

        .login-brand p {
            font-size: 0.75rem;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 4px;
        }

        .login-card {
            background: linear-gradient(160deg, #1a1a1a, #161616);
            border-radius: 16px;
            padding: 40px 36px;
            border-top: 3px solid #d4af37;
            box-shadow: 0 30px 80px rgba(0,0,0,0.7), 0 0 0 1px rgba(212,175,55,0.07);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(212,175,55,0.4), transparent);
        }

        .login-card h2 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #ccc;
            margin-bottom: 28px;
            letter-spacing: 0.3px;
        }

        .campo { margin-bottom: 20px; }

        .campo label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: #d4af37;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .campo input {
            width: 100%;
            padding: 13px 16px;
            background: #121212;
            border: 1px solid #252525;
            border-radius: 8px;
            color: #e0e0e0;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.25s ease;
        }

        .campo input:hover { border-color: #333; }

        .campo input:focus {
            outline: none;
            border-color: #d4af37;
            background: #141414;
            box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
        }

        .campo .error-msg {
            color: #ff6b6b;
            font-size: 0.78rem;
            margin-top: 6px;
            display: block;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #d4af37, #b8941f);
            border: none;
            border-radius: 8px;
            color: #121212;
            font-size: 0.9rem;
            font-weight: 700;
            font-family: inherit;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 20px rgba(212,175,55,0.25);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #e8c84e, #d4af37);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(212,175,55,0.4);
        }

        .btn-submit:active { transform: translateY(0); }

        .login-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 0.75rem;
            color: #3a3a3a;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <div class="login-brand">
        <span class="icon">⚽</span>
        <h1>GolStyle</h1>
        <p>Panel de administración</p>
    </div>

    <div class="login-card">
        <h2>Accede con tu cuenta</h2>

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="campo">
                <label for="correo">Correo electrónico</label>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    value="{{ old('correo') }}"
                    placeholder="admin@golstyle.com"
                    required
                    autofocus
                >
                @error('correo')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="campo">
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Entrar</button>
        </form>
    </div>

    <p class="login-footer">GolStyle &copy; {{ date('Y') }}</p>

</div>

</body>
</html>
