<?php
// Pastikan koneksi dan session sudah ada (biasanya di header atau config)
include 'includes/koneksi.php';
session_start();

if (!isset($_SESSION['id_user'])) { header("Location: login.php"); exit; }
$id_user = $_SESSION['id_user'];

// 1. AMBIL DATA WEBINAR YANG AKAN DIEDIT
if (!isset($_GET['id'])) { header("Location: profil.php"); exit; }
$id_webinar = mysqli_real_escape_string($conn, $_GET['id']);

// Pastikan hanya pemilik yang bisa edit
$query = mysqli_query($conn, "SELECT * FROM webinar WHERE id_webinar = '$id_webinar' AND id_penyelenggara = '$id_user'");
$data = mysqli_fetch_assoc($query);

if (!$data) { echo "Akses dilarang atau data tidak ditemukan."; exit; }

// 2. PROSES UPDATE DATA
if (isset($_POST['update_webinar'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul_webinar']);
    $narasumber = mysqli_real_escape_string($conn, $_POST['narasumber']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tgl = $_POST['tgl_pelaksanaan'];
    $jam = $_POST['jam_pelaksanaan'];
    $kuota = $_POST['kuota'];
    $link = mysqli_real_escape_string($conn, $_POST['link_webinar']);
    $sertifikat = $_POST['sertifikat'];

    // Update Poster jika ada file baru
    $poster_nama = $data['poster_webinar'];
    if ($_FILES['poster']['error'] === 0) {
        $ext = pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
        $poster_nama = "poster_" . time() . "." . $ext;
        move_uploaded_file($_FILES['poster']['tmp_name'], "uploads/poster/" . $poster_nama);
    }

    $sql = "UPDATE webinar SET 
            judul_webinar='$judul', narasumber='$narasumber', deskripsi='$deskripsi', 
            tgl_pelaksanaan='$tgl', jam_pelaksanaan='$jam', kuota='$kuota', 
            link_webinar='$link', sertifikat='$sertifikat', poster_webinar='$poster_nama' 
            WHERE id_webinar='$id_webinar'";

    if (mysqli_query($conn, $sql)) {
        header("Location: profil.php?status=success_update");
        exit;
    } else {
        $error = "Gagal mengupdate data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <title>Edit Webinar</title>
    <style>
        :root {
            --primary-color: #6c5ce7;
            --secondary-color: #a29bfe;
            --bg-color: #f8f9fa;
            --text-color: #2d3436;
        }

        body { background-color: var(--bg-color); color: var(--text-color); }

        .edit-card {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2.5rem;
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            color: #775CA7;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .full-width { grid-column: span 2; }

        .input-group { margin-bottom: 1.2rem; }

        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: #636e72;
        }

        .input-group input, 
        .input-group textarea, 
        .input-group select {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1.5px solid #dfe6e9;
            border-radius: 0.8rem;
            font-family: inherit;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .input-group input:focus, 
        .input-group textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.1);
        }

        .btn-container {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
        }

        .btn-save {
            flex: 2;
            background: #785ca7ee;
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-cancel {
            flex: 1;
            background: #dfe6e9;
            color: #636e72;
            text-align: center;
            text-decoration: none;
            padding: 1rem;
            border-radius: 0.8rem;
            font-weight: 600;
        }

        .btn-save:hover { background: #6f5896; transform: translateY(-2px); }
        .btn-cancel:hover { background: #b2bec3; }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .edit-card { margin: 1rem; padding: 1.5rem; }
        }
    </style>
</head>
<body>

    <main class="main-content" style="padding-top: 6rem; padding-bottom: 3rem;">
        <div class="container">
            <div class="edit-card">
                <div class="form-header">
                    <i class="ri-edit-box-line ri-2x"></i>
                    <h2>Edit Informasi Webinar</h2>
                </div>
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-grid">
                        <div class="input-group full-width">
                            <label>Judul Webinar</label>
                            <input type="text" name="judul_webinar" value="<?= htmlspecialchars($data['judul_webinar']) ?>" required placeholder="Masukkan judul webinar">
                        </div>

                        <div class="input-group">
                            <label>Narasumber</label>
                            <input type="text" name="narasumber" value="<?= htmlspecialchars($data['narasumber']) ?>" required>
                        </div>

                        <div class="input-group">
                            <label>Kuota Peserta</label>
                            <input type="number" name="kuota" value="<?= $data['kuota'] ?>" required>
                        </div>

                        <div class="input-group full-width">
                            <label>Deskripsi Webinar</label>
                            <textarea name="deskripsi" rows="5" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                        </div>

                        <div class="input-group">
                            <label>Tanggal Pelaksanaan</label>
                            <input type="date" name="tgl_pelaksanaan" value="<?= $data['tgl_pelaksanaan'] ?>" required>
                        </div>

                        <div class="input-group">
                            <label>Jam Mulai</label>
                            <input type="time" name="jam_pelaksanaan" value="<?= $data['jam_pelaksanaan'] ?>" required>
                        </div>

                        <div class="input-group full-width">
                            <label>Link Meeting (Zoom/GMeet/Youtube)</label>
                            <input type="url" name="link_webinar" value="<?= $data['link_webinar'] ?>" required placeholder="https://zoom.us/j/...">
                        </div>

                        <div class="input-group">
                            <label>E-Sertifikat</label>
                            <select name="sertifikat">
                                <option value="Ya" <?= $data['sertifikat'] == 'Ya' ? 'selected' : '' ?>>Tersedia (Ya)</option>
                                <option value="Tidak" <?= $data['sertifikat'] == 'Tidak' ? 'selected' : '' ?>>Tidak Tersedia</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label>Ganti Poster (Opsional)</label>
                            <input type="file" name="poster" accept="image/*">
                        </div>
                    </div>

                    <div class="btn-container">
                        <button type="submit" name="update_webinar" class="btn-save">
                            <i class="ri-save-line"></i> Simpan Perubahan
                        </button>
                        <a href="profil" class="btn-cancel">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>