<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Dapoer MJ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #fff7ec; /* mirip tampilan login */
            font-family: 'Poppins', sans-serif;
        }

        .profile-sidebar {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 2px solid #4E1F00;
        }

        .profile-sidebar h5 {
            font-weight: 600;
            color: #4E1F00;
        }

        .profile-sidebar a {
            display: block;
            padding: 10px 0;
            font-weight: 500;
            color: #333;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: 0.3s;
        }

        .profile-sidebar a:hover,
        .profile-sidebar .active {
            color: #4E1F00;
            border-left: 3px solid #4E1F00;
            background: #ffe7ca;
            border-radius: 5px;
            padding-left: 12px;
        }

        .content-box {
            background: white;
            border-radius: 12px;
            padding: 25px;
            border: 2px solid #4E1F00;
        }

        .btn-orange {
            background: #4E1F00;
            color: white;
            font-weight: 600;
            border-radius: 6px;
        }
        .btn-orange:hover {
            background: #4E1F00;
        }
    </style>
</head>

<body>

<div class="container py-5">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="profile-sidebar shadow-sm">

                <h5 class="mb-3">{{ Auth::user()->name }}</h5>
                <hr>

                <a href="/" class="mb-1">🏠 Kembali ke Beranda</a>

                <a href="{{ route('profile.index') }}" class="{{ request()->routeIs('profile.index') ? 'active' : '' }}">
                    👤 Profil Saya
                </a>

                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    ✏️ Edit Profil
                </a>


                <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.index') ? 'active' : '' }}">
                    🛍️ Riwayat Pesanan
                </a>

                <hr>

                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    🚪 Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" hidden>@csrf</form>

            </div>
        </div>

        <!-- Content -->
        <div class="col-md-9">
            <div class="content-box shadow-sm">
                @yield('content')
            </div>
        </div>

    </div>
</div>

</body>
</html>
