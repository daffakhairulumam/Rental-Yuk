<?php
include_once '../../config/koneksi.php';

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];

    // Set header untuk file Excel
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Detail_Laporan_Transaksi_$id_transaksi.xls");

    // Query untuk mendapatkan data transaksi
    $sql = "SELECT detailtrans.*, mobil.merek, headtrans.total, headtrans.bayar, headtrans.kembalian, headtrans.tanggal_transaksi, konsumen.nama AS nama_konsumen FROM detailtrans JOIN headtrans ON detailtrans.id_trans = headtrans.id_trans JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil JOIN konsumen ON detailtrans.kode_konsumen = konsumen.kode_konsumen WHERE detailtrans.id_trans = '$id_transaksi'";

    $data = mysqli_query($koneksi, $sql);
    $header = mysqli_fetch_assoc($data);
    mysqli_data_seek($data, 0); // Reset pointer

    echo "
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid black; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .title { text-align: center; font-size: 16pt; font-weight: bold; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        .bold { font-weight: bold; }
        .summary { text-align: right; margin-top: 10px; font-size: 12pt; }
    </style>
    ";

    // Header
    echo "<div class='title'>Detail Laporan Transaksi</div>";
    echo "<div class='info'>ID Transaksi: " . $id_transaksi . "</div>";
    echo "<div class='info'>Tanggal Transaksi: " . $header['tanggal_transaksi'] . "</div>";

    // Main table
    echo "<table>
            <thead>
                <tr>
                    <th style='width: 5%;'>No</th>
                    <th style='width: 20%;'>Kode Konsumen</th>
                    <th style='width: 15%;'>Kode Mobil</th>
                    <th style='width: 15%;'>No Polisi</th>
                    <th style='width: 30%;'>Nama Mobil</th>
                    <th style='width: 15%;'>Tanggal Pinjam</th>
                    <th style='width: 15%;'>Tanggal Kembali</th>
                    <th style='width: 15%;'>Harga/Hari</th>
                    <th style='width: 20%;'>Subtotal</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($data as $key => $value) {
        echo "<tr>
                <td class='text-center'>" . $key + 1 . "</td>
                <td class='text-center'>" . $value['kode_konsumen'] . "</td>
                <td class='text-center'>" . $value['kode_mobil'] . "</td>
                <td class='text-center'>" . $value['no_polisi'] . "</td>
                <td class='text-center'>" . $value['merek'] . "</td>
                <td class='text-center'>" . $value['tgl_pinjam'] . "</td>
                <td class='text-center'>" . $value['tgl_kembali'] . "</td>
                <td class='text-center'>Rp " . number_format($value['harga'], 0, ',', '.') . "</td>
                <td class='text-center'>Rp " . number_format($value['subtotal'], 0, ',', '.') . "</td>
            </tr>";
    }

    echo "</tbody></table>";

    // Summary di pojok kanan bawah tabel
    echo "<div class='summary'>
            <br>Total: <span>Rp " . number_format($header['total'], 0, ',', '.') . "</span>
            <br>Bayar: <span>Rp " . number_format($header['bayar'], 0, ',', '.') . "</span>
            <br>Kembalian: <span>Rp " . number_format($header['kembalian'], 0, ',', '.') . "</span>
          </div>";
}
