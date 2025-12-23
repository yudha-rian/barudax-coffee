<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <h2 class="mb-4 text-center">Konfirmasi Pesanan</h2>

        <div class="row">
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
                        <span class="text-muted">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-center">Keranjang kosong</li>
                    @endforelse
                    
                    <li class="list-group-item d-flex justify-content-between fw-bold bg-white">
                        <span>Total (IDR)</span>
                        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </li>
                </ul>
            </div>

            <div class="col-md-7 order-md-1">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h4 class="mb-3">Informasi Pelanggan</h4>
                        
                        <form id="checkoutForm" action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Nama Pemesan</label>
                                <input type="text" name="customer_name" class="form-control" placeholder="Masukkan nama Anda" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor Meja / Lokasi Duduk</label>
                                <input type="text" name="table_number" class="form-control" placeholder="Contoh: Meja 5" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto Lokasi (Opsional)</label>
                                <input type="file" name="seat_image" class="form-control" accept="image/*">
                            </div>

                            <hr class="my-4">

                            <h4 class="mb-3 text-primary">Pembayaran (QRIS)</h4>
                            <div class="alert alert-info d-flex align-items-center">
                                <div>Silakan scan QRIS di bawah ini untuk membayar. Total: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></div>
                            </div>

                            <div class="text-center mb-3">
                                <img src="{{ asset('img/qris.jpg') }}" alt="QRIS Code" style="width: 200px; border: 2px solid #ddd; border-radius: 10px;">
                                <p class="small text-muted mt-1">Scan menggunakan GoPay, OVO, Dana, atau BCA Mobile</p>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                                <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                                <div class="form-text">Pesanan tidak akan diproses tanpa bukti pembayaran.</div>
                            </div>

                            <button type="button" onclick="confirmSubmit()" class="w-100 btn btn-primary btn-lg">
                                ✅ Kirim Pesanan & Bukti
                            </button>
                            <a href="/" class="btn btn-link w-100 mt-2">Kembali ke Menu</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmSubmit() {
            Swal.fire({
                title: 'Sudah yakin?',
                text: "Pastikan data dan bukti pembayaran sudah benar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kirim Sekarang!',
                cancelButtonText: 'Cek Lagi'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading saat proses kirim
                    Swal.fire({
                        title: 'Mengirim Pesanan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit form secara manual
                    document.getElementById('checkoutForm').submit();
                }
            })
        }
    </script>
</body>
</html>