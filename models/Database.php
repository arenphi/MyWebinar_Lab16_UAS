<?php
class Database {
    private $host = "sql202.infinityfree.com";
    private $user = "if0_40851716";
    private $pass = "lbJbk5QWliM";
    private $db   = "if0_40851716_mywebinar"; // Sesuaikan dengan nama database Anda
    protected $conn;

    public function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        if (!$this->conn) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }
    }
}