<?php
class MainController {
    public function render($page) {
        // Gunakan variabel koneksi global
        global $conn; 
        
        $viewPath = "views/" . $page . ".php";

        // MainController.php
$fullPage = ['login', 'registrasi', 'logout', 'hapus_webinar', 'proses_admin']; // Tambahkan 'logout' di sini
        
        if (file_exists($viewPath)) {
            $fullPage = ['login', 'registrasi'];

            if (in_array($page, $fullPage)) {
                require_once $viewPath;
            } else {
                require_once "includes/header.php";
                require_once $viewPath;
                require_once "includes/footer.php";
            }
        } else {
            // Jika halaman tidak ada, arahkan ke beranda atau 404
            require_once "includes/header.php";
            require_once "views/beranda";
            require_once "includes/footer.php";
        }
    }
}