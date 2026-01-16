<?php
require_once 'Database.php';

class Webinar extends Database {
    
    // Fungsi untuk mengambil semua data (Read) + Pagination
    public function getAll($limit, $offset) {
        $query = "SELECT * FROM webinar LIMIT $limit OFFSET $offset";
        return mysqli_query($this->conn, $query);
    }

    // Fungsi Filter Pencarian 
    public function search($keyword) {
        $query = "SELECT * FROM webinar WHERE judul LIKE '%$keyword%' OR penyelenggara LIKE '%$keyword%'";
        return mysqli_query($this->conn, $query);
    }

    // Fungsi Simpan Data (Create) 
    public function create($judul, $tanggal, $deskripsi) {
        $query = "INSERT INTO webinar (judul, tanggal, deskripsi) VALUES ('$judul', '$tanggal', '$deskripsi')";
        return mysqli_query($this->conn, $query);
    }

    // Fungsi Update Data (Update) 
    public function update($id, $judul) {
        $query = "UPDATE webinar SET judul='$judul' WHERE id=$id";
        return mysqli_query($this->conn, $query);
    }

    // Fungsi Hapus Data (Delete) 
    public function delete($id) {
        $query = "DELETE FROM webinar WHERE id=$id";
        return mysqli_query($this->conn, $query);
    }
}