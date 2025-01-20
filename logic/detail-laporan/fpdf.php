<?php

require_once('../../library/fpdf.php');
require_once('../../config/koneksi.php');

$conn = mysqli_connect('localhost', 'root', '', 'rental_mobil');

$id_transaksi = $_GET['id_transaksi'];
$query = "SELECT detailtrans.*, mobil.merek AS nama_mobil, mobil.harga AS harga_mobil, headtrans.total AS total_transaksi FROM detailtrans JOIN headtrans ON detailtrans.id_trans = headtrans.id_trans JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil WHERE detailtrans.id_trans = '$id_transaksi' ORDER BY detailtrans.kode_mobil ASC";

$data = mysqli_query($conn, $query);

$queryTransaksi = "SELECT * FROM headtrans WHERE id_trans = '$id_transaksi'";
$result = mysqli_query($conn, $queryTransaksi);
$dataTransaksi = mysqli_fetch_array($result);

if (!$dataTransaksi) {
    die("Data transaksi tidak ditemukan.");
}

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
$pdf->Cell(30, 10, 'Nama', 1, 0, 'C');
$pdf->Cell(30, 10, 'Harga', 1, 0, 'C');
$pdf->Cell(30, 10, 'Qty', 1, 0, 'C');
$pdf->Cell(30, 10, 'Sub Total', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);

$no = 1;
while ($value = mysqli_fetch_assoc($data)) {
    $pdf->Cell(10, 10, $no, 1, 0, 'C');
    $pdf->Cell(30, 10, $value['kode_mobil'], 1, 0, 'C');
    $pdf->Cell(30, 10, $value['nama_mobil'], 1, 0, 'C');
    $pdf->Cell(30, 10, $value['harga_mobil'], 1, 0, 'C');
    $pdf->Cell(30, 10, $value['qty'], 1, 0, 'C');
    $pdf->Cell(30, 10, $value['subtotal'], 1, 1, 'C');
    $no++;
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Total: ' . $dataTransaksi['total'], 0, 1, 'R');
$pdf->Cell(0, 10, 'Total Bayar: ' . $dataTransaksi['bayar'], 0, 1, 'R');
$pdf->Cell(0, 10, 'Kembalian: ' . ($dataTransaksi['bayar'] - $dataTransaksi['total']), 0, 1, 'R');

$pdf->Output();
