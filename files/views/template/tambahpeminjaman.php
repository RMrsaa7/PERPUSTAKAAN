<?php

$id = $_GET['id_peminjaman'];
$query = mysqli_query($conn, "SELECT * FROM anggota WHERE id_peminjaman='$id'");


while ($data = $query->fetch_object()) {
    $id_peminjaman = $data->id;
    $nama_peminjam = $data->nama_peminjam;
    $buku = $data->buku;
    $tgl_pinjam = $data->tgl_pinjam;
}
