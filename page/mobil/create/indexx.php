<?php
include_once './config/koneksi.php';

$CodeMobil = genereteCodeMobi();

function genereteCodeMobi()
{
    $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");
    $query = "SELECT max(kode_mobil) as kode FROM mobil";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);
    $codeTrans = $data['kode'];

    $noUrut = (int) substr($codeTrans, 3, 3);
    $noUrut++;

    $char = "MBL";
    $newID = $char . sprintf("%03s", $noUrut);

    return $newID;
}

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Mobil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="index.php?page=mobil">Mobil</a></li>
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

                        <form action="logicc/mobil/save.php" method="post" class="" enctype="multipart/form-data">

                            <div class="form-group mb-3">
                                <input type="hidden" name="id" placeholder="Input ID" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Kode Mobil</label>
                                <input type="text" name="kode" placeholder="Input Kode Mobil" class="form-control" value="<?= $CodeMobil ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>No_Polisi</label>
                                <input type="text" name="no" placeholder="Input No Polisi" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Merek</label>
                                <input type="text" name="merek" placeholder="Input Nama Merek" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Harga</label>
                                <input type="text" name="harga" placeholder="Input Harga" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Warna</label>
                                <input type="text" name="warna" placeholder="Input Warna" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option>--Pilih--</option>
                                    <option value="Siap">Siap</option>
                                    <option value="Sedang Di Pakai">Sedang Di Pakai</option>
                                </select>
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