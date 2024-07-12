<?php
include(__DIR__ . '/../../app/koneksi.php');

if (isset($_GET['id_anggota'])) {
    $id_anggota = $_GET['id_anggota'];

    $query = mysqli_query($conn, "SELECT * FROM peminjaman WHERE id_anggota='$id_anggota' AND status_peminjaman='Dipinjam' LIMIT 1");

    if ($query) {
        $data = mysqli_fetch_assoc($query);
        echo json_encode($data);
    } else {
        echo json_encode(null);
    }
}
?>
