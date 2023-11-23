<?php
if (isset($_POST['tambah'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi_keahlian = $_POST['kompetensi_keahlian'];

    $query = mysqli_query($koneksi, "INSERT INTO kelas (nama_kelas,kompetensi_keahlian) VALUES('$nama_kelas','$kompetensi_keahlian')");

    if ($query) {
        echo '<script>alert("Data Berhasil di Tambah");location.href="?page=kelas";</script>';
    }
}

if (isset($_POST['edit'])) {
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi_keahlian = $_POST['kompetensi_keahlian'];

    $query = mysqli_query($koneksi, "UPDATE kelas SET nama_kelas='$nama_kelas',kompetensi_keahlian='$kompetensi_keahlian' WHERE id_kelas='$id_kelas'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Update");location.href="?page=kelas";</script>';
    }
}

if (isset($_POST['hapus'])) {
    $id_kelas = $_POST['id_kelas'];

    $query = mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$id_kelas'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="?page=kelas";</script>';
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


<h1 class="h3 mb-3"> Kelas</h1>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKelas">
                    + Tambah Kelas
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover cell-border" id="kelas">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>kompetensi keahlian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $data['nama_kelas'] ?></td>
                                <td><?php echo $data['kompetensi_keahlian'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editKelas<?php echo $data['id_kelas'] ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusKelas<?php echo $data['id_kelas'] ?>">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editKelas<?php echo $data['id_kelas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"> Edit Kelas</h1>
                                                </div>
                                            </div>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <form method="post" id="form-tambah" action="">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="col-form-label">Nama Kelas</label>
                                                    <input type="hidden" name="id_kelas" value="<?php echo $data['id_kelas'] ?>">
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" value="<?php echo $data['nama_kelas'] ?>" required>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Kompetensi Keahlian</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="kompetensi_keahlian" id="kompetensi_keahlian" value="<?php echo $data['kompetensi_keahlian'] ?>" required>
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
                            <div class="modal fade" id="hapusKelas<?php echo $data['id_kelas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"> Hapus Kelas</h1>
                                                </div>
                                            </div>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <form method="post" id="form-tambah" action="">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_kelas" value="<?php echo $data['id_kelas'] ?>">
                                                <div class="text-center">
                                                    <span>Yakin Hapus Data ?</span><br>
                                                    <span class="text-danger">
                                                        Kelas - <span><?php echo $data['nama_kelas'] ?></span><br>
                                                        Kompetensi Keahlian - <span><?php echo $data['kompetensi_keahlian'] ?></span>
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
    let table = new DataTable('#kelas');
</script>
<!-- Tambah Kelas -->
<div class="modal fade" id="tambahKelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-12">
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Kelas</h1>
                    </div>
                </div>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <form method="post" id="form-tambah" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label">Nama Kelas</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" required>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Kompetensi Keahlian</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="kompetensi_keahlian" id="kompetensi_keahlian" required>
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