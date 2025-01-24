<?php
include_once '../../config/koneksi.php';

// Set headers untuk file Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Sewa_Mobil.xls");

// Query untuk mendapatkan data detail transaksi per mobil
$sql = "SELECT headtrans.id_trans, headtrans.tanggal_transaksi, mobil.kode_mobil, mobil.merek, detailtrans.no_polisi, detailtrans.tgl_pinjam, detailtrans.tgl_kembali, detailtrans.harga, detailtrans.subtotal, konsumen.kode_konsumen, konsumen.nama AS nama_konsumen FROM headtrans INNER JOIN detailtrans ON headtrans.id_trans = detailtrans.id_trans INNER JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil INNER JOIN konsumen ON detailtrans.kode_konsumen = konsumen.kode_konsumen WHERE MONTH(headtrans.tanggal_transaksi) = MONTH(CURDATE()) AND YEAR(headtrans.tanggal_transaksi) = YEAR(CURDATE())";

$data = mysqli_query($koneksi, $sql);

// Query untuk menghitung total semua transaksi bulan ini
$total_query = "SELECT SUM(detailtrans.subtotal) AS total_bulan_ini FROM headtrans INNER JOIN detailtrans ON headtrans.id_trans = detailtrans.id_trans WHERE MONTH(headtrans.tanggal_transaksi) = MONTH(CURDATE()) AND YEAR(headtrans.tanggal_transaksi) = YEAR(CURDATE())";

$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_bulan_ini = $total_row['total_bulan_ini'];

// $tanggal = date('d f Y');

//Header
echo "<div
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

echo "<div class='title'>Laporan Sewa Mobil</div>";

// Tampilkan data dalam tabel Excel
echo "<table width='100%' border='1'>
       <thead>
           <tr>
               <th style='text-align: center;'>No.</th>
               <th style='text-align: center;'>ID Transaksi</th>
               <th style='text-align: center;'>Kode Konsumen</th>
               <th style='text-align: center;'>Nama Konsumen</th>
               <th style='text-align: center;'>Kode Mobil</th>
               <th style='text-align: center;'>No Polisi</th>
               <th style='text-align: center;'>Nama Mobil</th>
               <th style='text-align: center;'>Tanggal Transaksi</th>
               <th style='text-align: center;'>Tanggal Pinjam</th>
               <th style='text-align: center;'>Tanggal Kembali</th>
               <th style='text-align: center;'>Harga/Hari</th>
               <th style='text-align: center;'>Total</th>
           </tr>
       </thead>
       <tbody>";

foreach ($data as $key => $value) {
    echo "<tr>
            <td style='text-align: center;'>" . ($key + 1) . "</td>
            <td style='text-align: center;'>" . $value['id_trans'] . "</td>
            <td style='text-align: center;'>" . $value['kode_konsumen'] . "</td>
            <td style='text-align: center;'>" . $value['nama_konsumen'] . "</td>
            <td style='text-align: center;'>" . $value['kode_mobil'] . "</td>
            <td style='text-align: center;'>" . $value['no_polisi'] . "</td>
            <td style='text-align: center;'>" . $value['merek'] . "</td>
            <td style='text-align: center;'>" . date('d m Y', strtotime($value['tanggal_transaksi'])) . "</td>
            <td style='text-align: center;'>" . date('d m Y', strtotime($value['tgl_pinjam'])) . "</td>
            <td style='text-align: center;'>" . date('d m Y', strtotime($value['tgl_kembali'])) . "</td>
            <td style='text-align: center;'>" . "Rp. " . number_format($value['harga'], 0, ',', '.') . "</td>
            <td style='text-align: center;'>" . "Rp. " . number_format($value['subtotal'], 0, ',', '.') . "</td>
          </tr>";
}

echo "<tr>
       <td colspan='11' style='text-align: right;'><strong>Total Transaksi Bulan Ini</strong></td>
       <td style='text-align: center;'><strong>Rp. " . number_format($total_bulan_ini, 0, ',', '.') . "</strong></td>
   </tr>";

echo "</tbody>
    </table>";
