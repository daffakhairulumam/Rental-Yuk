<?php
include_once './config/koneksi.php';

$CodeMobil = genereteCodeMobi();
$NoPol = generateNoPol();

function genereteCodeMobi()
{
    $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");
    $query = "SELECT max(kode_mobil) AS kode FROM mobil";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);
    $codeMobil = $data['kode'];

    $noUrut = (int) substr($codeMobil, 3, 3);
    $noUrut++;

    $char = "MBL";
    $newID = $char . sprintf("%03s", $noUrut);

    return $newID;
}

function generateNoPol()
{
    $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");

    // Metode 1: Menggunakan nomor acak
    do {
        $randomNumber = rand(1000, 9999); // Generate nomor acak antara 1000-9999
        $noPol = "D " . $randomNumber . " SBF";

        // Cek apakah nomor polisi sudah ada di database
        $query = "SELECT no_polisi FROM mobil WHERE no_polisi = '$noPol'";
        $result = mysqli_query($koneksi, $query);
        $exists = mysqli_num_rows($result) > 0;
    } while ($exists); // Ulangi jika nomor sudah ada

    return $noPol;

    /* 
    // Metode 2: Menggunakan nomor sequential dari 4000
    $query = "SELECT no_polisi FROM mobil ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);
    
    if ($data) {
        // Jika ada data sebelumnya, ambil nomor urut terakhir
        $lastNoPol = $data['no_polisi'];
        $lastNumber = (int) substr($lastNoPol, 2, 4); // Mengambil 4 digit nomor
        $newNumber = $lastNumber + 1;
    } else {
        // Jika belum ada data, mulai dari 4000
        $newNumber = 4000;
    }
    
    $noPol = "D " . sprintf("%04d", $newNumber) . " SBF";
    */
}
?>

<!-- Rest of the HTML code remains the same -->

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Mobil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="index.php?page=mobil">Mobil</a></li>
                <li class="breadcrumb-item active">Tambah Mobil</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Mobil</h5>

                        <form action="logic/mobil/save.php" method="post" class="" enctype="multipart/form-data">

                            <div class="form-group mb-3">
                                <input type="hidden" name="id" placeholder="Input ID" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Kode Mobil</label>
                                <input type="text" name="kode" placeholder="Input Kode Mobil" class="form-control" value="<?= $CodeMobil ?>" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label>No Polisi</label>
                                <input type="text" name="no" placeholder="Input No Polisi" class="form-control" value="<?= $NoPol ?>" readonly>
                            </div>

                            <!-- Form fields lainnya tetap sama -->
                            <div class="form-group mb-3">
                                <label>Merek</label>
                                <input type="text" name="merek" placeholder="Input Nama Merek" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Harga</label>
                                <input type="number" name="harga" oninput="validatePrice(this)" min="1" placeholder="Input Harga" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Warna</label>
                                <input type="text" name="warna" placeholder="Input Warna" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option>--Pilih--</option>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Disewa">Disewa</option>
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

<script>
    function validatePrice(input) {
        // Hapus angka 0 di depan
        input.value = input.value.replace(/^0+/, '');

        // Jika nilai kurang dari 1, set ke kosong
        if (input.value <= 0) {
            input.value = '';
        }
    }
</script>