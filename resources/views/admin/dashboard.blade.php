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
        .seat-img { width: 100%; height: 150px; object-fit: cover; border-radius: 5px; }
        .stat-card { border-radius: 10px; border: none; color: white; }
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
                    
                    @if($order->seat_image)
                    <div class="p-2">
                        <img src="{{ asset('storage/' . $order->seat_image) }}" class="seat-img" alt="Lokasi">
                    </div>
                    @endif

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
                        <div class="alert alert-secondary py-1 text-center small mb-0">
                            Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <form action="{{ route('admin.order.complete', $order->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success w-100 fw-bold">✅ Pesanan Siap!</button>
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