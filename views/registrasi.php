<?php
$message = "";
$status = "";

if (isset($_POST['register'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 
    
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $cek_email = mysqli_query($conn, "SELECT email_user FROM users WHERE email_user = '$email'");
    
    if (mysqli_num_rows($cek_email) > 0) {
        $message = "Email sudah digunakan!";
        $status  = "error";
    } else {
        $query = "INSERT INTO users (nama_user, email_user, password_user) 
                  VALUES ('$nama', '$email', '$password_hash')";
        
        if (mysqli_query($conn, $query)) {
            $message = "Registrasi Berhasil! Silakan Login.";
            $status  = "success";
        } else {
            $message = "Gagal mendaftar: " . mysqli_error($conn);
            $status  = "error";
        }
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
    <title>Daftar Akun</title>
</head>
<body>
<div class="login__container">
        <form action="" method="POST" class="login__form">
            <div style="text-align: center; margin-bottom: 1rem;">
                <img src="assets/img/log.svg" alt="logo" style="width: 60px;">
                <h3 class="app__name">MyWebinar</h3>
            </div>
            
            <h2 class="login__title">Daftar Akun</h2>

            <?php if($message): ?>
                <p class="login__error" style="color: <?= $status == 'success' ? '#27ae60' : '#e74c3c' ?>;">
                    <?= $message ?>
                </p>
            <?php endif; ?>

            <div class="login__group">
                <input type="text" name="nama" class="login__input" placeholder="Nama Lengkap" required>
            </div>

            <div class="login__group">
                <input type="email" name="email" class="login__input" placeholder="Alamat Email" required>
            </div>

            <div class="login__group" style="position: relative;">
                <input type="password" name="password" id="reg-pass" class="login__input" placeholder="Buat Kata Sandi" required>
                <i class="ri-eye-off-line login__eye" id="reg-eye" style="position: absolute; right: 15px; top: 38%; cursor: pointer; color: #775CA7;"></i>
            </div>

            <div class="login__check">
                <div class="login__check-group">
                    <input type="checkbox" class="login__check-input" id="reg-check" required>
                    <label for="reg-check" class="login__check-label">Saya setuju dengan Syarat & Ketentuan</label>
                </div>
            </div>

            <button type="submit" name="register" class="login__button">Daftar</button>

            <p class="login__signup">
                <a href="login">Masuk</a>
            </p>
        </form>
    </div>
    <script src=".../js/auth.js"></script>
</body>
</html>