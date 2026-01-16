<?php 

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// --- PROSES SIMPAN DATA WEBINAR (CRUD: CREATE) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_webinar'])) {
    $id_penyelenggara = $_SESSION['id_user']; 
    $judul = mysqli_real_escape_string($conn, $_POST['judul_webinar']);
    $narasumber = mysqli_real_escape_string($conn, $_POST['narasumber']); 
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tgl = $_POST['tgl_pelaksanaan'];
    $jam = $_POST['jam_pelaksanaan'];
    $kuota = $_POST['kuota'];
    $link_meeting = mysqli_real_escape_string($conn, $_POST['link_webinar']); 
    $sertifikat = $_POST['sertifikat'];
    
    $nama_poster = ""; $nama_cert = ""; $nama_latar = "";

    if (!file_exists("uploads/poster/")) mkdir("uploads/poster/", 0777, true);
    if (!file_exists("uploads/sertifikat/")) mkdir("uploads/sertifikat/", 0777, true);
    if (!file_exists("uploads/latar/")) mkdir("uploads/latar/", 0777, true);

    if (isset($_FILES['poster_file']) && $_FILES['poster_file']['error'] == 0) {
        $nama_poster = "poster_" . time() . "_" . uniqid() . "." . pathinfo($_FILES["poster_file"]["name"], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES["poster_file"]["tmp_name"], "uploads/poster/" . $nama_poster);
    }

    if ($sertifikat == 'Ya' && isset($_FILES['template_file']) && $_FILES['template_file']['error'] == 0) {
        $nama_cert = "cert_" . time() . "_" . uniqid() . "." . pathinfo($_FILES["template_file"]["name"], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES["template_file"]["tmp_name"], "uploads/sertifikat/" . $nama_cert);
    }

    if (isset($_FILES['latar_file']) && $_FILES['latar_file']['error'] == 0) {
        $nama_latar = "latar_" . time() . "_" . uniqid() . "." . pathinfo($_FILES["latar_file"]["name"], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES["latar_file"]["tmp_name"], "uploads/latar/" . $nama_latar);
    }

    $query_ins = "INSERT INTO webinar (id_penyelenggara, judul_webinar, narasumber, deskripsi, tgl_pelaksanaan, jam_pelaksanaan, kuota, link_webinar, poster_webinar, sertifikat, template_sertifikat, latar_belakang) 
                  VALUES ('$id_penyelenggara', '$judul', '$narasumber', '$deskripsi', '$tgl', '$jam', '$kuota', '$link_meeting', '$nama_poster', '$sertifikat', '$nama_cert', '$nama_latar')";
    
    if (mysqli_query($conn, $query_ins)) {
        header("Location: beranda.php?status=success");
        exit();
    }
}

// --- LOGIKA FILTER PENCARIAN & PAGINATION (SYARAT UAS) ---
$keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

// Pengaturan Pagination
$batas = 6; // Jumlah data per halaman
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Hitung total data untuk pagination (berdasarkan filter pencarian)
$query_hitung = "SELECT id_webinar FROM webinar WHERE judul_webinar LIKE '%$keyword%' OR narasumber LIKE '%$keyword%'";
$res_hitung = mysqli_query($conn, $query_hitung);
$jumlah_data = mysqli_num_rows($res_hitung);
$total_halaman = ceil($jumlah_data / $batas);

// Query Utama (Filter + Pagination)
$query_webinar = "SELECT webinar.*, users.nama_user, users.foto_user 
                  FROM webinar 
                  JOIN users ON webinar.id_penyelenggara = users.id_user 
                  WHERE webinar.judul_webinar LIKE '%$keyword%' 
                  OR webinar.narasumber LIKE '%$keyword%' 
                  ORDER BY webinar.id_webinar DESC 
                  LIMIT $halaman_awal, $batas";

$result = mysqli_query($conn, $query_webinar);
?>

<link rel="stylesheet" href="assets/css/pagination.css">
    <main class="main container main-content">
        <div class="modal" id="webinar-modal">
            <div class="modal__content">
                <h1 class="modal__title">Buat Webinar</h1><br>
                <form action="beranda.php" method="POST" enctype="multipart/form-data">
                    <div class="modal__group">
                        <label>Judul Webinar</label>
                        <input type="text" name="judul_webinar" required>
                    </div>
                    <div class="modal__flex-row">
                        <div class="modal__flex-item">
                            <label>Poster Webinar</label> <br>
                            <input type="file" name="poster_file" accept="image/*" required>
                        </div>
                        <div class="modal__flex-item">
                            <label>Latar Belakang (Virtual BG)</label>
                            <input type="file" name="latar_file" accept="image/*">
                        </div>
                    </div>
                    <div class="modal__group">
                        <label>Narasumber</label>
                        <input type="text" name="narasumber" required>
                    </div>
                    <div class="modal__group">
                        <label>Link Meeting (Zoom/GMeet)</label>
                        <input type="url" name="link_webinar" required>
                    </div>
                    <div class="modal__flex-row">
                        <div class="modal__flex-item">
                            <label>Tanggal</label>
                            <input type="date" name="tgl_pelaksanaan" class="ks" required>
                        </div>
                        <div class="modal__flex-item">
                            <label>Waktu</label>
                            <input type="time" name="jam_pelaksanaan" class="ks" required>
                        </div>
                    </div>
                    <div class="modal__flex-row">
                        <div class="modal__flex-item_ks">
                            <label>Kuota</label>
                            <input type="number" name="kuota" class="ks" required>
                        </div>
                        <div class="modal__flex-item_ks">
                            <label>Sertifikat</label>
                            <select name="sertifikat" class="ks" onchange="toggleCert(this.value)">
                                <option value="Tidak">Tidak</option>
                                <option value="Ya">Ya</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal__group_cert" id="cert-field" style="display:none;">
                        <label>Template Sertifikat (Gambar)</label>
                        <input type="file" name="template_file" accept="image/*">
                    </div>
                    <div class="modal__group_desc">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" rows="3" style="width:100%; padding:8px;"></textarea>
                    </div>
                    <div class="modal__buttons" style="display:flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" id="close-modal" class="btn--cancel" style="padding: 10px 20px; border-radius:5px; border:none; cursor:pointer;">Batal</button>
                        <button type="submit" name="submit_webinar" class="btn--submit" style="padding: 10px 20px; background:#775CA7; color:#fff; border-radius:5px; border:none; cursor:pointer;">Terbitkan</button>
                    </div>
                </form>
            </div>
        </div>

        <section class="webinar section">
            <?php if($keyword != ""): ?>
                <p style="margin-bottom: 1.5rem;">Hasil pencarian untuk: <b>"<?= htmlspecialchars($keyword) ?>"</b></p>
            <?php endif; ?>

            <div class="webinar__container grid">
                <?php if(mysqli_num_rows($result) > 0): 
                    while($row = mysqli_fetch_assoc($result)):
                        $foto_host = !empty($row['foto_user']) ? $row['foto_user'] : 'default.png';
                ?>
                <article class="webinar__card">
                    <a href="detail?id=<?= $row['id_webinar'] ?>" class="webinar__link-detail">
                        <div class="webinar__image">
                            <img src="uploads/poster/<?= $row['poster_webinar'] ?>" class="webinar__img" onerror="this.src='https://via.placeholder.com/640x360?text=Webinar'">
                            <?php if($row['sertifikat'] == 'Ya'): ?>
                                <span class="cert-badge">E-Sertifikat</span>
                            <?php endif; ?>
                        </div>
                    </a>
                    <div class="webinar__data">
                        <div class="webinar__avatar-wrapper">
                            <img src="uploads/profil/<?= $foto_host ?>" class="webinar__avatar-img">
                        </div>
                        <div class="webinar__text-container">
                            <h3 class="webinar__title"><?= $row['judul_webinar'] ?></h3>
                            <div class="webinar__organizer"><?= $row['nama_user'] ?></div>
                            <div class="webinar__info">
                                <span><?= date('d M Y', strtotime($row['tgl_pelaksanaan'])) ?> • <?= $row['jam_pelaksanaan'] ?></span>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endwhile; ?>
                <?php else: ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 4rem;">
                        <p>Webinar tidak ditemukan.</p>
                        <a href="beranda.php" style="color: blue;">Lihat semua webinar</a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($total_halaman > 1): ?>
<div class="pagination">
    <?php if($halaman > 1): ?>
        <a href="?search=<?= $keyword ?>&halaman=<?= $halaman - 1 ?>"><i class="ri-arrow-left-s-line"></i></a>
    <?php endif; ?>

    <?php for($x=1; $x<=$total_halaman; $x++): ?>
        <a href="?search=<?= $keyword ?>&halaman=<?= $x ?>" class="<?= ($halaman == $x) ? 'active' : '' ?>">
            <?= $x ?>
        </a>
    <?php endfor; ?>

    <?php if($halaman < $total_halaman): ?>
        <a href="?search=<?= $keyword ?>&halaman=<?= $halaman + 1 ?>"><i class="ri-arrow-right-s-line"></i></a>
    <?php endif; ?>
</div>
<?php endif; ?>
        </section>
    </main>

    <script src="assets/js/main.js"></script>
    <script>
        function toggleCert(v) {
            document.getElementById('cert-field').style.display = (v === 'Ya') ? 'block' : 'none';
        }
    </script>
