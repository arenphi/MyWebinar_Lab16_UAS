<?php
// Ambil data user login untuk foto profil
$foto_profil = "default.png";

if(isset($_SESSION['id_user'])){
    $id_log = $_SESSION['id_user'];
    $query_user = mysqli_query($conn, "SELECT foto_user FROM users WHERE id_user = '$id_log'");
    $data_user = mysqli_fetch_assoc($query_user);
    if(!empty($data_user['foto_user'])) {
        $foto_profil = $data_user['foto_user'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyWebinar</title>
    <link rel="icon" type="image/png" href="/assets/img/log.svg">
    
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/beranda.css">
    <link rel="stylesheet" href="/assets/css//mobile_style.css">
    <link rel="stylesheet" href="/assets/css/profil.css">
    <link rel="stylesheet" href="/assets/css/ikon.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>

<header class="header">
   <nav class="nav container">
      <div class="nav__data">
         <a href="beranda" class="nav__logo">
            <img src="assets/img/log.svg" alt="logo" id="logo">
            <h2 class="appname">MyWebinar</h2>
         </a>
         
         <div class="nav__toggle" id="nav-toggle">
            <i class="ri-menu-line nav__burger"></i>
            <i class="ri-close-line nav__close"></i>
         </div>

         <form action="beranda" method="GET" class="nav__search">
            <input type="text" name="search" placeholder="Cari webinar..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit"><i class="ri-search-line"></i></button>
         </form>
      </div>
   
      <div class="nav__menu" id="nav-menu">
         <ul class="nav__list">
</section>

   <li>
      <a href="beranda" class="nav__link">
         <span>Beranda</span>
      </a>
   </li>

   <li>
      <a href="diskusi" class="nav__link">
         <span>Diskusi</span>
      </a>
   </li>

<?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
<li>
   <a href="admin" class="nav__link" style="color: var(--purple-color); font-weight: bold;">
      <i class="ri-admin-line"></i>
      <span>Dashboard Admin</span>
   </a>
</li>
<?php endif; ?>

   <?php if(isset($_SESSION['id_user'])): ?>
   <li>
      <a href="#" class="nav__link" id="open-modal">
         <i class="ri-add-circle-fill" style="color: #f5f5f5; font-size: 2.2rem;"></i>
         <span>Buat</span>
      </a>
   </li>
   <?php endif; ?>

   <?php if(isset($_SESSION['id_user'])): ?>
   <li>
      <a href="profil" class="nav__link">
         <img src="uploads/profil/<?= $foto_profil ?>" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
         <span>Profil</span>
      </a>
   </li>
   <?php else: ?>
   <li>
      <a href="login" class="nav__link">
         <i class="ri-user-line"></i>
         <span>Login</span>
      </a>
   </li>
   <?php endif; ?>
</ul>
      </div>
   </nav>
</header>

<style>
.nav__img-profile {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid #ddd;
    background-color: #eee;
}
@media screen and (max-width: 1118px) {
    .nav__profile-item { flex-direction: row; justify-content: flex-start; }
    .nav__img-profile { width: 35px; height: 35px; }
}
</style>