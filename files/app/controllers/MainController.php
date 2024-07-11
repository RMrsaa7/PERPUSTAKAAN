<?php

class AnggotaController {
    public function index() {
        require_once __DIR__ . '/../../views/template/header.php';
        require_once __DIR__ . '/../../views/template/sidebar.php';
        require_once __DIR__ . '/../../views/template/topbar.php';
        require_once __DIR__ . '/../../views/template/anggota.php';
        require_once __DIR__ . '/../../views/template/footer.php';
    }
}
class MainController {
    public function index() {
        require_once __DIR__ . '/../../views/template/header.php';
        require_once __DIR__ . '/../../views/template/sidebar.php';
        require_once __DIR__ . '/../../views/template/topbar.php';
        require_once __DIR__ . '/../../views/template/anggota.php';
        require_once __DIR__ . '/../../views/template/footer.php';
    }
}

class ResumeController{
    public function index() {
        require_once __DIR__ . '/../../views/template/header.php';
        require_once __DIR__ . '/../../views/template/sidebar.php';
        require_once __DIR__ . '/../../views/template/topbar.php';
        require_once __DIR__ . '/../../views/template/main.php';
    }
}

class PeminjamanController {
    public function index() {
        require_once __DIR__ . '/../../views/template/header.php';
        require_once __DIR__ . '/../../views/template/sidebar.php';
        require_once __DIR__ . '/../../views/template/topbar.php';
        require_once __DIR__ . '/../../views/template/peminjaman.php';
    }
}

class PengembalianController {
    public function index() {
        require_once __DIR__ . '/../../views/template/header.php';
        require_once __DIR__ . '/../../views/template/sidebar.php';
        require_once __DIR__ . '/../../views/template/topbar.php';
        require_once __DIR__ . '/../../views/template/pengembalian.php';
    }
}

class BukuController {
    public function index() {
        require_once __DIR__ . '/../../views/template/header.php';
        require_once __DIR__ . '/../../views/template/sidebar.php';
        require_once __DIR__ . '/../../views/template/topbar.php';
        require_once __DIR__ . '/../../views/template/buku.php';
    }
}
?>
