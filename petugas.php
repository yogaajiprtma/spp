<?php
if (isset($_POST['kelas'])) {
    $kelas = $_POST['kelas'];
}

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $nama_petugas = $_POST['nama_petugas'];
    $level = $_POST['level'];


    $query = mysqli_query($koneksi, "INSERT INTO petugas(username,password,nama_petugas,level) 
    VALUES ('$username','$password','$nama_petugas','$level')");

    if ($query) {
        echo '<script>alert("Data Berhasil di Tambah");location.href="?page=petugas";</script>';
    }
}

if (isset($_POST['edit'])) {
    $id_petugas = $_POST['id_petugas'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $nama_petugas = $_POST['nama_petugas'];
    $level = $_POST['level'];


    if (empty($_POST['password'])) {
        $query = mysqli_query($koneksi, "UPDATE petugas SET username='$username',nama_petugas='$nama_petugas',level='$level' WHERE id_petugas='$id_petugas'");

        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="?page=petugas";</script>';
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE petugas SET username='$username',password='$password',nama_petugas='$nama_petugas',level='$level' WHERE id_petugas='$id_petugas'");

        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="?page=petugas";</script>';
        }
    }
}

if (isset($_POST['hapus'])) {
    $id_petugas = $_POST['id_petugas'];

    $query = mysqli_query($koneksi, "DELETE FROM petugas WHERE id_petugas='$id_petugas'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="?page=petugas";</script>';
    }
}
if (empty($_SESSION['user']['level'] == 'admin')) {
?>
    <script>
        window.history.back();
    </script>
<?php
}
?>

<h1 class="h3 mb-3">Petugas</h1>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahpetugas">
                    + Tambah Petugas
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover cell-border" id="petugas">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Petugas</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM petugas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $data['username'] ?></td>
                                <td><?php echo $data['nama_petugas'] ?></td>
                                <td><?php echo $data['level'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPetugas<?php echo $data['id_petugas'] ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusPetugas<?php echo $data['id_petugas'] ?>">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editPetugas<?php echo $data['id_petugas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"> Edit Petugas</h1>
                                                </div>
                                            </div>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <form method="post" id="form-tambah" action="">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="col-form-label">Username</label>
                                                    <input type="hidden" name="id_petugas" value="<?php echo $data['id_petugas'] ?>">
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="username" id="username" value="<?php echo $data['username'] ?>" required>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Password</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="password" id="password">
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Nama Petugas</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="nama_petugas" id="nama_petugas" value="<?php echo $data['nama_petugas'] ?>" required>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Level</label>
                                                    <span class="text-danger">
                                                        <select name="level" class="form-select">
                                                            <option value="admin" <?php if ($data['level'] == 'admin') {
                                                                                        echo 'selected';
                                                                                    } ?>>Admin</option>
                                                            <option value="petugas" <?php if ($data['level'] == 'petugas') {
                                                                                        echo 'selected';
                                                                                    } ?>>Petugas</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-sm-12">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary" name="edit">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="hapusPetugas<?php echo $data['id_petugas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"> Hapus Petugas</h1>
                                                </div>
                                            </div>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <form method="post" id="form-tambah" action="">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_petugas" value="<?php echo $data['id_petugas'] ?>">
                                                <div class="text-center">
                                                    <span>Yakin Hapus Data ?</span><br>
                                                    <span class="text-danger">
                                                        Nama Petugas - <span><?php echo $data['nama_petugas'] ?></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-sm-12">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    let table = new DataTable('#petugas');
</script>
<!-- Tambah petugas -->
<div class="modal fade" id="tambahpetugas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-12">
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Petugas</h1>
                    </div>
                </div>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <form method="post" id="form-tambah" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label">Username</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="username" id="username" required>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Password</label>
                        <span class="text-danger">
                            <input type="password" class="form-control" name="password" id="password" required>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Nama Petugas</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="nama_petugas" id="nama_petugas" required>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Level</label>
                        <span class="text-danger">
                            <select name="level" class="form-select">
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" name="tambah">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>