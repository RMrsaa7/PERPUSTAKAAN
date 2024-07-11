<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Anggota</title>

    <!-- Custom fonts for this template -->
    <link href="../../public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../public/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../../../../PERPUSTAKAAN/files/public/assets/ARS.jpg" rel="shortcut icon">

    <style>
        .page-heading {
            margin-top: 20px;
        }
    </style>
</head>

<?php
include(__DIR__ . '/../../app/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $id_petugas = $_POST['id_petugas'];
        $id_anggota = $_POST['id_anggota'];
        $id_buku = $_POST['id_buku'];
        $tgl_pinjam = $_POST['tgl_pinjam'];
        $tenggat_pengembalian = $_POST['tenggat_pengembalian'];
        $status_keterlambatan = $_POST['status_keterlambatan'];

        $update = mysqli_query(
            $conn,
            "UPDATE pengembalian SET id_petugas='$id_petugas', id_anggota='$id_anggota', id_buku='$id_buku', tgl_pinjam='$tgl_pinjam', tenggat_pengembalian='$tenggat_pengembalian', status_keterlambatan='$status_keterlambatan' WHERE id_pengembalian='$id'"
        );

        if ($update) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $id_petugas = $_POST['id_petugas'];
        $id_anggota = $_POST['id_anggota'];
        $id_buku = $_POST['id_buku'];
        $tgl_pinjam = $_POST['tgl_pinjam'];
        $tenggat_pengembalian = $_POST['tenggat_pengembalian'];
        $status_keterlambatan = $_POST['status_keterlambatan'];

        $insert = mysqli_query($conn, "INSERT INTO pengembalian (id_petugas, id_anggota, id_buku, tgl_pinjam, tenggat_pengembalian, status_keterlambatan) VALUES ('$id_petugas','$id_anggota','$id_buku','$tgl_pinjam','$tenggat_pengembalian','$status_keterlambatan')");
        if ($insert) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

$query = mysqli_query($conn, "SELECT * FROM pengembalian ORDER BY id_pengembalian ASC");
if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $hapus = $conn->query("DELETE FROM pengembalian WHERE id_pengembalian='$id'");
    echo "<script>window.location.href='pengembalian.php';</script>";
}

$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editQuery = mysqli_query($conn, "SELECT * FROM pengembalian WHERE id_pengembalian='$id'");
    $editData = mysqli_fetch_assoc($editQuery);
}
?>

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-3 mt-1 text-gray-800 page-heading">Data Pengembalian</h1>
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah data</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>pengembalian</th>
                                        <th>id_petugas</th>
                                        <th>id_anggota</th>
                                        <th>id_buku</th>
                                        <th>tgl_pinjam</th>
                                        <th>tenggat</th>
                                        <th>status</th>
                                        <th>aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_pengembalian = 1;
                                    while ($data = $query->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td><?= $id_pengembalian; ?></td>
                                            <td><?= $data->id_petugas; ?></td>
                                            <td><?= $data->id_anggota; ?></td>
                                            <td><?= $data->id_buku; ?></td>
                                            <td><?= $data->tgl_pinjam; ?></td>
                                            <td><?= $data->tenggat_pengembalian; ?></td>
                                            <td><?= $data->status_keterlambatan; ?></td>
                                            <td>
                                                <a href="?edit=<?= $data->id_pengembalian; ?>" class="btn btn-primary btn-sm" data-target="#editModal"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="?hapus=<?= $data->id_pengembalian; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data ini?');">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                            </td>


                                            </td>
                                        </tr>
                                    <?php
                                        $id_pengembalian++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">FORM INPUT DATA ANGGOTA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Bagian Form-->
                    <div class="modal-body">
                        <form method="post" action="../../../../PERPUSTAKAAN/files/views/template/pengembalian.php">
                            <div class="form-group">
                                <label>ID PETUGAS</label>
                                <input type="text" name="id_petugas" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>ID ANGGOTA</label>
                                <input type="text" name="id_anggota" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>ID BUKU</label>
                                <input type="text" name="id_buku" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>TANGGAL PINJAM</label>
                                <input type="date" name="tgl_pinjam" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>TANGGAL PENGEMBALIAN</label>
                                <input type="date" name="tenggat_pengembalian" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>STATUS KETERLAMBATAN</label>
                                <select class="form-control" name="status_keterlambatan">
                                    <option>TEPAT WAKTU</option>
                                    <option>TERLAMBAT</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">FORM EDIT DATA ANGGOTA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Bagian Form-->
                    <div class="modal-body">
                        <form method="post" action="../../../../PERPUSTAKAAN/files/views/template/pengembalian.php">
                            <input type="hidden" name="edit_id" value="<?= $editData['id_pengembalian']; ?>">
                            <div class="form-group">
                                <label>ID PETUGAS</label>
                                <input type="text" name="id_petugas" class="form-control" value="<?= $editData['id_petugas']; ?>">
                            </div>

                            <div class="form-group">
                                <label>ID ANGGOTA</label>
                                <input type="text" name="id_anggota" class="form-control" value="<?= $editData['id_anggota']; ?>">
                            </div>

                            <div class="form-group">
                                <label>ID BUKU</label>
                                <input type="text" name="id_buku" class="form-control" value="<?= $editData['id_buku']; ?>">
                            </div>

                            <div class="form-group">
                                <label>TANGGAL PINJAM</label>
                                <input type="date" name="tgl_pinjam" class="form-control" value="<?= $editData['tgl_pinjam']; ?>">
                            </div>

                            <div class="form-group">
                                <label>TANGGAL PENGEMBALIAN</label>
                                <input type="date" name="tenggat_pengembalian" class="form-control" value="<?= $editData['tenggat_pengembalian']; ?>">
                            </div>

                            <div class="form-group">
                                <label>STATUS KETERLAMBATAN</label>
                                <select class="form-control" name="status_keterlambatan">
                                    <option <?= $editData['status_keterlambatan'] == 'TEPAT WAKTU' ? 'selected' : ''; ?>>TEPAT WAKTU</option>
                                    <option <?= $editData['status_keterlambatan'] == 'TERLAMBAT' ? 'selected' : ''; ?>>TERLAMBAT</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- Bootstrap core JavaScript-->
<script src="../../public/vendor/jquery/jquery.min.js"></script>
<script src="../../public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../../public/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../../public/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="../../public/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../../public/js/demo/datatables-demo.js"></script>

</body>

</html>