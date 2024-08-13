<?php

include_once('../../config/koneksi.php');

$id = $_POST['id'];
$kode = $_POST['kode_konsumen'];
$nik = $_POST['nik'];
$nama = $_POST['nama'];
$kelamin = $_POST['kelamin'];
$alamat = $_POST['alamat'];
$telp = $_POST['telp'];

$sql = "INSERT INTO konsumen (id, kode_konsumen, nik, nama, jenis_kelamin, alamat, telp) VALUES ('$id', '$kode', '$nik', '$nama', '$kelamin', '$alamat', '$telp')";

$result = mysqli_query($koneksi, $sql);

if ($result) {
    header("Location: ../../index.php?page=konsumen");
} else {
    echo "Error: " . "<br>" . mysqli_error($koneksi);
}
