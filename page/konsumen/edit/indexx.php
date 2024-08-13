<?php

include_once('config/koneksi.php');

$id = $_GET['id'];

$sql = "SELECT * FROM konsumen WHERE id = $id";

$result = mysqli_query($koneksi, $sql);

$data = mysqli_fetch_array($result);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Konsumen</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item"><a href="index.php">Konsumen</a></li>
                <li class="breadcrumb-item active">Tambah Konsumen</li>
            </ol>
        </nav>
    </div><!--end page title-->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Konsumen</h5>

                        <form action="logicc/konsumen/update.php" method="post">
                            <div class="form-group mb-3">
                                <input type="hidden" name="id" value="<?= $id ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>NIK</label>
                                <input type="text" name="kode_konsumen" placeholder="Input Kode Konsumen" class="form-control" value="<?= $data['kode_konsumen'] ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>NIK</label>
                                <input type="text" name="nik" placeholder="Input NIK" class="form-control" value="<?= $data['nik'] ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Nama</label>
                                <input type="text" name="nama" placeholder="Input Nama" class="form-control" value="<?= $data['nama'] ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" name="kelamin">
                                    <option value="<?= $data['jenis_kelamin'] ?>">--Pilih--</option>
                                    <option value="Laki-Laki">Laki Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Alamat</label>
                                <input type="text" name="alamat" placeholder="Input Alamat" class="form-control" value="<?= $data['alamat'] ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Telp</label>
                                <input type="text" name="telp" placeholder="Input Telp" class="form-control" value="<?= $data['telp'] ?>">
                            </div>

                            <hr>

                            <div class="text-end">
                                <button type="reset" class="btn btn-warning">Reset</button>
                                <button type="submit" name="Submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>