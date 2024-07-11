<?php
require_once __DIR__ . '/app/controllers/MainController.php';
require_once __DIR__ . '/app/models/AnggotaModel.php';

// Cek apakah ada parameter 'controller' di URL
if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];

    switch ($controller) {
        case 'main':
            $mainController = new MainController();
            $mainController->index();
            break;
        case 'resume':
            $resumeController = new ResumeController();
            $resumeController->index();
            break;
        case 'anggota':
            $anggotaController = new AnggotaController();
            $anggotaController->index();
            break;
        case 'peminjaman':
            $peminjamanController = new PeminjamanController();
            $peminjamanController->index();
            break;
        case 'pengembalian':
            $pengembalianController = new PengembalianController();
            $pengembalianController->index();
            break;
            case 'buku':
                $bukuController = new BukuController();
                $bukuController->index();
                break;
        default:
            echo "Controller not found.";
            break;
    }
} else {
    // Default controller
    $mainController = new MainController();
    $mainController->index();
}
