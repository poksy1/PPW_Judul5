<?php
// config/database.php

class Database {
    private $host = "127.0.0.1";
    private $port = "3306";
    private $dbname = "db_mahasiswa";
    private $username = "root";
    private $password = ""; // Kosongkan jika pakai Laragon default
    private $pdo;

    // Hapus batasan ": PDO" agar tidak crash saat koneksi gagal
    public function getConnection() {
        $this->pdo = null;
        $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname . ";charset=utf8mb4";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $exception) {
            // Ini akan memunculkan ALASAN ASLI kenapa database menolak koneksi
            http_response_code(500);
            echo json_encode([
                "status" => "error", 
                "message" => "Koneksi Database Gagal: " . $exception->getMessage()
            ]);
            exit;
        }
        
        return $this->pdo;
    }
}
?>