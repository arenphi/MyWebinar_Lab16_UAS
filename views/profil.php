<?php

if (!isset($_SESSION['id_user'])) { 
    header("Location: login"); 
    exit; 
}

$id_user = $_SESSION['id_user'];

// 1. PROSES UPDATE PROFIL
if (isset($_POST['save_profile'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_user']);
    $foto_lama = $_POST['foto_lama'];
    $foto_nama = $foto_lama;

    if ($_FILES['foto']['error'] === 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_nama = "profile_" . $id_user . "_" . time() . "." . $ext;
        if (!file_exists("uploads/profil/")) mkdir("uploads/profil/", 0777, true);
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/profil/" . $foto_nama);
    }

    mysqli_query($conn, "UPDATE users SET nama_user='$nama', foto_user='$foto_nama' WHERE id_user='$id_user'");
    $_SESSION['nama_user'] = $nama;
    header("Location: profil?status=updated"); exit;
}

// 2. PROSES HAPUS WEBINAR
if (isset($_GET['delete_webinar'])) {
    $id_del = mysqli_real_escape_string($conn, $_GET['delete_webinar']);
    $check = mysqli_query($conn, "SELECT id_webinar FROM webinar WHERE id_webinar = '$id_del' AND id_penyelenggara = '$id_user'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "DELETE FROM webinar WHERE id_webinar = '$id_del'");
        header("Location: profil?status=deleted"); exit;
    }
}

// AMBIL DATA USER
$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id_user'"));

// AMBIL WEBINAR YANG DISALURKAN (HITUNG PESERTA)
$my_webinars = mysqli_query($conn, "SELECT w.*, (SELECT COUNT(*) FROM pendaftaran p WHERE p.id_webinar = w.id_webinar) as total_peserta 
    FROM webinar w 
    WHERE w.id_penyelenggara = '$id_user' 
    ORDER BY w.tgl_pelaksanaan DESC");

// AMBIL WEBINAR YANG DIIKUTI
$my_participations = mysqli_query($conn, "SELECT p.*, w.judul_webinar, w.sertifikat as cetak_aktif 
    FROM pendaftaran p 
    JOIN webinar w ON p.id_webinar = w.id_webinar 
    WHERE p.id_user = '$id_user'");
?>
    
    <main class="main-content">
        <div class="container">
            <div class="profile__header card">
                <div class="profile__img-wrapper">
                    <img src="uploads/profil/<?= $u['foto_user'] ? $u['foto_user'] : 'default.png' ?>" class="profile__img">
                </div>
                <div class="profile__info">
                    <h2 class="profile__name"><?= $u['nama_user'] ?></h2>
                    <p class="profile__email"><?= $u['email_user'] ?></p>
                </div>
            </div>

            <div class="profile__tabs">
                <div class="tab__nav card">
                    <button class="tab__btn active" onclick="openTab(event, 'edit-profil')">
                        <i class="ri-user-settings-line"></i> <span>Pengaturan</span>
                    </button>
                    <button class="tab__btn" onclick="openTab(event, 'webinar-saya')">
                        <i class="ri-video-chat-line"></i> <span>Webinar Saya</span>
                    </button>
                    <button class="tab__btn" onclick="openTab(event, 'sertifikat-saya')">
                        <i class="ri-award-line"></i> <span>Sertifikat</span>
                    </button>
                </div>

                <div id="edit-profil" class="tab__content active">
                    <div class="card">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="foto_lama" value="<?= $u['foto_user'] ?>">
                            <div class="modal__group">
                                <label>Ganti Foto Profil</label>
                                <input type="file" name="foto">
                            </div>
                            <div class="modal__group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_user" value="<?= $u['nama_user'] ?>" required>
                            </div>
                            <button type="submit" name="save_profile" class="btn--submit">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>

                <div id="webinar-saya" class="tab__content">
                    <div class="card table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Webinar</th>
                                    <th class="text-center">Peserta</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($my_webinars) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($my_webinars)): ?>
                                    <tr>
                                        <td>
                                            <div class="webinar-cell">
                                                <span class="webinar-title"><?= $row['judul_webinar'] ?></span>
                                                <span class="webinar-date"><?= date('d M Y', strtotime($row['tgl_pelaksanaan'])) ?></span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="data_peserta?id=<?= $row['id_webinar'] ?>" class="badge-peserta">
                                                <i class="ri-group-line"></i> <?= $row['total_peserta'] ?>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="edit?id=<?= $row['id_webinar'] ?>" class="btn-icon edit" title="Edit"><i class="ri-edit-line"></i></a>
                                                <a href="profil?delete_webinar=<?= $row['id_webinar'] ?>" class="btn-icon delete" onclick="return confirm('Hapus webinar ini?')" title="Hapus"><i class="ri-delete-bin-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center">Belum ada webinar yang dibuat.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="sertifikat-saya" class="tab__content">
                    <div class="card table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Webinar yang Diikuti</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($my_participations) > 0): ?>
                                    <?php while($part = mysqli_fetch_assoc($my_participations)): ?>
                                    <tr>
                                        <td><?= $part['judul_webinar'] ?></td>
                                        <td class="text-center">
                                            <?php if($part['cetak_aktif'] == 'Ya'): ?>
                                                <a href="unduh_sertifikat?id_webinar=<?= $part['id_webinar'] ?>" target="_blank" class="btn-download">
                                                    <i class="ri-download-cloud-line"></i> Unduh
                                                </a>
                                            <?php else: ?>
                                                <span class="status-disabled">Belum tersedia</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="2" class="text-center">Belum mengikuti webinar.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <a href="logout" class="logout-link">
                <i class="ri-logout-box-line"></i> Keluar Aplikasi
            </a>
        </div>
    </main>

    <script>
    function openTab(evt, tabName) {
        var i, content, tablinks;
        content = document.getElementsByClassName("tab__content");
        for (i = 0; i < content.length; i++) { content[i].style.display = "none"; }
        tablinks = document.getElementsByClassName("tab__btn");
        for (i = 0; i < tablinks.length; i++) { tablinks[i].className = tablinks[i].className.replace(" active", ""); }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    </script>