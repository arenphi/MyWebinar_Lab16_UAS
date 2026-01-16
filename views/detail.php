<?php 
// 1. Pastikan ID webinar ada
if(!isset($_GET['id'])) { header("Location: beranda"); exit; }

// 2. Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login");
    exit();
}

// 3. Definisikan ID Webinar dari URL dulu agar bisa dipakai di pendaftaran maupun diskusi
$id = mysqli_real_escape_string($conn, $_GET['id']);
$id_user_session = $_SESSION['id_user'];

// 4. PROSES SIMPAN PENDAFTARAN (Diletakkan SETELAH $id didefinisikan)
if (isset($_POST['daftar'])) {
    $nama_input = mysqli_real_escape_string($conn, $_POST['nama']);
    $status_input = mysqli_real_escape_string($conn, $_POST['status']);
    $no_telp_input = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $univ_input = ($status_input == 'Mahasiswa') ? mysqli_real_escape_string($conn, $_POST['universitas']) : '-';
    
    // Cek apakah sudah terdaftar
    $cek = mysqli_query($conn, "SELECT id_pendaftaran FROM pendaftaran WHERE id_user = '$id_user_session' AND id_webinar = '$id'");
    
    if (mysqli_num_rows($cek) == 0) {
        $query_daftar = "INSERT INTO pendaftaran (id_user, nama_peserta, id_webinar, status_peserta, universitas, no_telp) 
                         VALUES ('$id_user_session', '$nama_input', '$id', '$status_input', '$univ_input', '$no_telp_input')";

        if (mysqli_query($conn, $query_daftar)) {
            echo "<script>alert('Pendaftaran Berhasil!'); window.location.href='detail?id=$id';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal mendaftar: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Anda sudah terdaftar di webinar ini.');</script>";
    }
}

// 5. Proses Simpan Diskusi
if(isset($_POST['kirim_diskusi'])) {
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);
    $q_diskusi = "INSERT INTO diskusi (id_webinar, id_user, pesan) VALUES ('$id', '$id_user_session', '$pesan')";
    if(mysqli_query($conn, $q_diskusi)) {
        header("Location: detail?id=$id#diskusi-section");
        exit;
    }
}

// 6. Ambil Data Webinar untuk ditampilkan
$query = "SELECT webinar.*, users.nama_user, users.foto_user FROM webinar 
          LEFT JOIN users ON webinar.id_penyelenggara = users.id_user 
          WHERE id_webinar = '$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if(!$data) { echo "Webinar tidak ditemukan."; exit; }

// 7. Cek Status Pendaftaran untuk tampilan tombol
$is_registered = false;
$check_reg = mysqli_query($conn, "SELECT id_pendaftaran FROM pendaftaran WHERE id_user = '$id_user_session' AND id_webinar = '$id'");
if(mysqli_num_rows($check_reg) > 0) $is_registered = true;
?>

<main class="container main">
        <div class="detail__grid">
            <div>
                <div class="webinar__player">
                    <img src="uploads/poster/<?= $data['poster_webinar'] ?>">
                </div>
                
                <div class="info__card">
                    <h2 style="margin-bottom: 1rem;"><?= $data['judul_webinar'] ?></h2>
                    
                    <div style="display: flex; align-items: center; gap: 12px; margin-top: 15px;">
                        <?php $foto_host = !empty($data['foto_user']) ? $data['foto_user'] : 'default.png'; ?>
                        <img src="uploads/profil/<?= $foto_host ?>" 
                             style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 1px solid #eee;">
                        
                        <div>
                            <span style="display: block; font-weight: 700; color: #222; font-size: 1rem;">
                                <?= $data['nama_user'] ?>
                            </span>
                            <span style="font-size: 0.85rem; color: #666;">
                                <i class="ri-calendar-line"></i> <?= date('d M Y', strtotime($data['tgl_pelaksanaan'])) ?> | 
                                <i class="ri-time-line"></i> <?= $data['jam_pelaksanaan'] ?>
                            </span>
                        </div>
                    </div>

                    <div style="margin-top: 1rem;">
                        <span><i class="ri-user-voice-line"></i> Narasumber: <b><?= $data['narasumber'] ?></b></span>
                    </div>

                    <hr style="margin: 1.5rem 0; border: 0; border-top: 1px solid #eee;">
                    
                    <h3>Deskripsi</h3>
                    <p style="color: #555; line-height: 1.6;"><?= nl2br($data['deskripsi']) ?></p>
                </div>

                <div class="info__card" id="diskusi-section">
                    <h3><i class="ri-chat-3-line"></i> Diskusi</h3>
                    <hr style="margin: 1rem 0; border: 0; border-top: 1px solid #eee;">

                    <?php if(isset($_SESSION['id_user'])): ?>
                        <form action="" method="POST" style="margin-bottom: 2rem;">
                            <div class="modal__group">
                                <textarea name="pesan" rows="3" placeholder="Tanyakan sesuatu..." required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;"></textarea>
                            </div>
                            <button type="submit" name="kirim_diskusi" class="btn--submit" style="padding: 10px 20px; border:none; cursor:pointer; margin-top: 10px;">Kirim Pesan</button>
                        </form>
                    <?php endif; ?>

                    <div class="diskusi__list">
                        <?php 
                        $res_diskusi = mysqli_query($conn, "SELECT diskusi.*, users.nama_user FROM diskusi JOIN users ON diskusi.id_user = users.id_user WHERE id_webinar = '$id' ORDER BY tgl_kirim DESC");
                        while($d = mysqli_fetch_assoc($res_diskusi)):
                        ?>
                            <div class="diskusi__item" style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #f5f5f5;">
                                <div style="display:flex; justify-content:space-between;">
                                    <strong style="font-size:0.9rem; color:#2c3e50;"><?= $d['nama_user'] ?></strong>
                                    <small style="color:#aaa; font-size:0.7rem;"><?= date('H:i, d M', strtotime($d['tgl_kirim'])) ?></small>
                                </div>
                                <p style="margin-top:5px; font-size:0.9rem; color:#444;"><?= nl2br(htmlspecialchars($d['pesan'])) ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <div class="detail__sidebar">
                <div class="side__card">
                    <div class="icon-menu" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
    <div class="icon-item" onclick="toggleRegistrationForm()" id="btn-daftar">
        <div class="icon-box"><i class="ri-edit-box-line"></i></div>
        <span>Daftar</span>
    </div>

    <?php if ($is_registered): ?>
        <a href="<?= $data['link_webinar'] ?>" target="_blank" class="icon-item">
            <div class="icon-box" style="background: #775CA7; color: white;">
                <i class="ri-video-chat-line"></i>
            </div>
            <span>Join Meet</span>
        </a>

        <?php if($data['sertifikat'] == 'Ya' && !empty($data['template_sertifikat'])): ?>
            <a href="unduh_sertifikat?id_webinar=<?= $id ?>" target="_blank" class="icon-item">
                <div class="icon-box" style="background: var(--purple-color); color: white;">
                    <i class="ri-medal-line"></i>
                </div>
                <span>Sertifikat</span>
            </a>
        <?php endif; ?>

        <?php if(!empty($data['virtual_background'])): ?>
            <a href="uploads/latar/<?= $data['virtual_background'] ?>" download class="icon-item">
                <div class="icon-box" style="background: #e67e22; color: white;">
                    <i class="ri-image-line"></i>
                </div>
                <span>Latar</span>
            </a>
        <?php endif; ?>

    <?php else: ?>
        <div class="icon-item icon--disabled" title="Daftar dulu untuk akses">
            <div class="icon-box"><i class="ri-medal-line"></i></div>
            <span>Sertifikat</span>
        </div>
        
        <div class="icon-item icon--disabled" title="Daftar dulu untuk akses">
            <div class="icon-box"><i class="ri-image-line"></i></div>
            <span>Latar</span>
        </div>
    <?php endif; ?>
</div>



                    <div id="registration-area" class="registration__container" style="display: none; margin-top: 1.5rem; border-top: 1px solid #eee; padding-top: 1.5rem;">
        <?php if(!$is_registered): ?>
            <h3 class="registration__title" style="margin-bottom: 1.2rem;">Formulir Pendaftaran</h3>
            <form action="" method="POST">
                <div class="modal__group" style="margin-bottom: 1rem;">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" value="<?= $_SESSION['nama_user'] ?>" readonly style="width:100%; padding:10px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div class="modal__group" style="margin-bottom: 1rem;">
                    <label>Status Peserta</label>
                    <select name="status" id="status_peserta" onchange="toggleUniversitas()" style="width:100%; padding:10px; border-radius: 8px; border: 1px solid #ddd;">
                        <option value="Umum">Umum (Bukan Mahasiswa)</option>
                        <option value="Mahasiswa">Mahasiswa</option>
                    </select>
                </div>

                <div id="univ_input" style="display:none; margin-bottom: 1rem;">
                    <label>Nama Universitas</label>
                    <input type="text" name="universitas" id="input_univ" placeholder="Contoh: Universitas Indonesia" style="width:100%; padding:10px; border-radius: 8px; border: 1px solid #ddd;">
                </div>

                <div class="modal__group" style="margin-bottom: 1.5rem;">
                    <label>Nomor WhatsApp</label>
                    <input type="number" name="no_telp" placeholder="08123456789" required style="width:100%; padding:10px; border-radius: 8px; border: 1px solid #ddd;">
                </div>

                <button type="submit" name="daftar" class="btn--submit" style="width:100%; padding:12px; border-radius:10px; border:none; background: var(--purple-color); color: white; font-weight: 700; cursor: pointer;">
                   Kirim Pendaftaran
                </button>
            </form>
        <?php endif; ?>
    </div>
                                        <?php if($data['sertifikat'] == 'Ya' && !empty($data['template_sertifikat'])): ?>
                        <div class="cert__preview-container" style="margin-top: 1rem; text-align: center;">
                            <p style="font-size: 0.8rem; font-weight: 700; margin-bottom: 8px; color: var(--purple-color);">Preview Sertifikat:</p>
                                <img src="uploads/sertifikat/<?= $data['template_sertifikat'] ?>" style="width: 100%; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 1px solid #ddd;  filter: blur(8px);">
                            </a>
                        </div>
                    <?php endif; ?>
</div>
                

                    <?php if($is_registered): ?>
                        <div style="text-align: center; padding: 1rem; background: #f0fff4; border-radius: 12px; border: 1px solid #c6f6d5; margin-top: 1rem;">
                            <i class="ri-checkbox-circle-fill" style="color: #38a169; font-size: 2rem;"></i>
                            <p style="color: #2f855a; font-weight: 700; font-size: 0.9rem;">Anda telah terdaftar</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
    function toggleUniversitas() {
        var status = document.getElementById("status_peserta").value;
        var univDiv = document.getElementById("univ_input");
        var univInput = document.getElementById("input_univ");
        if (status === "Mahasiswa") {
            univDiv.style.display = "block";
            univInput.setAttribute("required", "required");
        } else {
            univDiv.style.display = "none";
            univInput.removeAttribute("required");
            univInput.value = "";
        }
    }

    function toggleRegistrationForm() {
        const formArea = document.getElementById("registration-area");
        const btnBox = document.getElementById("btn-daftar").querySelector('.icon-box');

        if (formArea.style.display === "none" || formArea.style.display === "") {
            formArea.style.display = "block";
            btnBox.style.backgroundColor = "var(--purple-color)";
            btnBox.style.color = "white";
        } else {
            formArea.style.display = "none";
            btnBox.style.backgroundColor = "#f8f9fa";
            btnBox.style.color = "var(--black-color)";
        }
    }
    </script>