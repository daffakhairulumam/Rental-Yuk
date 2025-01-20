<?php
include_once './config/koneksi.php';

$transaksi = getTransaksi();
$countTransaksi = mysqli_num_rows($transaksi);

$konsumen = getKonsumen();
$countKonsumen = mysqli_num_rows($konsumen);

$mobil = getMobil();
$countMobil = mysqli_num_rows($mobil);

$statusMobil = getStatusMobil();

$totalTransaksi = 0;

foreach ($transaksi as $key => $value) {
    $totalTransaksi += $value['total'];
}

// Tambahkan fungsi ini setelah fungsi getMobil()
function getStatusMobil()
{
    $conn = mysqli_connect("localhost", "root", "", "rental_mobil");

    $disewa = mysqli_query($conn, "SELECT COUNT(*) as total FROM mobil WHERE status = 'Sedang Di Sewa'")->fetch_assoc();
    $tersedia = mysqli_query($conn, "SELECT COUNT(*) as total FROM mobil WHERE status != 'Sedang Di Sewa'")->fetch_assoc();

    return [
        'disewa' => $disewa['total'],
        'tersedia' => $tersedia['total']
    ];
}

function getTransaksi($idTransaksi = null)
{
    // Fungsi `connection()` untuk menghubungkan ke database
    $conn = mysqli_connect("localhost", "root", "", "rental_mobil");

    if ($idTransaksi) {
        // Query untuk mendapatkan detail transaksi berdasarkan ID transaksi
        $query = "SELECT detailtrans.*, mobil.merek AS nama_mobil, mobil.harga AS harga_mobil, headtrans.total AS total_transaksi, headtrans.bayar AS total_bayar FROM detailtrans JOIN headtrans ON detailtrans.id_trans = headtrans.id_trans JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil WHERE detailtrans.id_trans = '$idTransaksi' ORDER BY detailtrans.kode_mobil ASC";
    } else {
        // Query untuk mendapatkan semua data dari tabel `headtrans`
        $query = "SELECT * FROM headtrans";
    }

    $result = mysqli_query($conn, $query);

    return $result;
}

function getKonsumen($idKonsumen = null)
{
    $conn = mysqli_connect("localhost", "root", "", "rental_mobil");

    if ($idKonsumen) {
        $query = "SELECT * FROM konsumen WHERE id_konsumen = '$idKonsumen'";
    } else {
        $query = "SELECT * FROM konsumen";
    }

    $result = mysqli_query($conn, $query);

    return $result;
}

function getMobil()
{

    $conn = mysqli_connect("localhost", "root", "", "rental_mobil");

    $query = "SELECT * FROM mobil";

    $result = mysqli_query($conn, $query);

    return $result;
}
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- konsumen Card -->
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card konsumen-card">

                            <div class="card-body">
                                <h5 class="card-title">Konsumen</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $countKonsumen ?></h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End konsumen Card -->

                    <!-- mobil Card -->
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card mobil-card">

                            <div class="card-body">
                                <h5 class="card-title">Total Mobil</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-car-front"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $countMobil ?></h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End mobil Card -->

                    <!-- Sales Card -->
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Penjualan</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $countTransaksi ?></h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Status Mobil Cards -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="row">
                            <!-- Mobil Tersedia Card -->
                            <div class="col-md-6">
                                <div class="card info-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Mobil Tersedia</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e0f8e9;">
                                                <i class="bi bi-car-front text-success"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6><?= $statusMobil['tersedia'] ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobil Disewa Card -->
                            <div class="col-md-6">
                                <div class="card info-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Mobil Disewa</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #ffecdf;">
                                                <i class="bi bi-car-front text-warning"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6><?= $statusMobil['disewa'] ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Card -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Total Transaksi</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>Rp. <?= number_format($totalTransaksi) ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Revenue Card -->

                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>

</main><!-- End #main -->