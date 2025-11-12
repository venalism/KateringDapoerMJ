<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dapoer MJ')</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #F8F4E1;
            color: #4E1F00;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            background-color: #FEBA17 !important;
        }

        .navbar-brand {
            font-weight: bold;
            color: #4E1F00 !important;
        }

        .navbar-toggler {
            border-color: #4E1F00;
        }

        .btn-primary {
            background-color: #4E1F00;
            border-color: #4E1F00;
        }

        .btn-primary:hover {
            background-color: #74512D;
            border-color: #74512D;
        }

        main {
            margin-top: 90px;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #FEBA17;
            color: #4E1F00;
            padding: 20px 0;
            text-align: center;
            z-index: 1030;
        }
        html {
        scroll-behavior: smooth; /* Bonus: Bikin scroll-nya jadi alus */
        scroll-padding-top: 90px; /* INI SOLUSINYA */
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">🍱 Dapoer MJ</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menu tengah -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#menu') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#cara-pesan') }}">Cara Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#kontak') }}">Kontak</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    @auth
                        <!-- Kalau user sudah login -->
                        <a href="{{ url('/cart') }}" class="btn btn-sm text-white" style="background-color: #4E1F00;">
                            <i class="bi bi-cart-fill"></i> Keranjang
                        </a>

                        <div class="dropdown">
                            <button class="btn btn-sm text-white dropdown-toggle" style="background-color: #4E1F00;" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ url('/profile/index') }}"><i class="bi bi-gear"></i> Profil Saya</a></li>
                                @if (Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ url('/admin/dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard Admin</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Kalau belum login -->
                        <a href="{{ url('/cart') }}" class="btn btn-sm text-white" style="background-color: #4E1F00;">
                            <i class="bi bi-cart-fill"></i> Keranjang
                        </a>
                        <a href="{{ url('/login') }}" class="btn btn-sm text-white" style="background-color: #4E1F00;">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                        <a href="{{ url('/register') }}" class="btn btn-sm text-white" style="background-color: #74512D;">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer>
        <div class="container">
            &copy; {{ date('Y') }} Dapoer MJ. All rights reserved.
        </div>
    </footer>
@include('components.chatbot')
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

