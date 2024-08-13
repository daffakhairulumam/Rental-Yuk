<?php

include_once '../../config/koneksi.php';


$id_transaksi = $_POST['id_transaksi'];
$id_user = $_POST['id_user'];
$total = $_POST['total'];
$bayar = $_POST['bayar'];
$kembalian = $_POST['kembalian'];

$query = "INSERT INTO headtrans (id_trans, tanggal_transaksi, total, bayar, kembalian) VALUES ('$id_transaksi', now(), '$total', '$bayar', '$kembalian')";

$result = mysqli_query($koneksi, $query);


$query2 = "INSERT INTO detailtrans SELECT null,pesanan.id_transaksi, pesanan.kode_mobil, pesanan.no_polisi, pesanan.harga, pesanan.total FROM pesanan";

$result2 = mysqli_query($koneksi, $query2);


$query3 = "TRUNCATE pesanan";

$result3 = mysqli_query($koneksi, $query3);

if ($result) {
    header("Location: ../../index.php?page=transaksi");
} else {
    echo "Error" . "<br>" . mysqli_error($koneksi);
}
