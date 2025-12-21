<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    
    <title>Admin Dapur - Barudax Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 

    <style>
        body { background-color: #f4f6f9; }
        .card-order {
            border-left: 5px solid #ffc107; /* Kuning tanda pending */
            transition: 0.3s;
        }
        .card-order:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .seat-img { width: 100%; height: 100px; object-fit: cover; border-radius: 5px; cursor: pointer; }
        .stat-card { border-radius: 10px; border: none; color: white; }
        
        /* CSS Khusus untuk label kecil di atas foto */
        .img-label { font-size: 11px; font-weight: bold; display: block; margin-bottom: 4px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">☕ Barudax Kitchen Monitor</span>
            <span class="text-white small">Auto-refresh: 30s</span>
        </div>
    </nav>

    <div class="container-fluid px-4">
        
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card bg-primary p-3">
                    <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <small>Total Pendapatan</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-success p-3">
                    <h3>{{ $totalOrders }}</h3>
                    <small>Transaksi Selesai</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm" style="height: 100px; flex-direction: row; align-items: center; padding: 0 20px;">
                    <div style="width: 80px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Perbandingan Penjualan</h6>
                        <small class="text-muted">Coffee: <b>{{ $coffeeCount }}</b> | Non-Coffee: <b>{{ $nonCoffeeCount }}</b></small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h5 class="mb-3 fw-bold text-dark">⭐ Ulasan Pelanggan Terbaru</h5>
                <div class="row">
                    @forelse($feedbacks as $fb)
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-light rounded h-100 border">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>{{ $fb->customer_name }}</strong>
                                <span class="text-warning" style="letter-spacing: 2px;">
                                    @for($i=0; $i<$fb->rating; $i++) ★ @endfor
                                </span>
                            </div>
                            <p class="small text-muted mb-0 fst-italic">"{{ $fb->message }}"</p>
                            <small class="text-secondary mt-2 d-block" style="font-size: 10px;">
                                {{ $fb->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted small py-3">Belum ada ulasan masuk hari ini.</div>
                    @endforelse
                </div>
            </div>
        </div>
        <h4 class="mb-3 text-warning fw-bold">🔥 Pesanan Masuk ({{ count($pendingOrders) }})</h4>
        
        @if(count($pendingOrders) == 0)
            <div class="alert alert-info text-center">Belum ada pesanan baru. Santai dulu sejenak... ☕</div>
        @endif

        <div class="row">
            @foreach($pendingOrders as $order)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm card-order h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <strong>{{ $order->customer_name }}</strong>
                        <span class="badge bg-warning text-dark">Meja: {{ $order->table_number }}</span>
                    </div>
                    
                    <div class="d-flex border-bottom bg-light">
                        <div class="w-50 p-2 border-end text-center">
                            <span class="img-label text-muted">📍 Lokasi</span>
                            @if($order->seat_image)
                                <a href="{{ asset('storage/' . $order->seat_image) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $order->seat_image) }}" class="seat-img" alt="Lokasi">
                                </a>
                            @else
                                <span class="small text-muted fst-italic">- Tidak ada foto -</span>
                            @endif
                        </div>

                        <div class="w-50 p-2 text-center">
                            <span class="img-label text-success">💰 Bukti Bayar</span>
                            @if($order->payment_proof)
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $order->payment_proof) }}" class="seat-img border border-success" alt="Bukti">
                                </a>
                            @else
                                <span class="small text-danger fw-bold">- Belum Upload -</span>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-3">
                            @foreach($order->items as $item)
                            <li class="list-group-item px-0 py-1 lh-sm">
                                <div class="d-flex justify-content-between">
                                    <span><b>{{ $item->quantity }}x</b> {{ $item->menu_name }}</span>
                                </div>
                                @if($item->note)
                                    <small class="text-danger fst-italic">"{{ $item->note }}"</small>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                        <div class="alert alert-secondary py-1 text-center small mb-0 fw-bold">
                            Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <form action="{{ route('admin.order.complete', $order->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success w-100 fw-bold btn-sm py-2">✅ Verifikasi & Selesai</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <hr class="my-5">

        <h4 class="mb-3 text-secondary">Riwayat Transaksi Terakhir</h4>
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>Pelanggan</th>
                                <th>Meja</th>
                                <th>Item</th>
                                <th>Total</th>
                                <th>Bukti</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedOrders->take(10) as $order)
                            <tr>
                                <td>{{ $order->updated_at->format('d M H:i') }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->table_number }}</td>
                                <td>
                                    @foreach($order->items as $item)
                                        <span class="badge bg-light text-dark border">{{ $item->quantity }}x {{ $item->menu_name }}</span>
                                    @endforeach
                                </td>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>
                                    @if($order->payment_proof)
                                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        const ctx = document.getElementById('salesChart');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Coffee', 'Non-Coffee'],
                datasets: [{
                    data: [{{ $coffeeCount }}, {{ $nonCoffeeCount }}],
                    backgroundColor: ['#6f4e37', '#ffc107'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    </script>
</body>
</html>