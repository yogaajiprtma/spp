<?php
if (isset($_POST['tambah'])) {
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $query = mysqli_query($koneksi, "INSERT INTO spp (tahun,nominal) VALUES('$tahun','$nominal')");

    if ($query) {
        echo '<script>alert("Data Berhasil di Tambah");location.href="?page=spp";</script>';
    }
}
if (isset($_POST['edit'])) {
    $id_spp = $_POST['id_spp'];
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $query = mysqli_query($koneksi, "UPDATE spp SET tahun='$tahun',nominal='$nominal' WHERE id_spp='$id_spp' ");

    if ($query) {
        echo '<script>alert("Data Berhasil di Update");location.href="?page=spp";</script>';
    }
}
if (isset($_POST['hapus'])) {
    $id_spp = $_POST['id_spp'];


    $query = mysqli_query($koneksi, "DELETE FROM spp WHERE id_spp='$id_spp'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="?page=spp";</script>';
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


<h1 class="h3 mb-3"> SPP </h1>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahspp">
                    + Tambah Spp
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover cell-border" id="spp">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Nominal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM spp");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $data['tahun'] ?></td>
                                <td>Rp<?php echo number_format($data['nominal'], 2, ',', '.') ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editspp<?php echo $data['id_spp'] ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusspp<?php echo $data['id_spp'] ?>">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editspp<?php echo $data['id_spp'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"> Edit Spp</h1>
                                                </div>
                                            </div>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <form method="post" id="form-tambah" action="">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="col-form-label">Tahun</label>
                                                    <input type="hidden" name="id_spp" value="<?php echo $data['id_spp'] ?>">
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="tahun" value="<?= $data['tahun'] ?>" required>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Nominal</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="nominal" class="from-control" value="<?= $data['nominal'] ?>" required>
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
                            <div class="modal fade" id="hapusspp<?php echo $data['id_spp'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"> Hapus SPP</h1>
                                                </div>
                                            </div>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <form method="post" id="form-tambah" action="">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_spp" value="<?php echo $data['id_spp'] ?>">
                                                <div class="text-center">
                                                    <span>Yakin Hapus Data ?</span><br>
                                                    <span class="text-danger">
                                                        Tahun - <span><?php echo $data['tahun'] ?></span><br>
                                                        Nominal - <span><?php echo $data['nominal'] ?></span>
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
    let table = new DataTable('#spp');
</script>
<!-- Tambah Kelas -->
<div class="modal fade" id="tambahspp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-12">
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Spp</h1>
                    </div>
                </div>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <form method="post" id="form-tambah" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label">Tahun</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="tahun" required>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Nominal</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="nominal" required>
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