<?php
if (!empty($_SESSION['user']['level'])) {
?>
    <h1 class="h3 mb-3"> Dashboard</h1>

    <div class="row">
        <div class="col-12">
            <div class="w-100">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">jumlah petugas</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="users"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM petugas");
                                    $petugas = mysqli_fetch_array($query);
                                    echo $petugas['total'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">kelas</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="users"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kelas");
                                    $kelas = mysqli_fetch_array($query);
                                    echo $kelas['total'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Jumlah siswa</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="book"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kelas");
                                    $siswa = mysqli_fetch_array($query);
                                    echo $siswa['total'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">total transaksi masuk</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="tag"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">
                                    <?php
                                    $cek3 = mysqli_query($koneksi, "SELECT SUM(jumlah_bayar) AS total FROM pembayaran");
                                    $spp = mysqli_fetch_assoc($cek3);
                                    echo 'Rp ' . number_format($spp['total'], 2, ',', '.');
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php
} else {
?>
    <h1 class="h3 mb-3">History, <?php echo $_SESSION['user']['nama'] ?> </h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover cell-border" id="historysiswa">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Petugas</th>
                                <th>Nama Siswa</th>
                                <th>Tanggal Bayar</th>
                                <th>SPP</th>
                                <th>Jumlah Bayar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nisn = $_SESSION['user']['nisn'];
                            $no = 1;
                            $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas
                        INNER JOIN siswa ON pembayaran.nisn=siswa.nisn
                        INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE pembayaran.nisn='$nisn'");
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
                                </tr>
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
        let table = new DataTable('#historysiswa');
    </script>
<?php
}
?>