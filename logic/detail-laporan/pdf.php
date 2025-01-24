<?php
require_once('../../library/fpdf.php');
require_once('../../config/koneksi.php');

$conn = mysqli_connect('localhost', 'root', '', 'rental_mobil');

// Get konsumen ID from URL parameter
$kode_konsumen = $_GET['kode_konsumen'];
$query = "SELECT * FROM konsumen WHERE kode_konsumen = '$kode_konsumen'";
$result = mysqli_query($conn, $query);
$konsumen = mysqli_fetch_assoc($result);

// Format tanggal dengan benar
setlocale(LC_TIME, 'id_ID');
$tanggal_cetak = date('d F Y');

// Start output buffering
ob_start();

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Title
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Data Konsumen', 0, 1, 'C');

// Date
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Tanggal Cetak: ' . $tanggal_cetak, 0, 1, 'C');
$pdf->Ln(10);

// Data format
$pdf->SetFont('Arial', '', 12);

// Add data rows with labels on left side
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Kode Konsumen: ' . $konsumen['kode_konsumen'], 0, 1);
$pdf->Cell(0, 10, 'NIK: ' . $konsumen['nik'], 0, 1);
$pdf->Cell(0, 10, 'Nama: ' . $konsumen['nama'], 0, 1);
$pdf->Cell(0, 10, 'Jenis Kelamin: ' . $konsumen['jenis_kelamin'], 0, 1);
$pdf->Cell(0, 10, 'Alamat: ' . $konsumen['alamat'], 0, 1);
$pdf->Cell(0, 10, 'No. Telepon: ' . $konsumen['telp'], 0, 1);

$pdf->SetFont('Arial', '', 5);


// Clear output buffer
ob_clean();

// Output PDF
$pdf->Output();
