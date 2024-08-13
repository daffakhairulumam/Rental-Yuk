<?php

require_once('../../library/fpdf.php');
require_once('../../config/koneksi.php');

$koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");

$id_trans = $_GET['id_transaksi'];
$query = "SELECT detailtrans.*, mobil.merek, mobil.harga, headtrans.total as total_transaksi, headtrans.bayar FROM detailtrans JOIN headtrans ON detailtrans.id_transaksi = headtrans.id_transaksi JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil WHERE detailtrans.id_transaksi = '$id_trans' ORDER BY detailtrans.kode_mobil ASC";

$data = mysqli_query($koneksi, $query);

$queryTransaksi = "SELECT * FROM headtrans WHERE id_trans = '$id_trans'";
$result = mysqli_query($koneksi, $queryTransaksi);
$dataTransaksi = mysqli_fetch_array($result);

$pdf = new FPDF('P', 'mm', array(80, 150));
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 3, 'Rental Yuk', 0, 1, 'C');

$pdf->SetFont('Arial', '', 5);
$pdf->Cell(0, 3, 'Jl. Gunung Batu', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(0, 3, 'Id Transaksi : ' . $dataTransaksi['id_transaksi'], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(10, 3, 'No.', 0, 0, 'C');
$pdf->Cell(13, 3, 'Merek', 0, 0, 'C');
$pdf->Cell(13, 3, 'Harga', 0, 0, 'C');
$pdf->Cell(13, 3, 'Total', 0, 0, 'C');

$pdf->SetFont('Arial', '', 5);

$no = 1;
foreach ($data as $key => $value) {
    $pdf->Cell(10, 3, $no, 0, 0, 'C');
    $pdf->Cell(13, 3, $value['merek'], 0, 0, 'C');
    $pdf->Cell(13, 3, $value['harga'], 0, 0, 'C');
    $pdf->Cell(13, 3, $value['total'], 0, 0, 'C');
    $no++;
}

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(0, 3, 'total: ' . $value['total_transaksi'], 0, 1, 'R');
$pdf->Cell(0, 3, 'bayar: ' . $value['total_bayar'], 0, 1, 'R');
$pdf->Cell(0, 3, 'kembalian: ' . $value['total_bayar'] - $value['total_transaksi'], 0, 1, 'R');

$pdf->SetFont('Arial', '', 5);
$pdf->Cell(0, 3, 'Dicetak Oleh : ' . 'Daffa', 0, 1, 'C');
$pdf->Cell(0, 3, 'Telp : ' . '088219824520', 0, 1, 'C');

$pdf->output();
