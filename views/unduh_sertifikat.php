<?php
session_start();
include 'includes/koneksi.php';

// 1. Validasi Akses
if (!isset($_GET['id_webinar']) || !isset($_SESSION['id_user'])) {
    die("Akses ditolak. Silakan login kembali.");
}

$id_webinar = mysqli_real_escape_string($conn, $_GET['id_webinar']);
$id_user = $_SESSION['id_user'];

// 2. Query Data
$query = "SELECT p.nama_peserta, w.template_sertifikat 
          FROM pendaftaran p 
          JOIN webinar w ON p.id_webinar = w.id_webinar 
          WHERE p.id_webinar = '$id_webinar' AND p.id_user = '$id_user'";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data pendaftaran tidak ditemukan.");
}

// 3. Konfigurasi Path
$imgPath = "uploads/sertifikat/" . $data['template_sertifikat'];

// PATH FONT REVISI: Menggunakan realpath agar absolut
$fontPath = realpath("assets/font/GreatVibes-Regular.ttf");

if (!$fontPath || !file_exists($fontPath)) {
    // Coba path alternatif jika file di dalam subfolder
    $fontPath = realpath("../assets/font/GreatVibes-Regular.ttf");
}

if (!$fontPath) {
    die("Error: File Font tidak ditemukan. Pastikan file ada di assets/font/GreatVibes-Regular.ttf");
}

if (!file_exists($imgPath)) {
    die("Error: File template tidak ditemukan.");
}

// 4. Proses Gambar
$extension = strtolower(pathinfo($imgPath, PATHINFO_EXTENSION));
$image = ($extension == 'png') ? imagecreatefrompng($imgPath) : imagecreatefromjpeg($imgPath);

// Aktifkan Antialiasing agar font halus
imagealphablending($image, true);

// Warna Biru Tua
$color = imagecolorallocate($image, 21, 67, 120); 

$namaText = ucwords(strtolower($data['nama_peserta']));
$fontSize = 80; // Kecilkan sedikit agar tidak pecah/out of bounds

// Logika Center Alignment
$type_space = imagettfbbox($fontSize, 0, $fontPath, $namaText);
$text_width = abs($type_space[4] - $type_space[0]);
$image_width = imagesx($image);
$image_height = imagesy($image);

$x = ($image_width - $text_width) / 2; 
$y = ($image_height / 2) - 50; // Sesuaikan posisi Y sesuai kebutuhan template

// Tulis Teks
imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $namaText);

// 5. Output sebagai PNG
ob_clean(); // Bersihkan buffer agar tidak ada karakter sampah yang merusak gambar
header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="Sertifikat_'.str_replace(' ', '_', $namaText).'.png"');

imagepng($image);
imagedestroy($image);
exit;
?>