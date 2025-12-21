<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beri Masukan - Barudax Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .feedback-card { max-width: 500px; width: 100%; border-radius: 15px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        
        /* CSS Magic untuk Rating Bintang */
        .rating { display: flex; flex-direction: row-reverse; justify-content: center; gap: 10px; }
        .rating input { display: none; }
        .rating label { cursor: pointer; font-size: 40px; color: #ddd; transition: 0.2s; }
        /* Saat di-hover atau dipilih, warnanya jadi kuning */
        .rating input:checked ~ label,
        .rating label:hover,
        .rating label:hover ~ label { color: #ffc107; }
    </style>
</head>
<body>

    <div class="card feedback-card p-4">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark">📣 Suara Pelanggan</h2>
            <p class="text-muted">Bantu kami menyajikan kopi yang lebih baik.</p>
        </div>

        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold small">Nama Anda (Opsional)</label>
                <input type="text" name="customer_name" class="form-control bg-light" placeholder="Boleh dikosongkan">
            </div>

            <div class="mb-3 text-center">
                <label class="form-label fw-bold small d-block">Seberapa puas Anda?</label>
                <div class="rating">
                    <input type="radio" name="rating" id="star5" value="5"><label for="star5">★</label>
                    <input type="radio" name="rating" id="star4" value="4"><label for="star4">★</label>
                    <input type="radio" name="rating" id="star3" value="3"><label for="star3">★</label>
                    <input type="radio" name="rating" id="star2" value="2"><label for="star2">★</label>
                    <input type="radio" name="rating" id="star1" value="1"><label for="star1">★</label>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small">Saran / Kritik</label>
                <textarea name="message" class="form-control bg-light" rows="4" placeholder="Ceritakan pengalamanmu di sini..." required></textarea>
            </div>

            <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">🚀 Kirim Masukan</button>
            <div class="text-center mt-3">
                <a href="/" class="text-decoration-none small text-muted">Batal, kembali ke menu</a>
            </div>
        </form>
    </div>

</body>
</html>