<?php

include_once '../../config/koneksi.php';

// Ambil data dari form
$id_transaksi = $_POST['id_transaksi'];
// $id_user = $_POST['id_user'];
$kode_konsumen = $_POST['kode_konsumen']; // Ambil kode konsumen dari input hidden
$total = $_POST['total'];
$bayar = $_POST['bayar'];
$kembalian = $_POST['kembalian'];

// Insert ke tabel headtrans
$query = "INSERT INTO headtrans (id_trans, tanggal_transaksi, total, bayar, kembalian) VALUES ('$id_transaksi', NOW(), '$total', '$bayar', '$kembalian')";

$result = mysqli_query($koneksi, $query);

// Insert ke tabel detailtrans dengan tambahan tgl_pinjam dan tgl_kembali tambahkan kode_konsumen
$query2 = "INSERT INTO detailtrans (id, id_trans, kode_konsumen, kode_mobil, no_polisi, harga, subtotal, tgl_pinjam, tgl_kembali) SELECT NULL, pesanan.id_transaksi, pesanan.kode_konsumen, pesanan.kode_mobil, pesanan.no_polisi, pesanan.harga, pesanan.total, pesanan.tgl_pinjam, pesanan.tgl_kembali FROM pesanan";

$result2 = mysqli_query($koneksi, $query2);

// Update status mobil menjadi "Sedang Di Sewa"
$query3 = "UPDATE mobil SET status = 'Sedang Di Sewa' WHERE kode_mobil IN (SELECT kode_mobil FROM pesanan)";

$result3 = mysqli_query($koneksi, $query3);

// Kosongkan tabel pesanan setelah data diproses
$query4 = "TRUNCATE TABLE pesanan";

$result4 = mysqli_query($koneksi, $query4);

// Redirect atau tampilkan pesan error
if ($result && $result2 && $result3 && $result4) {
    header("location: ../../index.php?page=transaksi&alert=berhasil_transaksi&id_transaksi=$id_transaksi");
} else {
    echo "Error: " . mysqli_error($koneksi);
}
