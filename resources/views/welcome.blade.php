<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barudax Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background-color: #6f4e37; /* Warna Kopi */
            color: white;
            padding: 80px 0;
            text-align: center;
            margin-bottom: 40px;
        }
        .menu-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            border-radius: 15px;
            overflow: hidden;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        .card-img-top {
            height: 200px; 
            object-fit: cover;
        }
        .section-title {
            color: #6f4e37;
            font-weight: 800;
            margin-bottom: 10px; /* Jarak judul ke thumbnail */
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .alert-fixed {
            position: fixed; 
            top: 20px; 
            right: 20px; 
            z-index: 9999;
            width: 300px;
        }

        /* --- TAMBAHAN BARU: CSS UNTUK HEADER KATEGORI & THUMBNAIL --- */
        .category-header {
            text-align: center;
            margin-bottom: 40px;
            margin-top: 40px;
        }
        .category-thumb {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%; /* Membuat gambar bulat */
            border: 3px solid #fff; /* List putih di sekeliling */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin: 0 5px; /* Jarak antar bola gambar */
            transition: transform 0.2s;
            cursor: pointer;
        }
        .category-thumb:hover {
            transform: scale(1.1); /* Efek membesar saat disentuh mouse */
            border-color: #6f4e37;
        }
    </style>
</head>
<body class="bg-light">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show alert-fixed shadow" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div style="position: fixed; bottom: 30px; right: 30px; z-index: 100;">
        <a href="{{ route('checkout') }}" class="btn btn-success btn-lg shadow-lg rounded-pill position-relative px-4 py-3">
            🛒 Lihat Pesanan
            @php $cartCount = count(session('cart', [])); @endphp
            @if($cartCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                {{ $cartCount }}
            </span>
            @endif
        </a>
    </div>

    <div class="hero-section shadow-sm">
        <div class="container">
            <img src="https://cdn-icons-png.flaticon.com/512/751/751621.png" alt="Logo" width="90" class="mb-3">
            <h1 class="fw-bold">Selamat Datang di Barudax Coffee</h1>
            <p class="lead opacity-75">Seduh cerita barumu hari ini bersama kopi terbaik kami.</p>
        </div>
    </div>

    <div class="container pb-5">
        
        <div class="category-header">
            <h2 class="section-title">
                <span class="d-inline-flex align-items-center border-bottom border-3 border-secondary pb-2 px-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/924/924514.png" width="40" height="40" class="me-2" alt="Icon Kopi">
                    Menu Coffee
                </span>
            </h2>

            <div class="d-flex justify-content-center mt-3">
                @foreach($coffees->take(4) as $item)
                    <img src="{{ $item->image }}" class="category-thumb" alt="Preview" title="{{ $item->name }}">
                @endforeach
            </div>
        </div>

        <div class="row">
            @foreach($coffees as $menu)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card menu-card h-100">
                    <img src="{{ $menu->image }}" class="card-img-top" alt="{{ $menu->name }}">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold mb-0">{{ $menu->name }}</h5>
                            <span class="badge bg-secondary">Coffee</span>
                        </div>
                        <p class="card-text text-muted small flex-grow-1">{{ $menu->description }}</p>
                        <h5 class="text-success fw-bold mb-3">Rp {{ number_format($menu->price, 0, ',', '.') }}</h5>
                        
                        <div class="bg-light p-3 rounded">
                            <form action="{{ route('add.cart', $menu->id) }}" method="POST">
                                @csrf
                                <div class="row g-2 mb-2">
                                    <div class="col-4">
                                        <label class="form-label small fw-bold">Jml</label>
                                        <input type="number" name="quantity" class="form-control form-control-sm text-center" value="1" min="1">
                                    </div>
                                    <div class="col-8">
                                        <label class="form-label small fw-bold">Catatan</label>
                                        <input type="text" name="note" class="form-control form-control-sm" placeholder="Less sugar...">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-dark w-100 btn-sm">
                                    + Tambah
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="category-header mt-5 pt-3">
            <h2 class="section-title">
                <span class="d-inline-flex align-items-center border-bottom border-3 border-secondary pb-2 px-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/2405/2405597.png" width="40" height="40" class="me-2" alt="Icon Non-Coffee">
                    Non-Coffee
                </span>
            </h2>

            <div class="d-flex justify-content-center mt-3">
                @foreach($nonCoffees->take(4) as $item)
                    <img src="{{ $item->image }}" class="category-thumb" alt="Preview" title="{{ $item->name }}">
                @endforeach
            </div>
        </div>

        <div class="row">
            @foreach($nonCoffees as $menu)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card menu-card h-100">
                    <img src="{{ $menu->image }}" class="card-img-top" alt="{{ $menu->name }}">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold mb-0">{{ $menu->name }}</h5>
                            <span class="badge bg-warning text-dark">Non-Coffee</span>
                        </div>
                        <p class="card-text text-muted small flex-grow-1">{{ $menu->description }}</p>
                        <h5 class="text-success fw-bold mb-3">Rp {{ number_format($menu->price, 0, ',', '.') }}</h5>
                        
                        <div class="bg-light p-3 rounded">
                            <form action="{{ route('add.cart', $menu->id) }}" method="POST">
                                @csrf
                                <div class="row g-2 mb-2">
                                    <div class="col-4">
                                        <label class="form-label small fw-bold">Jml</label>
                                        <input type="number" name="quantity" class="form-control form-control-sm text-center" value="1" min="1">
                                    </div>
                                    <div class="col-8">
                                        <label class="form-label small fw-bold">Catatan</label>
                                        <input type="text" name="note" class="form-control form-control-sm" placeholder="Opsi...">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-dark w-100 btn-sm">
                                    + Tambah
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>

    <footer class="text-center py-4 bg-white mt-5 border-top">
        <small class="text-muted">&copy; 2025 Barudax Coffee App. Dibuat dengan Laravel.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>