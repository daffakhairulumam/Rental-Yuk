<?php

// require_once('../../library/fpdf.php');
// require_once('../../config/koneksi.php');

// $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");

// $id_transaksi = $_GET['id_transaksi'];
// $query = "SELECT riwayat_transaksi.*, m_barang.nama_barang, m_barang.harga, m_kategori.nama_kategori, transaksi.total as total_transaksi, transaksi.total_bayar FROM riwayat_transaksi JOIN transaksi ON riwayat_transaksi.id_transaksi = transaksi.id_transaksi JOIN m_barang ON riwayat_transaksi.kode_barang = m_barang.kode_barang JOIN m_kategori ON m_barang.kode_kategori = m_kategori.kode_kategori WHERE riwayat_transaksi.id_transaksi = '$id_transaksi' ORDER BY riwayat_transaksi.kode_barang ASC";

// $data = mysqli_query($conn, $query);

// $queryTransaksi = "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'";
// $result = mysqli_query($conn, $queryTransaksi);
// $dataTransaksi = mysqli_fetch_array($result);

// $pdf = new FPDF('P', 'mm', array(80, 150));
// $pdf->AddPage();

// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Cell(0, 3, 'Latency', 0, 1, 'C');

// $pdf->SetFont('Arial', '', 5);
// $pdf->Cell(0, 3, 'Jl. Gunung Batu', 0, 1, 'C');

// $pdf->SetFont('Arial', 'B', 5);
// $pdf->Cell(0, 3, 'Id Transaksi : ' . $dataTransaksi['id_transaksi'], 0, 1, 'L');
// $pdf->Cell(0, 3, 'Tanggal Transaksi : ' . $dataTransaksi['tanggal_transaksi'], 0, 1, 'L');

// $pdf->SetFont('Arial', 'B', 5);
// $pdf->Cell(10, 3, 'No.', 0, 0, 'C');
// $pdf->Cell(13, 3, 'Nama', 0, 0, 'C');
// $pdf->Cell(13, 3, 'Harga', 0, 0, 'C');
// $pdf->Cell(13, 3, 'Qty', 0, 0, 'C');
// $pdf->Cell(13, 3, 'Sub Total', 0, 1, 'C');

// $pdf->SetFont('Arial', '', 5);

// $no = 1;
// foreach ($data as $key => $value) {
//     $pdf->Cell(10, 3, $no, 0, 0, 'C');
//     $pdf->Cell(13, 3, $value['nama_barang'], 0, 0, 'C');
//     $pdf->Cell(13, 3, $value['harga'], 0, 0, 'C');
//     $pdf->Cell(13, 3, $value['qty'], 0, 0, 'C');
//     $pdf->Cell(13, 3, $value['total'], 0, 1, 'C');
//     $no++;
// }

// $pdf->SetFont('Arial', 'B', 5);
// $pdf->Cell(0, 3, 'Total: ' . $value['total_transaksi'], 0, 1, 'R');
// $pdf->Cell(0, 3, 'Total Bayar: ' . $value['total_bayar'], 0, 1, 'R');
// $pdf->Cell(0, 3, 'Kembalian: ' . $value['total_bayar'] - $value['total_transaksi'], 0, 1, 'R');

// $pdf->SetFont('Arial', '', 5);
// $pdf->Cell(0, 3, 'Dicetak Oleh : ' . 'Anas Taufiqurrahman', 0, 1, 'C');
// $pdf->Cell(0, 3, 'Telp : ' . '088219824520', 0, 1, 'C');

// $pdf->output();
