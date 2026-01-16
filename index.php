<?php
// Memanggil Controller Utama
session_start();
require_once "includes/koneksi.php"; // Panggil koneksi di sini
require_once 'controllers/MainController.php';

$app = new MainController();

// Mengambil parameter 'url' yang dikirim oleh .htaccess
// Jika kosong, arahkan ke 'beranda'
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'beranda';

// Routing Sederhana
switch ($url) {

    case 'beranda':
        $app->render('beranda');
        break;

    case 'admin':
        $app->render('admin_dashboard');
        break;
    
    case 'hapus_webinar':
        $app->render('hapus_webinar'); // Buat file ini untuk logika delete
        break;

    case 'diskusi':
        $app->render('diskusi');
        break;

    case 'logout':
        $app->render('logout'); // Ini akan memanggil views/logout.php
        break;
        
    case 'login':
        $app->render('login');
        break;
        
    case 'registrasi':
        $app->render('registrasi');
        break;

    case 'profil':
        $app->render('profil');
        break;

    case 'edit':
        $app->render('edit');
        break;

    case 'data_peserta':
        $app->render('data_peserta');
        break;

    case 'unduh_sertifikat':
        $app->render('unduh_sertifikat');
        break;

    case 'detail':
        $app->render('detail');
        break;

    default:
        $app->render('beranda');
        break;
}