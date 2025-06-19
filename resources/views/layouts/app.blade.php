<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dapoer MJ')</title>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <style>

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #F8F4E1;
            color: #4E1F00;
        }

        .step-circle {
    width: 50px;
    height: 50px;
    background-color: #FEBA17;
    color: white;
    border-radius: 50%;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin: 0 auto;
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

        #menu, #beranda, #cara-pesan, #kontak, #cart {
  scroll-margin-top: 80px;
}

        footer {
            background-color: #FEBA17;
            color: #4E1F00;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Dapoer MJ</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menu tengah -->
           <ul class="navbar-nav mx-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/menus#kategori') }}">Beranda</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/menus#menu') }}">Menu</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/menus#cara-pesan') }}">Cara Pesan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/menus#kontak') }}">Kontak</a>
    </li>
</ul>

            <!-- Tombol kanan -->
<div class="d-flex align-items-center gap-2">
    <a href="{{ url('/cart') }}" class="btn btn-sm text-white" style="background-color: #4E1F00;">
        <i class="bi bi-cart-fill"></i> Keranjang
    </a>
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
