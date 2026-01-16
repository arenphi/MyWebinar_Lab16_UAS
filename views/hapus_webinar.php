<?php
// Pastikan hanya admin yang bisa menghapus
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: beranda");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Ambil nama file gambar agar bisa dihapus dari folder (Clean Up)
    $query_file = mysqli_query($conn, "SELECT poster_webinar, template_sertifikat FROM webinar WHERE id_webinar = '$id'");
    $data = mysqli_fetch_assoc($query_file);

    // 2. Hapus file fisik jika ada
    if($data['poster_webinar']) @unlink("uploads/poster/" . $data['poster_webinar']);
    if($data['template_sertifikat']) @unlink("uploads/sertifikat/" . $data['template_sertifikat']);

    // 3. Hapus data dari database
    $delete = mysqli_query($conn, "DELETE FROM webinar WHERE id_webinar = '$id'");

    if ($delete) {
        header("Location: admin?status=deleted");
    } else {
        echo "<script>alert('Gagal menghapus data'); window.location='admin';</script>";
    }
}