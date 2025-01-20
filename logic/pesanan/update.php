<?php

include_once('../../config/koneksi.php');

$kode = $_POST['kode_konsumen'];
$kode_mobil = $_POST['kode_mobil'];
$kode_konsumen = $_POST['kode_konsumen'];
$id_transaksi = $_POST['id_transaksi'];
$tgl_pinjam = $_POST['tgl_pinjam'];
$tgl_kembali = $_POST['tgl_kembali'];

$sql = "UPDATE `pesanan` SET tgl_pinjam = '$tgl_pinjam', tgl_kembali = '$tgl_kembali', total = (SELECT datediff('$tgl_kembali','$tgl_pinjam') * harga FROM mobil WHERE kode_mobil = '$kode_mobil') WHERE id_transaksi = '$id_transaksi' AND kode_mobil = '$kode_mobil'";

if (mysqli_query($koneksi, $sql)) {
    header("Location: ../../index.php?page=transaksi");
} else {
    echo "Error" . "<br>" . mysqli_error($koneksi);
}
