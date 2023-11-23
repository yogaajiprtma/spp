<?php
include 'koneksi.php';

//tambah transaksi
if (isset($_POST['pembayaran'])) {
    $id_petugas = $_SESSION['user']['id_petugas'];
    $nisn = $_POST['nisn'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $id_spp = $_POST['id_spp'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    $spp = mysqli_query($koneksi, "SELECT * FROM spp WHERE id_spp='$id_spp'");
    $cek = mysqli_fetch_array($spp);

    if ($jumlah_bayar > $cek['nominal']) {
        echo '<script>alert("Jumlah Bayar Melebihi Nominal SPP.");location.href="?page=laporan";</script>';
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO pembayaran (id_petugas,nisn,tgl_bayar,id_spp,jumlah_bayar) VALUES ('$id_petugas','$nisn','$tgl_bayar','$id_spp','$jumlah_bayar')");
        if ($query) {
            echo '<script>alert("Pembayaran Berhasil.");location.href="?page=laporan";</script>';
        }
    }
}

if (empty($_SESSION['user'])) {
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>SIDS -
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'Dashboard';
        $cek = preg_replace('/-/', ' ', $page);
        $title = ucwords($cek);
        echo $title;
        ?>
    </title>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.html">
                    <span class="align-middle">AdminKit</span>
                </a>

                <?php
                if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'admin')) {
                ?>
                    <ul class="sidebar-nav">
                        <li class="sidebar-header">
                            Halaman
                        </li>

                        <li class="sidebar-item <?php echo (empty($_GET['page']) ? 'active' : '') ?>">
                            <a class="sidebar-link" href="index.php">
                                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?php echo ($page == 'petugas' ? 'active' : '') ?>">
                            <a class="sidebar-link" href="?page=petugas">
                                <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Petugas</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?php echo ($page == 'kelas' ? 'active' : '') ?>">
                            <a class="sidebar-link" href="?page=kelas">
                                <i class="align-middle" data-feather="airplay"></i> <span class="align-middle">Kelas</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?php echo ($page == 'siswa' || $page == 'history' ? 'active' : '') ?>">
                            <a class="sidebar-link" href="?page=siswa">
                                <i class="align-middle" data-feather="users"></i> <span class="align-middle">Siswa</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?php echo ($page == 'spp' ? 'active' : '') ?>">
                            <a class="sidebar-link" href="?page=spp">
                                <i class="align-middle" data-feather="book"></i> <span class="align-middle">SPP</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?php echo ($page == 'laporan' ? 'active' : '') ?>">
                            <a class="sidebar-link" href="?page=laporan">
                                <i class="align-middle" data-feather="activity"></i> <span class="align-middle">Laporan</span>
                            </a>
                        </li>
                    </ul>

                    <div class="sidebar-cta">
                        <div class="sidebar-cta-content">
                            <div class="d-grid">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahTransaksi">+ Tambah Transaksi</button>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'petugas')) {
                    ?>
                        <ul class="sidebar-nav">
                            <li class="sidebar-header">
                                Halaman
                            </li>

                            <li class="sidebar-item <?php echo (empty($_GET['page']) ? 'active' : '') ?>">
                                <a class="sidebar-link" href="index.php">
                                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo ($page == 'siswa' || $page == 'history' ? 'active' : '') ?>">
                                <a class="sidebar-link" href="?page=siswa">
                                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Siswa</span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo ($page == 'laporan' ? 'active' : '') ?>">
                                <a class="sidebar-link" href="?page=laporan">
                                    <i class="align-middle" data-feather="activity"></i> <span class="align-middle">Laporan</span>
                                </a>
                            </li>
                        </ul>

                        <div class="sidebar-cta">
                            <div class="sidebar-cta-content">
                                <div class="d-grid">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahTransaksi">+ Tambah Transaksi</button>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <ul class="sidebar-nav">
                            <li class="sidebar-header">
                                Halaman
                            </li>

                            <li class="sidebar-item <?php echo (empty($_GET['page']) ? 'active' : '') ?>">
                                <a class="sidebar-link" href="index.php">
                                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                                </a>
                            </li>
                        </ul>
                <?php
                    }
                }
                ?>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                <span class="text-dark">
                                    <?php
                                    if (!empty($_SESSION['user']['level'])) {
                                        echo $_SESSION['user']['nama_petugas'];
                                    } else {
                                        echo $_SESSION['user']['nama'];
                                    }
                                    ?>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="logout.php">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                    include $page . '.php';
                    ?>

                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> - <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Bootstrap Admin
                                        Template</strong></a> &copy;
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="js/app.js"></script>
    <!-- Tambah Transaksi -->
    <div class="modal fade" id="tambahTransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Transaksi</h1>
                        </div>
                    </div>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <form method="post" id="form-transaksi" action="">
                    <div class="modal-body">
                        <input type="hidden" name="id_petugas" id="id_petugas">
                        <div class="mb-3">
                            <label class="col-form-label">Nama Siswa</label>
                            <div class="text-danger">
                                <select name="nisn" id="nisn" class="form-select" required>
                                    <option value="">-Pilih-</option>
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT * FROM siswa");
                                    while ($siswa = mysqli_fetch_array($query)) {
                                    ?>
                                        <option value="<?php echo $siswa['nisn'] ?>"><?php echo $siswa['nama'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Tanggal Bayar</label>
                            <span class="text-danger">
                                <input type="date" class="form-control" name="tgl_bayar" id="tgl_bayar" required>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">SPP</label>
                            <div class="text-danger">
                                <select name="id_spp" id="id_spp" class="form-select" required>
                                    <option value="">-Pilih-</option>
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT * FROM spp");
                                    while ($spp = mysqli_fetch_array($query)) {
                                    ?>
                                        <option value="<?php echo $spp['id_spp'] ?>"><?php echo $spp['tahun'] ?> - <?php echo 'Rp ' . number_format($spp['nominal'], 2, ',', '.') ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Jumlah Bayar</label>
                            <span class="text-danger">
                                <input type="text" class="form-control" name="jumlah_bayar" id="jumlah_bayar" required>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-12">
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" name="pembayaran">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>