<?php
include_once '../../config/koneksi.php';

// Fungsi untuk mengkonversi nama hari ke Bahasa Indonesia
function hariIndonesia($tanggal)
{
    $hari = array(
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    );

    $namaHari = date('l', strtotime($tanggal));
    return $hari[$namaHari];
}

// Fungsi untuk mengkonversi nama bulan ke Bahasa Indonesia
function bulanIndonesia($tanggal)
{
    $bulan = array(
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    );

    $namaBulan = date('F', strtotime($tanggal));
    return $bulan[$namaBulan];
}

// Fungsi untuk format tanggal lengkap Indonesia
function formatTanggalIndonesia($tanggal)
{
    $tanggalHari = date('d', strtotime($tanggal));
    $tahun = date('Y', strtotime($tanggal));
    return $tanggalHari . ' ' . bulanIndonesia($tanggal) . ' ' . $tahun;
}

// Set headers untuk file Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Sewa_Mobil.xls");

// Get filter dates from URL parameters
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Set default dates to show current period if no filter
if (!$startDate && !$endDate) {
    $startDate = date('Y-m-d', strtotime('monday this week'));
    $endDate = date('Y-m-d', strtotime('sunday this week'));
}

// Modify the SQL query to include date filtering
$sql = "SELECT headtrans.id_trans, headtrans.tanggal_transaksi, mobil.kode_mobil, mobil.merek, 
        detailtrans.no_polisi, detailtrans.tgl_pinjam, detailtrans.tgl_kembali, detailtrans.harga, 
        detailtrans.subtotal, konsumen.kode_konsumen, konsumen.nama AS nama_konsumen 
        FROM headtrans 
        INNER JOIN detailtrans ON headtrans.id_trans = detailtrans.id_trans 
        INNER JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil 
        INNER JOIN konsumen ON detailtrans.kode_konsumen = konsumen.kode_konsumen";

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $sql .= " WHERE DATE(headtrans.tanggal_transaksi) BETWEEN '$startDate' AND '$endDate'";
}

$data = mysqli_query($koneksi, $sql);

// Modify total query to match the date filter
$total_query = "SELECT SUM(detailtrans.subtotal) AS total_periode 
                FROM headtrans 
                INNER JOIN detailtrans ON headtrans.id_trans = detailtrans.id_trans";

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $total_query .= " WHERE DATE(headtrans.tanggal_transaksi) BETWEEN '$startDate' AND '$endDate'";
}

$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_periode = $total_row['total_periode'];

// Header styling
echo "<div>
        <style>
            table { width: 100%; border-collapse: collapse; }
            th, td { padding: 8px; border: 1px solid black; }
            .text-center { text-align: center; }
            .text-right { text-align: right; }
            .title { text-align: center; font-size: 16pt; font-weight: bold; margin-bottom: 20px; }
            .info { margin-bottom: 15px; }
            .bold { font-weight: bold; }
            .summary { text-align: right; margin-top: 10px; font-size: 12pt; }
        </style>";

// Title and date range
echo "<div class='title'>Laporan Sewa Mobil</div>";

// Format periode tanggal
if (!isset($_GET['start_date']) && !isset($_GET['end_date'])) {
    // Jika tidak ada filter tanggal, tampilkan hari ini
    echo "<div class='info'><strong>Periode: " . hariIndonesia(date('Y-m-d')) .
        ", " . formatTanggalIndonesia(date('Y-m-d')) . "</strong></div>";
} else {
    // Jika ada filter tanggal, tampilkan periode
    echo "<div class='info'><strong>Periode: " . formatTanggalIndonesia($startDate) .
        " - " . formatTanggalIndonesia($endDate) . "</strong></div>";
}

// Table header
echo "<table width='100%' border='1'>
        <thead>
            <tr>
                <th class='text-center'>No.</th>
                <th class='text-center'>ID Transaksi</th>
                <th class='text-center'>Kode Konsumen</th>
                <th class='text-center'>Nama Konsumen</th>
                <th class='text-center'>Kode Mobil</th>
                <th class='text-center'>No Polisi</th>
                <th class='text-center'>Nama Mobil</th>
                <th class='text-center'>Tanggal Transaksi</th>
                <th class='text-center'>Tanggal Pinjam</th>
                <th class='text-center'>Tanggal Kembali</th>
                <th class='text-center'>Harga/Hari</th>
                <th class='text-center'>Total</th>
            </tr>
        </thead>
        <tbody>";

// Table content
foreach ($data as $key => $value) {
    echo "<tr>
            <td class='text-center'>" . ($key + 1) . "</td>
            <td class='text-center'>" . $value['id_trans'] . "</td>
            <td class='text-center'>" . $value['kode_konsumen'] . "</td>
            <td class='text-center'>" . $value['nama_konsumen'] . "</td>
            <td class='text-center'>" . $value['kode_mobil'] . "</td>
            <td class='text-center'>" . $value['no_polisi'] . "</td>
            <td class='text-center'>" . $value['merek'] . "</td>
            <td class='text-center'>" . date('d F Y', strtotime($value['tanggal_transaksi'])) . "</td>
            <td class='text-center'>" . date('d F Y', strtotime($value['tgl_pinjam'])) . "</td>
            <td class='text-center'>" . date('d F Y', strtotime($value['tgl_kembali'])) . "</td>
            <td class='text-center'>Rp. " . number_format($value['harga'], 0, ',', '.') . "</td>
            <td class='text-center'>Rp. " . number_format($value['subtotal'], 0, ',', '.') . "</td>
        </tr>";
}

// Total row
echo "<tr>
        <td colspan='11' class='text-right'><strong>Total " .
    (isset($_GET['start_date']) && isset($_GET['end_date']) ? "Periode" : "Semua Transaksi") .
    "</strong></td>
        <td class='text-center'><strong>Rp. " . number_format($total_periode, 0, ',', '.') . "</strong></td>
      </tr>";

echo "</tbody></table></div>";
