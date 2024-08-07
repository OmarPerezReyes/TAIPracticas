<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            margin: 0;
            font-family: Figtree, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #374151;
            text-align: center;
        }
        .container {
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 400px;
            width: 100%;
        }
        .logo {
            margin-bottom: 1rem;
        }
        .logo img {
            max-width: 100px;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.375rem;
            text-decoration: none;
            color: #ffffff;
            background-color: #18aaa8; /* Nuevo color de fondo */
            transition: background-color 0.2s ease;
        }
        .btn:hover {
            background-color: #148e88; /* Color de fondo en hover ajustado */
        }
        .auth-links {
            margin-top: 1.5rem;
        }
        .auth-links a {
            color: #374151;
            font-weight: 600;
            text-decoration: none;
            margin: 0 0.5rem;
        }
        .auth-links a:hover {
            color: #18aaa8; /* Color del texto en hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
        </div>
        
        <!-- Content -->
        <h1 class="text-2xl font-bold mb-4">Punto de venta de cafetería</h1>
        <p class="text-gray-600 mb-6">Realizada en Laravel.</p>
        
        @if (Route::has('login'))
            <div class="auth-links">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn">Iniciar sesión</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn">Registrarse</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</body>
</html>
