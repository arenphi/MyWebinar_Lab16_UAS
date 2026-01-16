<?php
// Konfigurasi Database
$host = "sql202.infinityfree.com";    // Nama host (biasanya localhost)
$user = "if0_40851716";         // Username database (default XAMPP: root)
$pass = "lbJbk5QWliM";             // Password database (default XAMPP: kosong)
$db   = "if0_40851716_mywebinar";    // Nama database yang Anda buat di MySQL

// Membuat Koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek Koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set timezone agar waktu pendaftaran akurat
date_default_timezone_set('Asia/Jakarta');
?>