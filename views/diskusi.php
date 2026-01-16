<?php 

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Query untuk mengambil diskusi hanya dari webinar yang didaftari (pendaftaran) oleh user
$query_diskusi = "SELECT d.*, u.nama_user, u.foto_user, w.judul_webinar, w.id_webinar 
                  FROM diskusi d
                  JOIN users u ON d.id_user = u.id_user
                  JOIN webinar w ON d.id_webinar = w.id_webinar
                  JOIN pendaftaran p ON w.id_webinar = p.id_webinar
                  WHERE p.id_user = '$id_user'
                  ORDER BY d.tgl_kirim DESC";

$res_diskusi = mysqli_query($conn, $query_diskusi);
?>


<main class="container main" style="margin-top: 2rem;">
    <h2 style="margin-bottom: 1.5rem;"><i class="ri-chat-3-line"></i> Diskusi Webinar Saya</h2>
    
    <div class="diskusi__container" style="display: flex; flex-direction: column; gap: 1.5rem;">
        <?php if(mysqli_num_rows($res_diskusi) > 0): ?>
            <?php while($d = mysqli_fetch_assoc($res_diskusi)): ?>
                <div class="info__card" style="padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: #fff;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <?php $foto = !empty($d['foto_user']) ? $d['foto_user'] : 'default.png'; ?>
                            <img src="uploads/profil/<?= $foto ?>" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            <div>
                                <strong style="display: block; font-size: 0.95rem;"><?= $d['nama_user'] ?></strong>
                                <small style="color: #888;"><?= date('H:i, d M Y', strtotime($d['tgl_kirim'])) ?></small>
                            </div>
                        </div>
                        <a href="detail.php?id=<?= $d['id_webinar'] ?>" style="font-size: 0.75rem; background: #f0f0f0; padding: 5px 10px; border-radius: 20px; color: var(--purple-color); font-weight: 600; text-decoration: none;">
                            <?= $d['judul_webinar'] ?>
                        </a>
                    </div>
                    <p style="color: #444; line-height: 1.5; margin-left: 50px;">
                        <?= nl2br(htmlspecialchars($d['pesan'])) ?>
                    </p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="text-center" style="padding: 3rem; color: #999;">
                <i class="ri-chat-off-line" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></i>
                <p>Belum ada diskusi di webinar yang Anda ikuti.</p>
            </div>
        <?php endif; ?>
    </div>
</main>
