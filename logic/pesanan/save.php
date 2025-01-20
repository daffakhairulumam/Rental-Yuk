<?php

include_once('../../config/koneksi.php');

$kode = $_POST['kode_konsumen'];
$kode_mobil = $_POST['kode_mobil'];
$kode_konsumen = $_POST['kode_konsumen'];
$id_transaksi = $_POST['id_transaksi'];
$tgl_pinjam = $_POST['tgl_pinjam'];
$tgl_kembali = $_POST['tgl_kembali'];
// $total = $_POST['total'];
// $bayar = $_POST['bayar'];
// $kembalian = $_POST['kembalian'];



$sql = "INSERT INTO `pesanan` VALUES (NULL, '$id_transaksi', '$kode', '$kode_mobil', (select no_polisi from mobil where kode_mobil = '$kode_mobil'), '$tgl_pinjam','$tgl_kembali',(select harga from mobil where kode_mobil = '$kode_mobil'), (SELECT datediff('$tgl_kembali','$tgl_pinjam') * harga FROM mobil WHERE kode_mobil = '$kode_mobil'))";

if (mysqli_query($koneksi, $sql)) {
    header("Location: ../../index.php?page=transaksi");
} else {
    echo "Error" . "<br>" . mysqli_error($koneksi);
}
