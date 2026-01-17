
# MyWebinar - Platform Manajemen Webinar Online

---

**Nama:** Reynaldi Nugraha Putra

**NIM:** 312410278

**Mata Kuliah:** Pemrograman Mobile Pertemuan 16 UAS

---

## 📝 Deskripsi Projek

MyWebinar adalah aplikasi berbasis web yang dirancang untuk memudahkan manajemen pendaftaran webinar. Aplikasi ini dibangun menggunakan prinsip **OOP (Object Oriented Programming)** dan struktur **Modular**, serta dilengkapi dengan **Routing App** menggunakan `.htaccess` untuk URL yang lebih ramah pengguna.

Projek ini memenuhi syarat UAS Pemrograman Web dengan fungsionalitas penuh mulai dari CRUD, sistem autentikasi, hingga otomasi sertifikat.

## 🚀 Fitur Utama

* 
**Sistem Login Multi-Role**: Memisahkan akses antara Admin (Penyelenggara) dan User (Peserta).


* 
**Manajemen Webinar (CRUD)**: Penyelenggara dapat menambah, mengubah, dan menghapus data webinar.


* 
**Pendaftaran Responsive**: Antarmuka pendaftaran yang dioptimalkan untuk perangkat mobile (Mobile First).


* 
**Filter Pencarian & Pagination**: Memudahkan pencarian webinar tertentu dengan sistem halaman yang rapi.


* 
**Otomasi Sertifikat**: Peserta dapat mengunduh sertifikat dalam format PNG secara otomatis setelah mendaftar.


* **Diskusi Real-time**: Fitur kolom komentar untuk interaksi tanya jawab pada setiap detail webinar.

## 🛠️ Struktur Direktori

Sesuai dengan ketentuan struktur directory lengkap:

```text
/project-uas/
├── /assets/                 # CSS (Framework & Custom), Fonts, dan JS
├── /controllers/               # Koneksi database, Header, dan Footer (Modular)
├── /includes/               # Koneksi database, Header, dan Footer (Modular)
├── /models/                 # Class PHP untuk implementasi OOP
├── /uploads/                # Penyimpanan Poster dan Template Sertifikat
├── /views/                  # UI/UX MyWebinar
    ├── detail.php           # Detail webinar & form pendaftaran
    ├── login.php            # Autentikasi User & Admin
    └── unduh_sertifikat.php # Script generate sertifikat otomatis
├── .htaccess                # Konfigurasi Clean URL (Routing)
├── index.php                # Halaman utama (Beranda)

```

## 📸 Screenshot Aplikasi

(Silakan lampirkan screenshot aplikasi Anda di sini sesuai instruksi )

1. **Halaman Beranda**: Menampilkan daftar webinar dengan pagination.
2. **Dashboard Admin**: Panel untuk manajemen CRUD webinar.
3. **Detail Webinar**: Tampilan deskripsi dan form pendaftaran mobile-responsive.

## 🎞️ Dokumentasi Video

Penjelasan fitur dan cara kerja aplikasi dapat dilihat melalui link berikut:

* 
**Link YouTube**: [Masukkan Link YouTube Anda Disini] 



## ⚙️ Instalasi

1. Clone repository ini.


2. Import database `db_webinar.sql` ke MySQL.
3. Pastikan modul `mod_rewrite` pada Apache aktif (untuk `.htaccess`).
4. Sesuaikan konfigurasi database pada `includes/koneksi.php`.
5. Login default:
* **User**: `user@mail.com` / `password123`
* 
**Admin**: `admin@mail.com` / `admin123` 





## 🌐 Demo Aplikasi

**Link Demo**: http://mywebinar.kesug.com
