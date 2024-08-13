<?php

include_once('config/koneksi.php');

$id = $_GET['id'];

$sql = "SELECT * FROM mobil WHERE id = $id";

$result = mysqli_query($koneksi, $sql);

$data = mysqli_fetch_array($result);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Mobil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item"><a href="index.php">Mobil</a></li>
                <li class="breadcrumb-item active">Tambah Mobil</li>
            </ol>
        </nav>
    </div><!--end page title-->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Mobil</h5>

                        <form action="logic/mobil/update.php" method="post" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label>ID Mobil</label>
                                <input type="hidden" name="id" value="<?= $id ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Kode Mobil</label>
                                <input type="text" name="kode" placeholder="Input Kode Mobil" class="form-control" value="<?= $data['kode_mobil'] ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>No_Polisi</label>
                                <input type="text" name="no" placeholder="Input No Polisi" class="form-control" value="<?= $data['no_polisi'] ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Merek</label>
                                <input type="text" name="merek" placeholder="Input Nama Merek" class="form-control" value="<?= $data['merek'] ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Harga</label>
                                <input type="text" name="harga" placeholder="Input Harga" class="form-control" value="<?= $data['harga'] ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Warna</label>
                                <input type="text" name="warna" placeholder="Input Warna" class="form-control" value="<?= $data['warna'] ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Gambar</label>
                                <input type="file" name="image" class="form-control">
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