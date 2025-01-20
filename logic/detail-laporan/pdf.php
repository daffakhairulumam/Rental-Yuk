<?php

require_once('../../library/fpdf.php');
require_once('../../config/koneksi.php');

$conn = mysqli_connect('localhost', 'root', '', 'rental_mobil');

$id_transaksi = $_GET['id_transaksi'];
$query = "SELECT detailtrans.*, mobil.merek AS nama_mobil, mobil.harga AS harga_mobil, headtrans.total AS total_transaksi, headtrans.bayar, headtrans.kembalian, DATEDIFF(detailtrans.tgl_kembali, detailtrans.tgl_pinjam) + 1 as duration  FROM detailtrans JOIN headtrans ON detailtrans.id_trans = headtrans.id_trans JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil WHERE detailtrans.id_trans = '$id_transaksi'";

$data = mysqli_query($conn, $query);

$queryTransaksi = "SELECT * FROM headtrans WHERE id_trans = '$id_transaksi'";
$result = mysqli_query($conn, $queryTransaksi);
$dataTransaksi = mysqli_fetch_array($result);

// Start output buffering to prevent any output before PDF generation
ob_start();

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Detail Laporan Transaksi', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Id Transaksi : ' . $dataTransaksi['id_trans'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Tanggal Transaksi : ' . $dataTransaksi['tanggal_transaksi'], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No.', 1, 0, 'C');
$pdf->Cell(30, 10, 'Kode Mobil', 1, 0, 'C');
$pdf->Cell(40, 10, 'Nama Mobil', 1, 0, 'C');
$pdf->Cell(30, 10, 'Tgl Pinjam', 1, 0, 'C');
$pdf->Cell(30, 10, 'Tgl Kembali', 1, 0, 'C');
$pdf->Cell(25, 10, 'Harga/Hari', 1, 0, 'C');
$pdf->Cell(25, 10, 'Total', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);

$no = 1;
$grandTotal = 0;

while ($row = mysqli_fetch_assoc($data)) {
    $duration = max(1, $row['duration']);
    $hargaPerHari = $row['harga'];
    $subtotal = $hargaPerHari * $duration;
    $grandTotal += $subtotal;

    $pdf->Cell(10, 10, $no, 1, 0, 'C');
    $pdf->Cell(30, 10, $row['kode_mobil'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['nama_mobil'], 1, 0, 'C');
    $pdf->Cell(30, 10, date('d/m/Y', strtotime($row['tgl_pinjam'])), 1, 0, 'C');
    $pdf->Cell(30, 10, date('d/m/Y', strtotime($row['tgl_kembali'])), 1, 0, 'C');
    $pdf->Cell(25, 10, number_format($hargaPerHari, 0, ',', '.'), 1, 0, 'C');
    $pdf->Cell(25, 10, number_format($subtotal, 0, ',', '.'), 1, 1, 'C');
    $no++;
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Total: Rp. ' . number_format($dataTransaksi['total'], 0, ',', '.'), 0, 1, 'R');
$pdf->Cell(0, 10, 'Total Bayar: Rp. ' . number_format($dataTransaksi['bayar'], 0, ',', '.'), 0, 1, 'R');
$pdf->Cell(0, 10, 'Kembalian: Rp. ' . number_format($dataTransaksi['kembalian'], 0, ',', '.'), 0, 1, 'R');

// Clear output buffer
ob_clean();

$pdf->Output();
