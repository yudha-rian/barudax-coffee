<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Area - Barudax Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .loyalty-card {
            background: linear-gradient(135deg, #6f4e37 0%, #3e2b1f 100%);
            color: gold;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            margin-bottom: 30px;
        }
        .points-big { font-size: 3rem; font-weight: bold; }
        .stamp-box {
            width: 50px; height: 50px;
            border: 2px dashed #6f4e37;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 5px;
            font-size: 20px;
            color: #ccc;
        }
        .stamp-active {
            background-color: #6f4e37;
            border: 2px solid #6f4e37;
            color: white;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <span class="navbar-brand fw-bold">☕ Member Area</span>
            <a href="/" class="btn btn-outline-dark btn-sm">Kembali ke Menu</a>
        </div>
    </nav>

    <div class="container" style="max-width: 600px;">

        <div class="loyalty-card text-center position-relative">
            <h4 class="mb-4 text-white text-uppercase tracking-wide">Barudax Priority Card</h4>
            
            <div class="mb-3">
                <span class="text-white opacity-75">Saldo Poin Anda</span>
                <div class="points-big">{{ $user->points }}</div>
                <small class="text-white">Level: 
                    @if($user->points > 100) 🥇 Gold Member @else 🥈 Silver Member @endif
                </small>
            </div>

            <div class="mt-4 pt-3 border-top border-secondary text-start">
                <small class="text-white opacity-50">Nama Member</small>
                <div class="fs-5 text-white">{{ $user->name }}</div>
            </div>
        </div>

        <h5 class="fw-bold mb-3">🎁 Tukar Poin (Rewards)</h5>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <div>
                        <strong>Gratis 1 Kopi Americano</strong>
                        <div class="small text-muted">Tukar 50 Poin</div>
                    </div>
                    @if($user->points >= 50)
                        <button class="btn btn-sm btn-primary">Klaim</button>
                    @else
                        <button class="btn btn-sm btn-secondary" disabled>Kurang Poin</button>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Diskon 50% All Item</strong>
                        <div class="small text-muted">Tukar 100 Poin</div>
                    </div>
                    @if($user->points >= 100)
                        <button class="btn btn-sm btn-primary">Klaim</button>
                    @else
                        <button class="btn btn-sm btn-secondary" disabled>Kurang Poin</button>
                    @endif
                </div>
            </div>
        </div>

        <h5 class="fw-bold mb-3">🏅 Progress Stempel</h5>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body text-center">
                <p class="small text-muted">Kumpulkan 10 transaksi untuk hadiah kejutan!</p>
                <div class="d-flex flex-wrap justify-content-center">
                    @for($i = 1; $i <= 10; $i++)
                        <div class="stamp-box {{ count($history) >= $i ? 'stamp-active' : '' }}">
                            @if(count($history) >= $i) ☕ @else {{ $i }} @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <h5 class="fw-bold mb-3">📜 Riwayat Belanja</h5>
        <div class="list-group shadow-sm">
            @forelse($history as $order)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">{{ $order->created_at->format('d M Y') }}</div>
                        <small class="text-muted">Total: Rp {{ number_format($order->total_price) }}</small>
                    </div>
                    <span class="badge bg-success">+{{ floor($order->total_price / 10000) }} Poin</span>
                </div>
            @empty
                <div class="list-group-item text-center text-muted py-4">
                    Belum ada riwayat transaksi. Yuk pesan kopi!
                </div>
            @endforelse
        </div>

    </div>
    
    <div class="py-5"></div>
</body>
</html>