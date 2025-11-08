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
            background-color: #F8F4E1; /* cream soft */
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #4E1F00; /* dark brown */
        }

        .sidebar .nav-link {
            color: #F8F4E1;
            font-weight: 500;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .sidebar .nav-link.active {
            background-color: #FEBA17 !!important; /* yellow highlight */
            color: #4E1F00 !important;
            font-weight: 600;
        }

        .sidebar .nav-link:hover {
            background-color: #FEBA17;
            color: #4E1F00;
        }

        .sidebar h4 {
            color: #FEBA17;
            font-weight: 700;
        }

        .content {
            flex-grow: 1;
            padding: 30px;
        }

        .btn-danger {
            background-color: #FEBA17;
            color: #4E1F00;
            border: none;
            font-weight: 600;
        }

        .btn-danger:hover {
            background-color: #e3a715;
            color: #381700;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar p-3 d-flex flex-column">
        <h4 class="text-center mb-4">Dapoer MJ Panel</h4>

        <ul class="nav flex-column mb-auto">

            <li>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa fa-home me-2"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('menu.index') }}" class="nav-link {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                    <i class="fa fa-utensils me-2"></i> Kelola Menu
                </a>
            </li>

            <li>
                <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fa fa-tags me-2"></i> Kelola Kategori
                </a>
            </li>

            <li>
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fa fa-users-cog me-2"></i> Kelola Admin
                </a>
            </li>

        </ul>

        <hr class="text-white">

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="fa fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>

    <!-- Main Content -->
    <main class="content">
        @yield('content')
    </main>

</body>

</html>
