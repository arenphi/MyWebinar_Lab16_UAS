// Query dasar untuk lihat_peserta.php
$id_w = $_GET['id'];
$q = "SELECT pendaftaran.*, users.nama_user 
      FROM pendaftaran 
      JOIN users ON pendaftaran.id_user = users.id_user 
      WHERE id_webinar = '$id_w'";