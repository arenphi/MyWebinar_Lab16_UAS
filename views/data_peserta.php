<?php

global $conn;

if (!isset($_SESSION['id_user'])) { 
    header("Location: login"); 
    exit; }
$id_user = $_SESSION['id_user'];

// Ambil semua webinar yang dibuat oleh user ini
$query_webinar = mysqli_query($conn, "SELECT id_webinar, judul_webinar FROM webinar WHERE id_penyelenggara = '$id_user' ORDER BY tgl_pelaksanaan DESC");
?>

<link rel="stylesheet" href="assets/css/data_peserta.css">
    <main class="main-content">
        <div class="container">
            <h2 style="margin-bottom: 2rem;">Manajemen Peserta</h2>

            <?php if(mysqli_num_rows($query_webinar) > 0): ?>
                <?php while($webinar = mysqli_fetch_assoc($query_webinar)): 
                    $id_w = $webinar['id_webinar'];
                    // Ambil peserta khusus untuk webinar ini
                    $res_peserta = mysqli_query($conn, "SELECT * FROM pendaftaran WHERE id_webinar = '$id_w' ORDER BY nama_peserta ASC");
                    $total = mysqli_num_rows($res_peserta);
                ?>
                
                <section class="webinar-section">
                    <div class="webinar-title-box">
                        <span class="title"><strong><?= $webinar['judul_webinar'] ?></strong></span>
                        <span class="count-badge"><?= $total ?> Peserta</span>
                    </div>

                    <div class="table-container table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Peserta</th>
                                    <th>Status</th>
                                    <th>Instansi</th>
                                    <th class="text-center">WhatsApp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($total > 0): ?>
                                    <?php while($p = mysqli_fetch_assoc($res_peserta)): ?>
                                    <tr>
                                        <td><strong><?= $p['nama_peserta'] ?></strong></td>
                                        <td><span class="badge-status"><?= $p['status_peserta'] ?></span></td>
                                        <td><?= ($p['status_peserta'] == 'Mahasiswa') ? $p['universitas'] : '-' ?></td>
                                        <td class="text-center">
                                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $p['no_telp']) ?>" target="_blank" style="color: #27ae60; font-size: 1.2rem;">
                                                <i class="ri-whatsapp-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center" style="padding: 2rem; color: #999;">Belum ada pendaftar untuk webinar ini.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <?php endwhile; ?>
            <?php else: ?>
                <div class="card text-center">
                    <p>Anda belum membuat webinar apapun.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>