<?php

$id = $_GET['id_anggota'];
$query = mysqli_query($conn, "SELECT * FROM anggota WHERE id_anggota='$id'");


while ($data = $query->fetch_object()) {  
    $id_anggota = $data->id;
    $nama_anggota = $data->nama_anggota;
    $jurusan = $data->jurusan;
    $no_telp = $data->no_telp;
}

?>
