<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LetsInput-Tajurhalang') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/favicon.svg') }}" type="image/svg+xml">
    <link rel="shortcut icon" href="{{ asset('img/favicon.svg') }}" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Base styles */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #006940 0%, #00522c 100%);
            color: #1f2937;
            overflow: hidden;
            position: relative;
        }

        /* Background pattern */
        .bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* Responsive adjustments */
        @media (max-height: 700px) {
            .logo {
                width: 5rem;
                height: 5rem;
                margin-bottom: 0.5rem;
            }
            h1 {
                font-size: 1.5rem;
                margin-bottom: 0.2rem;
            }
            p {
                font-size: 0.875rem;
                margin-bottom: 0.5rem;
            }
            .features {
                margin-bottom: 0.75rem;
            }
            .footer {
                padding-top: 0.5rem;
            }
        }

        /* Layout */
        .container {
            height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0;
            overflow: hidden;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            margin: 0 auto;
        }

        .card {
            background-color: white;
            border-radius: 1rem;
            border-top: 4px solid #FFDE00;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            padding: 2rem;
            width: 100%;
            max-width: 42rem;
            max-height: 95vh;
            text-align: center;
            overflow-y: auto;
            margin: 0;
            display: flex;
            flex-direction: column;
            position: relative;
            backdrop-filter: blur(10px);
        }

        /* Typography */
        h1 {
            font-size: 1.875rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            color: #064e3b;
            letter-spacing: -0.025em;
        }

        p {
            color: #4b5563;
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }

        /* Logo animation */
        .logo {
            width: 8rem;
            height: 8rem;
            margin: 0 auto 0.75rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Features section */
        .features {
            display: flex;
            flex-direction: row;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .feature {
            flex: 1;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 1.5rem;
            height: 1.5rem;
            margin: 0 auto 0.25rem;
            fill: none;
            stroke: #006940;
            stroke-width: 2;
        }

        .feature-title {
            font-weight: 600;
            font-size: 0.875rem;
            color: #1f2937;
        }        /* Button */
        .btn {
            display: inline-flex;
            height: 3rem;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1.5rem;
            background-color: #006940;
            color: white;
            font-weight: 600;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: background-color 0.2s;
            margin: 0.5rem auto 1rem auto;
        }

        .btn:hover {
            background-color: #00422c;
        }

        .btn-secondary {
            background-color: #f0b429;
            color: #1f2937;
        }

        .btn-secondary:hover {
            background-color: #de9e1d;
        }

        .btn-icon {
            width: 1rem;
            height: 1rem;
            margin-right: 0.375rem;
        }

        /* Footer */
        .footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 0.75rem;
            margin-top: auto;
            color: #6b7280;
            font-size: 0.75rem;
        }

        .footer p {
            margin-bottom: 0.25rem;
        }

        .heart {
            color: #ef4444;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <svg class="logo" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                <!-- Yellow background shield -->
                <path d="M200 20 L370 150 L350 340 L200 380 L50 340 L30 150 Z" fill="#FFDE00" stroke="#000" stroke-width="4"/>

                <!-- Green pentagon -->
                <path d="M200 60 L320 160 L280 300 L120 300 L80 160 Z" fill="#008751" stroke="#000" stroke-width="4"/>

                <!-- Black circle for the center emblem -->
                <circle cx="200" cy="180" r="60" fill="#000"/>

                <!-- Yellow triangle in center -->
                <path d="M200 140 L240 200 L160 200 Z" fill="#FFDE00" stroke="#000" stroke-width="2"/>

                <!-- Stylized torch -->
                <path d="M195 180 L197 160 L203 160 L205 180 Z" fill="#FFFFFF"/>
                <path d="M196 160 C196 155, 200 150, 204 160" fill="#FFFFFF"/>

                <!-- Text path -->
                <path id="villageText" d="M80 240 A120 120 0 0 0 320 240" fill="none"/>
                <text font-family="Arial" font-weight="bold" font-size="20" fill="#FFDE00">
                    <textPath href="#villageText" text-anchor="middle" startOffset="50%">TAJURHALANG</textPath>
                </text>

                <!-- Bottom text -->
                <text x="200" y="350" font-family="Arial" font-weight="bold" font-size="24" text-anchor="middle" fill="#000">TEGAR BERIMAN</text>
            </svg>

            <h1>Sistem Informasi Kependudukan</h1>
            <p class="mb-2">Desa Tajurhalang - Kecamatan Tajurhalang - Kabupaten Bogor</p>
            <p>Kelola data kependudukan desa dengan mudah dan efisien</p>

            <div class="features">
                <div class="feature">
                    <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <div class="feature-title">Terpercaya</div>
                </div>

                <div class="feature">
                    <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <div class="feature-title">Cepat</div>
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
                    Masuk ke Dashboard
                </a>
            @endif

            <div class="footer">
                <p class="text-gray-700">Sistem Informasi Kependudukan © {{ date('Y') }} Pemerintah Desa Tajurhalang</p>
                <p class="text-gray-700">"Tegar Beriman" - Membangun Desa Bersama Masyarakat</p>
                <p class="text-gray-700">Jl. Jatayu No. 5, Kecamatan Tajurhalang, Kabupaten Bogor</p>
            </div>
        </div>
    </div>
</body>
</html>
