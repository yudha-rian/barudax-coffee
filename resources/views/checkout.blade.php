<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 text-center">Konfirmasi Pesanan</h2>

    <div class="row">

        <!-- RINGKASAN KERANJANG -->
        <div class="col-md-5 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Keranjang Anda</span>
                <span class="badge bg-primary rounded-pill">{{ count($cart) }}</span>
            </h4>

            <ul class="list-group mb-3 shadow-sm">
                @forelse($cart as $item)
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">{{ $item['name'] }} (x{{ $item['quantity'] }})</h6>
                            <small class="text-muted">{{ $item['note'] ?? '-' }}</small>
                        </div>
                        <span class="text-muted">
                            Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-center text-muted">
                        Keranjang kosong
                    </li>
                @endforelse

                <li class="list-group-item d-flex justify-content-between fw-bold">
                    <span>Total</span>
                    <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                </li>
            </ul>
        </div>

        <!-- FORM CHECKOUT -->
        <div class="col-md-7 order-md-1">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h4 class="mb-3">Informasi Pelanggan</h4>

                    <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Pemesan</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Meja / Lokasi Duduk</label>
                            <input type="text" name="table_number" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Lokasi (Opsional)</label>
                            <input type="file" name="seat_image" class="form-control" accept="image/*">
                        </div>

                        <hr class="my-4">

                        <h4 class="mb-3 text-primary">Pembayaran (QRIS)</h4>

                        <div class="alert alert-info">
                            Total pembayaran:
                            <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>

                        <div class="text-center mb-3">
                            <img src="{{ asset('img/qris.jpg') }}"
                                 alt="QRIS"
                                 style="width:200px;border-radius:10px;border:2px solid #ddd;">
                            <p class="small text-muted mt-2">
                                Scan via GoPay, OVO, Dana, BCA Mobile
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Upload Bukti Pembayaran <span class="text-danger">*</span>
                            </label>
                            <input type="file"
                                   name="payment_proof"
                                   class="form-control"
                                   accept="image/*"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            ✅ Kirim Pesanan & Bukti
                        </button>

                        <a href="/" class="btn btn-link w-100 mt-2">
                            ← Kembali ke Menu
                        </a>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
