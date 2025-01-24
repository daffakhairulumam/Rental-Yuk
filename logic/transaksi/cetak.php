<?php
require_once('../../library/fpdf.php');
require_once('../../config/koneksi.php');

// Pastikan tidak ada output sebelum PDF
error_reporting(0); // Untuk menghindari warning tampil ke browser

$koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");

$id_trans = $_GET['id_transaksi'];

// Perbaikan query dengan JOIN yang benar
$query = "SELECT d.*, m.merek, m.harga, h.total as total_transaksi, h.tanggal_transaksi, h.bayar, h.kembalian, k.nama as nama_konsumen, u.nama as nama_petugas FROM detailtrans d INNER JOIN headtrans h ON d.id_trans = h.id_trans INNER JOIN mobil m ON d.kode_mobil = m.kode_mobil INNER JOIN konsumen k ON d.kode_konsumen = k.kode_konsumen CROSS JOIN users u WHERE u.hak = 'Admin' AND d.id_trans = '$id_trans' ORDER BY d.kode_mobil ASC";

$data = mysqli_query($koneksi, $query);

// Jika data tidak ditemukan
if (mysqli_num_rows($data) == 0) { ?>
    <script>
        alert("Data Tidak Ditemukan");
        window.location = '../../index.php?page=transaksi';
    </script>
<?php
    exit();
}

$pdf = new FPDF('P', 'mm', array(85, 150));
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 3, 'Rental Yuk', 0, 1, 'C');

$pdf->SetFont('Arial', '', 5);
$pdf->Cell(0, 3, 'Jl. Gunung Batu', 0, 1, 'C');

$row = mysqli_fetch_array($data);
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(0, 3, 'Id Transaksi : ' . $row['id_trans'], 0, 1, 'L');
$pdf->Cell(0, 3, 'Tanggal Transaksi : ' . date('d F Y', strtotime($row['tanggal_transaksi'])), 0, 1, 'L');
$pdf->Cell(0, 3, 'Nama Konsumen : ' . $row['nama_konsumen'], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(10, 3, 'No.', 0, 0, 'C');
$pdf->Cell(13, 3, 'Nama Mobil', 0, 0, 'C');
$pdf->Cell(13, 3, 'Tgl Pinjam', 0, 0, 'C');
$pdf->Cell(13, 3, 'Tgl Kembali', 0, 0, 'C');
$pdf->Cell(13, 3, 'Harga', 0, 0, 'C');
$pdf->Cell(13, 3, 'Total', 0, 1, 'C');

$pdf->SetFont('Arial', '', 5);

// Reset pointer data ke awal
mysqli_data_seek($data, 0);

$no = 1;
$totalTransaksi = 0;
$bayar = 0;
$kembalian = 0;

foreach ($data as $key => $value) {

    $pdf->Cell(10, 3, $no, 0, 0, 'C');
    $pdf->Cell(13, 3, $value['merek'], 0, 0, 'C');
    $pdf->Cell(13, 3, $value['tgl_pinjam'], 0, 0, 'C');
    $pdf->Cell(13, 3, $value['tgl_kembali'], 0, 0, 'C');
    $pdf->Cell(13, 3, number_format($value['harga'], 0, ',', '.'), 0, 0, 'C');
    $pdf->Cell(13, 3, number_format($value['subtotal'], 0, ',', '.'), 0, 1, 'C');
    $no++;
    $totalTransaksi = $value['total_transaksi'];
    $bayar = $value['bayar'];
    $kembalian = $value['kembalian'];
    $nama_petugas = $value['nama_petugas'];
}

$pdf->SetFont('Arial', 'B', 5);
$xPosition = 19;
$pdf->SetXY($xPosition, $pdf->GetY());
$pdf->Cell(65, 3, 'Total: Rp. ' . number_format($totalTransaksi, 0, ',', '.'), 0, 1, 'R');

$pdf->SetXY($xPosition, $pdf->GetY());
$pdf->Cell(65, 3, 'Bayar: Rp. ' . number_format($bayar, 0, ',', '.'), 0, 1, 'R');

$pdf->SetXY($xPosition, $pdf->GetY());
$pdf->Cell(65, 3, 'Kembalian: Rp. ' . number_format($kembalian, 0, ',', '.'), 0, 1, 'R');

$pdf->SetFont('Arial', '', 5);
$pdf->Cell(0, 3, 'Dicetak Oleh : ' . $nama_petugas, 0, 1, 'C');
$pdf->Cell(0, 3, 'Telp : 088229374948', 0, 1, 'C');

$pdf->Output();
