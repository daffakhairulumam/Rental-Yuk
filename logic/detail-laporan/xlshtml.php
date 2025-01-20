<?php
include_once '../../config/koneksi.php';

// Set headers untuk file Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Sewa_Mobil.xls");

// Query untuk mendapatkan data detail transaksi per mobil
$sql = "SELECT headtrans.id_trans, mobil.kode_mobil, mobil.merek, detailtrans.no_polisi, detailtrans.tgl_pinjam, detailtrans.tgl_kembali, detailtrans.harga, detailtrans.subtotal FROM headtrans INNER JOIN detailtrans ON headtrans.id_trans = detailtrans.id_trans INNER JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil WHERE MONTH(headtrans.tanggal_transaksi) = MONTH(CURDATE()) AND YEAR(headtrans.tanggal_transaksi) = YEAR(CURDATE())";

$data = mysqli_query($koneksi, $sql);

// Query untuk menghitung total semua transaksi bulan ini
$total_query = "SELECT SUM(detailtrans.subtotal) AS total_bulan_ini FROM headtrans INNER JOIN detailtrans ON headtrans.id_trans = detailtrans.id_trans WHERE MONTH(headtrans.tanggal_transaksi) = MONTH(CURDATE()) AND YEAR(headtrans.tanggal_transaksi) = YEAR(CURDATE())";

$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_bulan_ini = $total_row['total_bulan_ini'];

// Tampilkan data dalam tabel Excel
echo "<table width='100%' border='1'>
       <thead>
           <tr>
               <th style='text-align: center;'>No.</th>
               <th style='text-align: center;'>ID Transaksi</th>
               <th style='text-align: center;'>Kode Mobil</th>
               <th style='text-align: center;'>No Polisi</th>
               <th style='text-align: center;'>Merek</th>
               <th style='text-align: center;'>Tanggal Pinjam</th>
               <th style='text-align: center;'>Tanggal Kembali</th>
               <th style='text-align: center;'>Harga</th>
               <th style='text-align: center;'>Subtotal</th>
           </tr>
       </thead>
       <tbody>";

foreach ($data as $key => $value) {
    echo "<tr>
            <td style='text-align: center;'>" . ($key + 1) . "</td>
            <td style='text-align: center;'>" . $value['id_trans'] . "</td>
            <td style='text-align: center;'>" . $value['kode_mobil'] . "</td>
            <td style='text-align: center;'>" . $value['no_polisi'] . "</td>
            <td style='text-align: center;'>" . $value['merek'] . "</td>
            <td style='text-align: center;'>" . $value['tgl_pinjam'] . "</td>
            <td style='text-align: center;'>" . $value['tgl_kembali'] . "</td>
            <td style='text-align: center;'>" . number_format($value['harga'], 0, ',', '.') . "</td>
            <td style='text-align: center;'>" . number_format($value['subtotal'], 0, ',', '.') . "</td>
          </tr>";
}

echo "<tr>
       <td colspan='8' style='text-align: right;'><strong>Total Transaksi Bulan Ini</strong></td>
       <td style='text-align: center;'><strong>Rp " . number_format($total_bulan_ini, 0, ',', '.') . "</strong></td>
   </tr>";

echo "</tbody>
    </table>";
