<?php
session_start();
include 'includes/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
    exit();
}

if (isset($_POST['daftar'])) {
    // Ambil data dari form dan bersihkan untuk keamanan (SQL Injection)
    $id_webinar = mysqli_real_escape_string($conn, $_POST['id_webinar']);
    $id_user    = $_SESSION['id_user']; // Mengambil ID dari session login
    $nama       = mysqli_real_escape_string($conn, $_POST['nama_peserta']);
    $status     = mysqli_real_escape_string($conn, $_POST['status_peserta']);
    
    // Jika status Mahasiswa, ambil nama universitas. Jika tidak, beri tanda strip (-)
    $univ       = ($status == 'Mahasiswa') ? mysqli_real_escape_string($conn, $_POST['universitas']) : '-';
    $wa         = mysqli_real_escape_string($conn, $_POST['no_telp']);

    // Cek apakah user sudah mendaftar di webinar yang sama sebelumnya
    $cek = mysqli_query($conn, "SELECT * FROM pendaftaran WHERE id_user = '$id_user' AND id_webinar = '$id_webinar'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Anda sudah terdaftar di webinar ini!'); window.location='beranda.php';</script>";
        exit();
    }

    // Query INSERT sesuai struktur database terbaru
    $query = "INSERT INTO pendaftaran (id_user, id_webinar, nama_peserta, status_peserta, universitas, no_telp, tgl_daftar) 
              VALUES ('$id_user', '$id_webinar', '$nama', '$status', '$univ', '$wa', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pendaftaran Berhasil!'); window.location='beranda.php';</script>";
    } else {
        // Menampilkan error jika query gagal (untuk debugging)
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Jika mencoba akses file ini langsung tanpa tombol daftar
    header("Location: beranda.php");
    exit();
}
?>