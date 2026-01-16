<?php
// Ambil data user login untuk foto profil
$foto_profil = "default.png";
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: beranda");
    exit();
}

if(isset($_SESSION['id_user'])){
    $id_log = $_SESSION['id_user'];
    $query_user = mysqli_query($conn, "SELECT foto_user FROM users WHERE id_user = '$id_log'");
    $data_user = mysqli_fetch_assoc($query_user);
    if(!empty($data_user['foto_user'])) {
        $foto_profil = $data_user['foto_user'];
    }
}
?>

<main class="main container">
    <section class="section">
        <h2 class="section__title">Panel Kendali Admin</h2>
        
        <div class="admin__container" style="overflow-x: auto; background: var(--container-color); padding: 1.5rem; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--purple-color); text-align: left;">
                        <th style="padding: 12px;">ID</th>
                        <th style="padding: 12px;">Judul Webinar</th>
                        <th style="padding: 12px;">Narasumber</th>
                        <th style="padding: 12px;">Tanggal</th>
                        <th style="padding: 12px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $query_admin = mysqli_query($conn, "SELECT * FROM webinar ORDER BY id_webinar DESC");
                    while($row = mysqli_fetch_assoc($query_admin)): 
                    ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px;"><?= $row['id_webinar'] ?></td>
                        <td style="padding: 12px; font-weight: 500;"><?= $row['judul_webinar'] ?></td>
                        <td style="padding: 12px;"><?= $row['narasumber'] ?></td>
                        <td style="padding: 12px;"><?= date('d/m/Y', strtotime($row['tgl_pelaksanaan'])) ?></td>
                        <td style="padding: 12px;">
                            <div style="display: flex; gap: 10px;">
                                <a href="hapus_webinar?id=<?= $row['id_webinar'] ?>" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus webinar ini?')"
                                   style="color: #e74c3c; font-size: 1.2rem;" title="Hapus">
                                   <i class="ri-delete-bin-line"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>