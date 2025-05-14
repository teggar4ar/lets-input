<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Let\'sInput') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        /* Base styles */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Figtree', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
        }

        /* Layout */
        .container {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            width: 100%;
            max-width: 42rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Typography */
        h1 {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #111827;
        }

        p {
            color: #4b5563;
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
        }

        /* Logo animation */
        .logo {
            width: 6rem;
            height: 6rem;
            margin: 0 auto 1.5rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Features section */
        .features {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 640px) {
            .features {
                flex-direction: row;
            }
        }

        .feature {
            flex: 1;
            background-color: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 0.5rem;
            padding: 1rem;
        }

        .feature-icon {
            width: 2rem;
            height: 2rem;
            margin: 0 auto 0.5rem;
            fill: none;
            stroke: #3b82f6;
            stroke-width: 2;
        }

        .feature-title {
            font-weight: 600;
            font-size: 1rem;
            color: #1f2937;
        }

        /* Button */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background-color: #2563eb;
            color: white;
            font-weight: 600;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: background-color 0.2s;
            margin-bottom: 1rem;
        }

        .btn:hover {
            background-color: #1d4ed8;
        }

        .btn-icon {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.5rem;
        }

        /* Footer */
        .footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 1.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .heart {
            color: #ef4444;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <svg class="logo" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="60" r="54" fill="white" stroke="#3b82f6" stroke-width="6"/>
                <ellipse cx="60" cy="70" rx="32" ry="18" fill="#3b82f6" opacity="0.1"/>
                <ellipse cx="60" cy="60" rx="36" ry="36" fill="#3b82f6" opacity="0.05"/>
                <circle cx="45" cy="55" r="7" fill="white"/>
                <circle cx="75" cy="55" r="7" fill="white"/>
                <ellipse cx="45" cy="57" rx="2.5" ry="3.5" fill="#1e3a8a"/>
                <ellipse cx="75" cx="57" rx="2.5" ry="3.5" fill="#1e3a8a"/>
                <path d="M48 78 Q60 90 72 78" stroke="#1e3a8a" stroke-width="3" fill="none" stroke-linecap="round"/>
            </svg>

            <h1>Welcome to Let'sInput</h1>
            <p>Your one-stop solution for managing population data with style and ease.</p>

            <div class="features">
                <div class="feature">
                    <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <div class="feature-title">Secure</div>
                </div>

                <div class="feature">
                    <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <div class="feature-title">Fast</div>
                </div>

                <div class="feature">
                    <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div class="feature-title">Modern</div>
                </div>
            </div>

            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn">
                    <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Log in to Dashboard
                </a>
            @endif

            <div class="footer">
                <p>Made with <span class="heart">♥</span> by the Let'sInput Team &middot; {{ date('Y') }}</p>
                <p>Explore, analyze, and manage your data like never before.</p>
            </div>
        </div>
    </div>
</body>
</html>
