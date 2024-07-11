<?php
class AnggotaModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAnggota() {
        $query = "SELECT * FROM anggota";
        $result = $this->conn->query($query);
        return $result;
    }
}
?>