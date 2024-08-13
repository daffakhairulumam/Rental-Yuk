<?php
include_once './config/koneksi.php';

// $data = pesanan();
// $saveTrans = saveTrans();
// $idUser = getIdUser();
$idTrans = genereteCodeTransaksi();
$pesanan = getPesanan($idTrans);
$total = 0;
$idTransaksiPrevous = '';

if (!empty($_GET['id_transaksi'])) {
    $idTransaksiPrevous = $_GET['id_transaksi'];
    $disabledCetak = '';
} else {
    $disabledCetak = 'disabled';
}

// foreach ($pesanan as $key => $value) {
//     $total += $value['total'];
// }

// if ($total < 0 || $total == 0) {
//     $disabled = 'disabled';
// } else {
//     $disabled = '';
// }

// function getIdUser()
// {
//     $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");
//     $query = "SELECT * FROM headtrans WHERE id_user = '$_SESSION[id] ORDER BY id_trans DESC";
//     $result = mysqli_query($koneksi, $query);

//     return $result;
// }

function genereteCodeTransaksi()
{
    $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");
    $query = "SELECT max(id_trans) as kode FROM headtrans";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);
    $codeTrans = $data['kode'];

    $noUrut = (int) substr($codeTrans, 3, 3);
    $noUrut++;

    $char = "TRX";
    $newID = $char . sprintf("%03s", $noUrut);

    return $newID;
}

function getPesanan($idTrans = null)
{
    $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");

    if ($idTrans) {
        $query = "SELECT * FROM pesanan JOIN mobil ON pesanan.kode_mobil = mobil.kode_mobil WHERE pesanan.id_transaksi = '$idTrans'";
        // } else {
        //     $query = "SELECT * FROM pesanan";
    }

    $result = mysqli_query($koneksi, $query);

    return $result;
}

// function saveTrans()
// {

//     $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");

//     $id_transaksi = $_POST['id_transaksi'];
//     $total = $_POST['total'];
//     $bayar = $_POST['bayar'];
//     $kembalian = $_POST['kembalian'];

//     $pesanan = "SELECT * FROM pesanan WHERE id_transaksi = '$id_transaksi'";
//     $resultPesanan = mysqli_query($koneksi, $pesanan);

//     $query = "INSERT INTO headtrans (id_trans, total, bayar, kembalian) VALUES ('$id_transaksi', '$total', '$bayar', '$kembalian')";
//     $result = mysqli_query($koneksi, $query);

//     foreach ($resultPesanan as $key => $value) {
//         $idTransaksi = $value['id_transaksi'];
//         $kodeKonsumen = $value['kode_konsumen'];
//         $kodeMobil = $value['kode_mobil'];
//         $noPolisi = $value['no_polisi'];
//         $tglPinjam = $value['tgl_pinjam'];
//         $tglKembali = $value['tgl_kembali'];
//         $harga = $value['harga'];
//         $total = $value['total'];

//         $queryDetail = "INSERT INTO detailtrans (id, id_trans, kode_mobil, no_polisi, harga, subtotal) VALUES ('$idTransaksi', '$kodeKonsumen', '$kodeMobil', '$noPolisi', '$tglPinjam', '$tglKembali', '$harga', '$total')";

//         $resultDetail = mysqli_query($koneksi, $queryDetail);

//         if ($result && $resultDetail) {
//             return true;
//         } else {
//             return false;
//         }
//     }
// }

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Mobil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Transaksi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi</h5>

                        <form action="logic/pesanan/save.php" method="post" class="" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label class="input-group-text">Kode Mobil</label>
                                        <select class="form-control" name="kode_mobil">
                                            <option>--Pilih--</option>
                                            <?php

                                            $sql = 'SELECT * FROM mobil';

                                            $result = mysqli_query($koneksi, $sql);

                                            while ($sql = mysqli_fetch_assoc($result)) { ?>
                                                <option value=<?= $sql['kode_mobil'] ?>> <?= $sql['kode_mobil'] ?> <?= $sql['merek'] ?> || <?= $sql['harga'] ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label class="input-group-text">ID Transaksi</label>
                                        <input type="text" class="form-control" name="id_transaksi" id="id_transaksi" value="<?= $idTrans ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label class="input-group-text">Kode Konsumen</label>
                                        <select class="form-control" name="kode_konsumen">
                                            <option>--Pilih--</option>
                                            <?php

                                            $sql = 'SELECT * FROM konsumen';
                                            $result = mysqli_query($koneksi, $sql);

                                            while ($sql = mysqli_fetch_assoc($result)) { ?>
                                                <option value=<?= $sql['kode_konsumen'] ?>> <?= $sql['kode_konsumen'] ?> <?= $sql['nik'] ?> <?= $sql['nama'] ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label class="input-group-text">Tanggal Pinjam</label>
                                        <input type="date" name="tgl_pinjam" class="form form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label class="input-group-text">Tanggal Kembali</label>
                                        <input type="date" name="tgl_kembali" class="form form-control">
                                    </div>
                                    <br>
                                    <button type="submit" name="Submit" class="btn btn-primary">SIMPAN</button>
                                </div>
                            </div>
                        </form>


                        <!-- Table with stripped rows -->
                        <table class="table table-bordered" id="table-mobil">
                            <thead>
                                <tr>
                                    <th>Kode Konsumen</th>
                                    <th>Kode Mobil</th>
                                    <th>No Polisi</th>
                                    <th>Harga</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT id,id_transaksi, kode_konsumen, kode_mobil, no_polisi, tgl_pinjam, tgl_kembali, harga, total, (SELECT SUM(total) FROM pesanan) AS totalseluruh FROM `pesanan`";
                                $result = mysqli_query($koneksi, $query);
                                foreach ($result as $key => $value) { ?>
                                    <tr>
                                        <td><?= $value['kode_konsumen'] ?></td>
                                        <td><?= $value['kode_mobil'] ?></td>
                                        <td><?= $value['no_polisi'] ?></td>
                                        <!-- <?= $total = $total + $value['total'] ?> -->
                                        <td>Rp.<?= number_format($value['harga'], 0, ',', '.') ?></td>
                                        <td><?= $value['tgl_pinjam'] ?></td>
                                        <td><?= $value['tgl_kembali'] ?></td>
                                        <td>Rp.<?= number_format($value['total'], 0, ',', '.') ?></td>
                                        <td>
                                            <a href="">
                                                <button type="button" class="btn btn-primary">
                                                    Tambah
                                                </button>
                                            </a>
                                            <p></p>
                                            <a href="logic/pesanan/delete.php?id=<?= $value['id'] ?>" onclick="javascript:return confirm('Hapus Data Mobil ?');">
                                                <button type="button" class="btn btn-primary">
                                                    Hapus
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                        <form action="logic/transaksi/save.php" method="post">
                            <hr>
                            <input type="hidden" name="id_transaksi" id="id_transaksi" value="<?= $idTrans ?>">
                            <input type="hidden" name="id_user" id="id_user"">
                            <div class=" row">
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <label class="input-group-text">Total</label>
                                    <input type="text" class="form-control" name="total" id="total" value="<?= $total ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <label class="input-group-text">Bayar</label>
                                    <input type="text" class="form-control" id="bayar" onkeyup="myFunction()" name="bayar" oninput="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <label class="input-group-text">Kembalian</label>
                                    <input type="text" class="form-control" id="kembalian" name="kembalian" readonly>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <button class="btn btn-primary" type="submit" name="submit">Bayar</button>
                                </div>
                            </div>
                    </div>
                    </form>
                    <div class=" col-lg-2 mt-2">
                        <div class="input-group">
                            <a href="index.php?page=transaksi/cetak">
                                <button class="btn btn-primary" type="button">Cetak Struk</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
<!-- End #main -->

<script>
    $(document).ready(function() {
        $('#table-mobil').DataTable();
    })

    function myFunction() {
        var bayar = $('#bayar').val();
        var total = $('#total').val();

        var kembalian = bayar - total;

        $('#kembalian').val(kembalian);
        // let x = document.getElementById("bayar");
        // x.value = x.value.toUpperCase();
    }

    function kembalian() {
        var bayar = $('#bayar').val();
        var total = $('#total').val();

        var kembalian = bayar - total;

        $('#kembalian').val(kembalian);

    }

    function MyFunction() {
        var bayar = $('#bayar').val();
        var total = $('#total').val();
        var idTransaksi = $('#id_transaksi').val();

        var kembalian = bayar - total;

        if (total < 0) {
            alert('Total Sewa Harus Lebih Dari 0');
            return false;
        }
        if (kembalian < 0) {
            alert('Uang Anda Kurang');
        }
    }

    // function bebas() {
    //     var mysql = require('mysql');
    //     var con = mysql.createConnection({
    //         host: "localhost",
    //         user: "root",    
    //         password: "",
    //         database: "rental_mobil"
    //     });
    //     con.connect(function(err) {
    //         if (err) throw err;
    //         console.log("Connected!");
    //         var sql = "INSERT INTO `user` (`id`, `username`, `password`, `nama`, `alamat`, `telp`, `hak`) VALUES (NULL, 'a', 'a', 'a', 'a', 'a', 'Admin')";
    //         con.query(sql, function(err, result) {
    //             if (err) throw err;
    //             console.log("1 record inserted");
    //         });
    //     });
    // }
</script>