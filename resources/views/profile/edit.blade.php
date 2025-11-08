@extends('layouts.app')

@section('content')
<style>
    body {
        background: #fff7ec;
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
        background: #361600;
    }
</style>

<div class="container py-5">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="profile-sidebar shadow-sm">

                <h5 class="mb-3">{{ Auth::user()->name }}</h5>
                <hr>

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
                <form id="logout-form" action="{{ route('logout') }}" method="POST" hidden>
                    @csrf
                </form>

            </div>
        </div>

        <!-- Content -->
       <div class="col-md-9">
            <div class="content-box shadow-sm">

                <h4 class="mb-4">Edit Profil</h4>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <button class="btn btn-orange px-4">Simpan</button>
                    <a href="{{ route('profile.index') }}" class="btn btn-secondary px-4">Batal</a>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection

