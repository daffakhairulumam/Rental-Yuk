<?php
include_once './config/koneksi.php';

$CodeKonsumen = genereteCodeKonsumen();

function genereteCodeKonsumen()
{
    $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");
    $query = "SELECT max(kode_konsumen) as kode FROM konsumen";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);
    $codeTrans = $data['kode'];

    $noUrut = (int) substr($codeTrans, 3, 3);
    $noUrut++;

    $char = "KSN";
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
                <li class="breadcrumb-item"><a href="index.php?page=mobil">Konsumen</a></li>
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

                        <form action="logic/konsumen/save.php" method="post">

                            <div class="form-group mb-3">
                                <label>Kode Konsumen</label>
                                <input type="text" name="kode_konsumen" placeholder="Input Kode Konsumen" class="form-control" value="<?= $CodeKonsumen ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>NIK</label>
                                <input type="text" name="nik" placeholder="Input NIK" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Nama</label>
                                <input type="text" name="nama" placeholder="Input Nama" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" name="kelamin">
                                    <option>--Pilih--</option>
                                    <option value="Laki-laki">Laki Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Alamat</label>
                                <input type="text" name="alamat" placeholder="Input Alamat" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Telp</label>
                                <input type="text" name="telp" placeholder="Input Telp" class="form-control">
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