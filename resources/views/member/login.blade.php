<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Member - Barudax Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
        }
        .card-header {
            background-color: #6f4e37;
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        .btn-coffee {
            background-color: #6f4e37;
            color: white;
            border: none;
        }
        .btn-coffee:hover {
            background-color: #5a3e2b;
            color: white;
        }
    </style>
</head>
<body>

    <div class="login-card bg-white">
        <div class="card-header">
            <h4 class="mb-0 fw-bold">☕ Barudax Member</h4>
            <small>Masuk untuk kumpulkan poin!</small>
        </div>
        <div class="card-body p-4">
            
            <form action="/member/login" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" value="member@kopi.com" readonly>
                    <div class="form-text text-success">
                        *Demo: Email ini otomatis terisi
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" value="password" readonly>
                    <div class="form-text text-success">
                        *Demo: Password otomatis terisi
                    </div>
                </div>

                <button type="submit" class="btn btn-coffee w-100 py-2 fw-bold">
                    🚀 Masuk Sekarang
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="/" class="text-decoration-none small text-muted">← Kembali ke Menu Utama</a>
            </div>
        </div>
    </div>

</body>
</html>