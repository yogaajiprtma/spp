<?php
if (isset($_POST['tambah'])) {
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $password = md5($_POST['password']);

    $cek_nisn = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$nisn'");
    $cek_nis = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$nis'");

    if (mysqli_num_rows($cek_nisn) > 0 && mysqli_num_rows($cek_nis) > 0) {
        echo '<script>alert("NISN dan NIS sudah digunakan");location.href="?page=siswa";</script>';
    } elseif (mysqli_num_rows($cek_nisn) > 0) {
        echo '<script>alert("NISN sudah digunakan");location.href="?page=siswa";</script>';
    } elseif (mysqli_num_rows($cek_nis) > 0) {
        echo '<script>alert("NIS sudah digunakan");location.href="?page=siswa";</script>';
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO siswa(nisn,nis,nama,id_kelas,alamat,no_telp,password) 
    VALUES ('$nisn','$nis','$nama','$id_kelas','$alamat','$no_telp','$password')");

        if ($query) {
            echo '<script>alert("Data Berhasil di Tambah");location.href="?page=siswa";</script>';
        }
    }
}

if (isset($_POST['edit'])) {
    $oldnisn = $_POST['oldnisn'];
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $password = md5($_POST['password']);

    if (empty($_POST['password'])) {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn',nis='$nis',nama='$nama',id_kelas='$id_kelas',alamat='$alamat',no_telp='$no_telp' WHERE nisn=$oldnisn");

        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="?page=siswa";</script>';
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn',nis='$nis',nama='$nama',id_kelas='$id_kelas',alamat='$alamat',no_telp='$no_telp',password='$password' WHERE nisn=$oldnisn");

        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="?page=siswa";</script>';
        }
    }
}

if (isset($_POST['hapus'])) {
    $nisn = $_POST['nisn'];

    $query = mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn='$nisn'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="?page=siswa";</script>';
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

<h1 class="h3 mb-3"> Siswa</h1>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php
                if (!empty($_SESSION['user']['level'] == 'admin')) {
                ?>
                    <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#tambahSiswa">
                        + Tambah Siswa
                    </button>
                <?php
                }
                ?>
                <table class="table table-bordered table-striped table-hover cell-border" id="siswa">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>Nama Siwa</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $data['nisn'] ?></td>
                                <td><?php echo $data['nis'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['alamat'] ?></td>
                                <td><?php echo $data['no_telp'] ?></td>

                                <td> <?php
                                        if (!empty($_SESSION['user']['level'] == 'admin')) {
                                        ?>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSiswa<?php echo $data['nisn'] ?>">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusSiswa<?php echo $data['nisn'] ?>">
                                            Hapus
                                        </button>
                                        <a href="?page=history&nisn=<?php echo $data['nisn'] ?>" class="btn btn-info btn-sm">History</a>
                                    <?php
                                        } else {
                                    ?>

                                        <a href="?page=history&nisn=<?php echo $data['nisn'] ?>" class="btn btn-info btn-sm">History</a>
                                    <?php
                                        }
                                    ?>

                                </td>
                            </tr>
                            <div class="modal fade" id="editSiswa<?php echo $data['nisn'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Data Siswa</h1>
                                                </div>
                                            </div>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <form method="post" id="form-tambah" action="">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="oldnisn" value="<?php echo $data['nisn'] ?>">
                                                    <label class="col-form-label">NISN</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="nisn" id="nisn" value="<?php echo $data['nisn'] ?>" required>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">NIS</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="nis" id="nis" value="<?php echo $data['nis'] ?>" required>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Nama Siswa</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $data['nama'] ?>" required>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Kelas dan Jurusan</label>
                                                    <div class="text-danger">
                                                        <select name="id_kelas" id="id_kelas" class="form-select" required>
                                                            <option value="">-Pilih-</option>
                                                            <?php
                                                            $query1 = mysqli_query($koneksi, "SELECT * FROM kelas");
                                                            while ($kelas = mysqli_fetch_array($query1)) {
                                                            ?>
                                                                <option value="<?php echo $kelas['id_kelas'] ?>" <?php echo ($data['id_kelas'] == $kelas['id_kelas'] ? 'selected' : '') ?>>
                                                                    <?php echo $kelas['nama_kelas'] ?> - <?php echo $kelas['kompetensi_keahlian'] ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Alamat</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $data['alamat'] ?>" required>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">No Telp</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="no_telp" id="no_telp" value="<?php echo $data['no_telp'] ?>" required>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Password</label>
                                                    <span class="text-danger">
                                                        <input type="password" class="form-control" name="password" id="password">
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
                            <div class="modal fade" id="hapusSiswa<?php echo $data['nisn'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"> Hapus Siswa</h1>
                                                </div>
                                            </div>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <form method="post" id="form-tambah" action="">
                                            <div class="modal-body">
                                                <input type="hidden" name="nisn" value="<?php echo $data['nisn'] ?>">
                                                <div class="text-center">
                                                    <span>Yakin Hapus Data ?</span><br>
                                                    <span class="text-danger">
                                                        NISN - <span><?php echo $data['nisn'] ?></span><br>
                                                        Nama Siswa - <span><?php echo $data['nama'] ?></span>
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
    let table = new DataTable('#siswa');
</script>
<!-- Tambah Siswa -->
<div class="modal fade" id="tambahSiswa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-12">
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Siswa</h1>
                    </div>
                </div>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <form method="post" id="form-tambah" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label">NISN</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="nisn" id="nisn" required>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">NIS</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="nis" id="nis" required>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Nama Siswa</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="nama" id="nama" required>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Kelas dan Jurusan</label>
                        <div class="text-danger">
                            <select name="id_kelas" id="id_kelas" class="form-select" required>
                                <option value="">-Pilih-</option>
                                <?php
                                $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                                while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $data['id_kelas'] ?>">
                                        <?php echo $data['nama_kelas'] ?> - <?php echo $data['kompetensi_keahlian'] ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Alamat</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="alamat" id="alamat" required>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">No Telp</label>
                        <span class="text-danger">
                            <input type="text" class="form-control" name="no_telp" id="no_telp" required>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Password</label>
                        <span class="text-danger">
                            <input type="password" class="form-control" name="password" id="password" required>
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