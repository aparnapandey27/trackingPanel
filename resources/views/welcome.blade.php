<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to {{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                background-color: #f4f6f9;
            }
            .container {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                text-align: center;
                background-image: url('/images/welcome-bg.jpg');
                background-size: cover;
                background-position: center;
            }
            .content {
                background: rgba(255, 255, 255, 0.9);
                padding: 20px 40px;
                border-radius: 10px;
                box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            }
            h1 {
                font-size: 3rem;
                margin-bottom: 20px;
                color: #333;
            }
            p {
                font-size: 1.2rem;
                color: #666;
                margin-bottom: 30px;
            }
            .btn {
                display: inline-block;
                padding: 10px 20px;
                font-size: 1rem;
                color: #fff;
                background-color: #b8c4d1;
                border: none;
                border-radius: 5px;
                text-decoration: none;
                margin: 5px;
                transition: background-color 0.3s;
            }
            .btn:hover {
                background-color: #6d8aa9;
            }
            .auth-links {
                margin-top: 30px;
            }
            .auth-links a {
                color: #007bff;
                text-decoration: none;
                font-weight: 500;
                margin: 0 10px;
                transition: color 0.3s;
            }
            .auth-links a:hover {
                color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1>Welcome to {{ config('app.name') }}</h1>
                <p>Your one-stop platform for managing your employees, affiliates, and advertisers efficiently.</p>

                @if (Route::has('login'))
                    <div class="auth-links">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="btn">Go to Dashboard</a>

                            <!-- Logout Button -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn">Log in</a>

                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
