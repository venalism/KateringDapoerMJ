<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title', 'Admin Panel') - Dapoer MJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #343a40;
        }

        .sidebar .nav-link {
            color: #c2c7d0;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #495057;
        }

        .content {
            flex-grow: 1;
            padding: 30px;
        }
    </style>
</head>

<body>
    <div class="sidebar p-3 d-flex flex-column">
        <h4 class="text-white text-center mb-4">Dapoer MJ Panel</h4>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('menu.index') }}" class="nav-link {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                    <i class="fa fa-utensils me-2"></i> Kelola Menu
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('categories.index') }}"
                    class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fa fa-tags me-2"></i> Kelola Kategori
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}"
                    class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fa fa-users-cog me-2"></i> Kelola Admin
                </a>
            </li>
        </ul>
        <hr class="text-white">
        <div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100"><i class="fa fa-sign-out-alt me-2"></i>
                    Logout</button>
            </form>
        </div>
    </div>

    <main class="content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>