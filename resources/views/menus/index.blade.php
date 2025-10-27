@extends('layouts.app')

@section('title', 'Beranda - Dapoer MJ')

@section('content')
    <div class="py-4" style="background-color: #F8F4E1;">
        <div class="container">

            {{-- Kategori --}}
            <section id="kategori" class="py-5">
                <br>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-13 text-center text-md-start mb-4 mb-md-0">
                            <h1 class="fw-bold">Selamat Datang di <span style="color: #FEBA17;">Dapoer MJ</span></h1>
                            <p class="lead">Dapoer MJ adalah layanan katering rumahan terpercaya yang menyajikan aneka menu
                                dengan cita rasa rumahan yang menggugah selera. Kami menghadirkan pilihan paket seperti nasi
                                kotak, snack box, tumpeng, nasi liwet, hingga prasmanan — semuanya dimasak dari bahan segar,
                                porsi terukur, dan dikemas secara higienis. Pesan menu favoritmu sekarang!</p>
                            <a href="#menu" class="btn btn-lg btn-primary mt-3">Lihat Menu</a>
                        </div>
                        {{-- <div class="col-md-6">
                            <img src="menu1.png" alt="Ilustrasi Makanan" class="img-fluid rounded shadow">
                        </div> --}}
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-around flex-wrap p-4 rounded shadow-sm"
                    style="background-color: #FEBA17; color:#4E1F00">
                    <div class="text-center mx-3" style="max-width: 150px;">
                        <img src="{{ asset('image/image.png') }}" width="50" alt="Sehat & Lezat">
                        <p class="mt-2 fw-semibold">Sehat & Lezat</p>
                    </div>
                    <div class="text-center mx-3" style="max-width: 150px;">
                        <img src="{{ asset('image/image2.png') }}" width="50" alt="Porsi Terukur">
                        <p class="mt-2 fw-semibold">Porsi Terukur</p>
                    </div>
                    <div class="text-center mx-3" style="max-width: 150px;">
                        <img src="{{ asset('image/image3.png') }}" width="50" alt="Kemasan Rapi">
                        <p class="mt-2 fw-semibold">Kemasan Rapi</p>
                    </div>
                    <div class="text-center mx-3" style="max-width: 150px;">
                        <img src="{{ asset('image/image4.png') }}" width="50" alt="Harga Terjangkau">
                        <p class="mt-2 fw-semibold">Harga Terjangkau</p>
                    </div>
                    <div class="text-center mx-3" style="max-width: 150px;">
                        <img src="{{ asset('image/image5.png') }}" width="50" alt="Tepat Waktu">
                        <p class="mt-2 fw-semibold">Tepat Waktu</p>
                    </div>
                </div>
            </section>

            {{-- Search Bar --}}
            {{-- <form action="{{ route('menus.index') }}" method="GET" class="d-flex mt-4" id="cari">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari Menu atau Restaurant">
                <select name="budget" class="form-select me-2" style="max-width: 200px;">
                    <option value="">Any Budget</option>
                    <option value="50000">
                        < Rp 50.000</option>
                    <option value="100000">
                        < Rp 100.000</option>
                </select>
                <button type="submit" class="btn text-white px-4" style="background:#4E1F00;">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
            </form> --}}

            {{-- Menu Populer --}}
            <div class="mt-5" id="menu">
                <h2 class="mb-4 fw-bold">Menu Populer</h2>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach ($menus as $menu)
                        <div class="col">
                            <div class="card h-100 shadow-sm" style="background-color: white;">
                                {{-- Cek dulu apakah ada foto di galeri, untuk menghindari error --}}
                                @if ($menu->photos->isNotEmpty())
                                    <img src="{{ asset('image/' . $menu->photos->first()->photo) }}"
     class="img-fluid rounded shadow"
     alt="{{ $menu->name }}">

                                @else
                                    {{-- Tampilkan gambar default jika tidak ada foto sama sekali --}}
                                    <img src="{{ asset('image/default_image.png') }}" class="img-fluid rounded shadow"
                                        alt="Gambar tidak tersedia">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $menu->name }}</h5>
                                    {{-- <p class="card-text fw-bold text-danger">Rp {{ number_format($menu->price, 0, ',', '.')
                                        }}</p> --}}
                                    {{-- <p class="card-text"><small class="text-muted">Tersedia: {{
                                            \Carbon\Carbon::parse($menu->date)->format('d M Y') }}</small></p> --}}
                                    {{-- @if ($menu->is_popular)
                                    <span class="badge bg-warning text-dark">🔥 Populer</span>
                                    @endif --}}
                                </div>
                                <div class="card-footer" style="background-color: white; border: none;">
                                    <a href="{{ route('menus.show', $menu) }}" style="background-color: #FEBA17"
                                        class="btn btn-warning w-100 text-white">Lihat</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Cara Pemesanan --}}
            <div class="mt-5" id="cara-pesan">
                <h2 class="mb-4 fw-bold">Cara Pemesanan</h2>
                <div class="row row-cols-1 row-cols-md-5 g-4 text-center">
                    <div class="col">
                        <div class="p-3 rounded shadow-sm h-100" style="background-color: white;">
                            <div class="step-circle">1</div>
                            <p class="mt-3">Pilih menu yang Anda inginkan di halaman <strong>Menu</strong>.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 rounded shadow-sm h-100" style="background-color: white;">
                            <div class="step-circle">2</div>
                            <p class="mt-3">Klik tombol <strong>"Lihat"</strong> untuk melihat detail menu.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 rounded shadow-sm h-100" style="background-color: white;">
                            <div class="step-circle">3</div>
                            <p class="mt-3">Klik <strong>"Tambah ke keranjang"</strong> jika ingin memesan.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 rounded shadow-sm h-100" style="background-color: white;">
                            <div class="step-circle">4</div>
                            <p class="mt-3">Buka keranjang dan klik <strong>"Pesan via WhatsApp"</strong>.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 rounded shadow-sm h-100" style="background-color: white;">
                            <div class="step-circle">5</div>
                            <p class="mt-3">Hubungi kami melalui WhatsApp atau telepon di <strong>Kontak Kami</strong>.</p>
                        </div>
                    </div>
                </div>
            </div>



            {{-- Kontak --}}
            <div class="mt-5" id="kontak">
                <h2 class="mb-4 fw-bold">Kontak Kami</h2>

                <div class="row g-4">
                    {{-- Google Maps --}}
                    <div class="col-md-6">
                        <h5>Alamat Kami:</h5>
                        <div class="ratio ratio-4x3">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3950.3373582688936!2d107.68145541431068!3d-6.920971199999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68dde839fe42d9%3A0x91866f48cee3ac61!2sMJ%20Kitchen!5e0!3m2!1sen!2sid!4v1653126573478!5m2!1sen!2sid"
                                width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen=""
                                aria-hidden="false" tabindex="0">
                            </iframe>
                        </div>
                    </div>

                    {{-- Form Kontak --}}
                    <div class="col-md-6">
                        <h5>Kirim Pesan Langsung:</h5>
                        <form onsubmit="return kirimWhatsApp();" class="shadow-sm p-4 rounded"
                            style="background-color: #ffffff;">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea class="form-control" id="pesan" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning text-white w-100">Kirim via WhatsApp</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <script>
            function kirimWhatsApp() {
                const nama = document.getElementById("nama").value;
                const email = document.getElementById("email").value;
                const pesan = document.getElementById("pesan").value;

                const noWA = "6289662315611"; // Ganti dengan nomor WA Anda (tanpa tanda +)
                const url = `https://wa.me/${noWA}?text=Halo, saya ${nama}%0AEmail: ${email}%0APesan: ${encodeURIComponent(pesan)}`;

                window.open(url, '_blank');
                return false; // Biar form tidak submit secara default
            }
        </script>

@endsection