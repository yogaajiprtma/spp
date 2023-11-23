<?php
if (isset($_POST['editpembayaran'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $old_jumlah_bayar = $_POST['old_jumlah_bayar'];

    $total = $old_jumlah_bayar + $jumlah_bayar;

    $query = mysqli_query($koneksi, "UPDATE pembayaran SET jumlah_bayar='$total' WHERE id_pembayaran='$id_pembayaran'");
    if ($query) {
        echo '<script>alert("Pembayaran Berhasil.");location.href="?page=laporan";</script>';
    }
}
if (empty($_SESSION['user']['level'])) {
?>
    <script>
        window.history.back();
    </script>
<?php
}
?>


<h1 class="h3 mb-3">Laporan</h1>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <?php
                if (!empty($_SESSION['user']['level'] == 'admin')) {
                ?>
                    <a href="cetak-laporan.php" class="btn btn-success btn-sm" target="_blank"><i data-feather="printer"></i></a>
                <?php
                }
                ?>

            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover cell-border" id="laporan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Petugas</th>
                            <th>Nama Siswa</th>
                            <th>Tanggal Bayar</th>
                            <th>SPP</th>
                            <th>Jumlah Bayar</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas
                        INNER JOIN siswa ON pembayaran.nisn=siswa.nisn
                        INNER JOIN spp ON pembayaran.id_spp=spp.id_spp");

                        while ($data = mysqli_fetch_array($query)) {

                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $data['nama_petugas'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['tgl_bayar'] ?></td>
                                <td><?php echo $data['tahun'] ?> - <?php echo $data['nominal'] ?></td>
                                <td><?php echo $data['jumlah_bayar'] ?></td>
                                <td>
                                    <?php
                                    if ($data['nominal'] > $data['jumlah_bayar']) {
                                        echo 'Kurang';
                                    } else {
                                        echo 'Lunas';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($data['nominal'] <= $data['jumlah_bayar']) {
                                    ?>
                                        <button type="button" class="btn btn-success btn-sm">
                                            Lunas
                                        </button>
                                    <?php
                                    } else {
                                    ?>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#lunasi<?php echo $data['id_pembayaran'] ?>">
                                            Lunasi
                                        </button>
                                    <?php
                                    }
                                    ?>

                                </td>
                            </tr>
                            <div class="modal fade" id="lunasi<?php echo $data['id_pembayaran'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Lunasi Pembayaran</h1>
                                                </div>
                                            </div>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <form method="post" id="form-tambah" action="">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="col-form-label">Nama Petugas</label>
                                                    <input type="hidden" name="id_pembayaran" value="<?php echo $data['id_pembayaran'] ?>">
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="nama_petugas" id="nama_petugas" value="<?php echo $data['nama_petugas'] ?>" disabled>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Nama Siswa</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" value="<?php echo $data['nama'] ?>" disabled>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Tanggal Bayar</label>
                                                    <span class="text-danger">
                                                        <input type="dates" class="form-control" name="tanggal_bayar" id="tanggal_bayar" value="<?php echo $data['tgl_bayar'] ?>" disabled>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Spp</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="spp" id="spp" value="<?php echo $data['tahun'] ?> - <?php echo $data['nominal'] ?>" disabled>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Jumlah bayar</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="jumlah_bayar" id="jumlah_bayar">
                                                        <input type="hidden" class="form-control" name="old_jumlah_bayar" id="old_jumlah_bayar" value="<?php echo $data['jumlah_bayar'] ?>">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-sm-12">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary" name="editpembayaran">Simpan</button>
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
    let table = new DataTable('#laporan');
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
                            <input type="text" class="form-control" name="nama_kelas" id="nama_kelas">
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Kompetensi Keahlian</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="kompetensi_keahlian" id="kompetensi_keahlian">
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