<?php
// views/logout.php

// Menghapus semua data session
$_SESSION = array();

// Menghapus cookie session jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Menghancurkan session
session_destroy();

// Redirect menggunakan clean URL (sesuai .htaccess)
header("Location: beranda");
exit;