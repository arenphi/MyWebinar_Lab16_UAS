<?php
// Catatan: session_start() dan koneksi sudah dipanggil di index.php / Controller
// Cek jika sudah login, lempar ke beranda menggunakan clean URL
global $conn; 
    
if (isset($_SESSION['id_user'])) {
    header("Location: beranda");
    exit();
}

$error = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 

    // 1. Cari user berdasarkan email
    $query = "SELECT * FROM users WHERE email_user = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // 2. Verifikasi password hash
        if (password_verify($password, $row['password_user'])) {
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['nama_user'] = $row['nama_user'];
            // Tambahkan role jika ada di tabel users Anda (Misal: $_SESSION['role'] = $row['role'];)
            
            header("Location: beranda");
            exit();
        } else {
            $error = "Email atau Password salah!";
        }
    } else {
        $error = "Email atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/log.svg">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="login_style.css">
    <title>Login</title>
</head>
<body>
    <div class="login__container">
        <form action="" method="POST" class="login__form">
            <div style="text-align: center; margin-bottom: 1rem;">
                <img src="assets/img/log.svg" alt="logo" style="width: 60px;">
                <h3 class="app__name">MyWebinar</h3>
            </div>
            
            <h2 class="login__title">Masuk</h2>

            <?php if($error): ?>
                <p class="login__error" style="color: #e74c3c; text-align: center; font-size: 0.8rem; margin-bottom: 1rem;">
                    <?= $error; ?>
                </p>
            <?php endif; ?>

            <div class="login__group">
                <input type="email" name="email" class="login__input" placeholder="Nama Pengguna atau Email" required>
            </div>

            <div class="login__group" style="position: relative;">
                <input type="password" name="password" id="login-pass" class="login__input" placeholder="Kata Sandi" required>
                <i class="ri-eye-off-line login__eye" id="login-eye" style="position: absolute; right: 15px; top: 38%; cursor: pointer; color: #775CA7;"></i>
            </div>

            <div class="login__check">
                <div class="login__check-group">
                    <input type="checkbox" name="remember" class="login__check-input" id="login-check">
                    <label for="login-check" class="login__check-label">Biarkan saya tetap masuk</label>
                </div>
                <a href="#" class="login__forgot">Lupa Kata Sandi?</a>
            </div>

            <button type="submit" name="login" class="login__button">Masuk</button>

            <p class="login__signup">
                Belum punya akun? <a href="registrasi">Daftar Akun</a>
            </p>
            <p class="login__signup">
                <a href="beranda" style="color: #666;"><i class="ri-arrow-left-line"></i> Kembali ke Beranda</a>
            </p>
        </form>
    </div>
    <script src=".../assets/js/auth.js"></script>
</body>
</html>