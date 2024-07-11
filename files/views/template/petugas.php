<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" cocnntent="">

    <title>Data petugas</title>

    <!-- Custom fonts for this template -->
    <link href="../../../../PERPUSTAKAAN/files/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../../../PERPUSTAKAAN/files/public/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../../../PERPUSTAKAAN/files/public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
        $nama_petugas = $_POST['nama_petugas'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $update = mysqli_query($conn, "UPDATE petugas SET nama_petugas='$nama_petugas', username='$username', password='$password' WHERE id_petugas='$id'");

        if ($update) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $nama_petugas = $_POST['nama_petugas'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $insert = mysqli_query($conn, "INSERT INTO petugas (nama_petugas, username, password) VALUES ('$nama_petugas', '$username', '$password')");

        if ($insert) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

$query = mysqli_query($conn, "SELECT * FROM petugas ORDER BY id_petugas ASC");
if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $hapus = $conn->query("DELETE FROM petugas WHERE id_petugas='$id'");
    echo "<script>window.location.href='petugas.php';</script>";
}

$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editQuery = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas='$id'");
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
                <h1 class="h3 mb-2 text-gray-800 page-heading">Data petugas</h1>
                <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah Data petugas</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>id_petugas</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_petugas = 1;
                                    while ($data = $query->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td><?= $id_petugas; ?></td>
                                            <td><?= $data->nama_petugas; ?></td>
                                            <td><?= $data->username; ?></td>
                                            <td><?= $data->password; ?></td>
                                            <td>
                                                <a href="?edit=<?= $data->id_petugas; ?>" class="btn btn-primary btn-sm" data-target="#editModal"><i class="fa fa-edit"></i> Edit</a>
                                            </td>
                                            </td>
                                        </tr>
                                    <?php
                                        $id_petugas++;
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
                        <h5 class="modal-title" id="exampleModalLabel">FORM INPUT DATA PETUGAS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Bagian Form-->
                    <div class="modal-body">
                        <form method="post" action="../../../../PERPUSTAKAAN/files/views/template/petugas.php">
                            <div class="form-group">
                                <label>NAMA PETUGAS</label>
                                <input type="text" name="nama_petugas" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>USERNAME</label>
                                <input type="text" name="username" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>PASSWORD</label>
                                <input type="text" name="password" class="form-control">
                            </div>

                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- BAGIAN FORM EDIT -->

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">FORM EDIT DATA petugas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="../../../../PERPUSTAKAAN/files/views/template/petugas.php" method="post">
                            <input type="hidden" name="edit_id" value="<?= isset($editData['id_petugas']) ? $editData['id_petugas'] : '' ?>">
                            <div class="form-group">
                                <label for="nama_petugas">Nama petugas</label>
                                <input type="text" name="nama_petugas" class="form-control" value="<?= isset($editData['nama_petugas']) ? $editData['nama_petugas'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" value="<?= isset($editData['username']) ? $editData['username'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" name="password" class="form-control" value="<?= isset($editData['password']) ? $editData['password'] : '' ?>">
                            </div>
                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="../../../../PERPUSTAKAAN/files/public/vendor/jquery/jquery.min.js"></script>
<script src="../../../../../../PERPUSTAKAAN/files/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="/../../../../PERPUSTAKAAN/files/public/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../../../../PERPUSTAKAAN/files/public/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="../../../../PERPUSTAKAAN/files/public/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../../../PERPUSTAKAAN/files/public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../../../../PERPUSTAKAAN/files/public/js/demo/datatables-demo.js"></script>

<?php if (isset($_GET['edit'])) { ?>
    <script>
        $(document).ready(function() {
            $('#editModal').modal('show');
        });
    </script>
<?php } ?>

</body>

</html>