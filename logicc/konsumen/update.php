<?php

include_once('../../config/koneksi.php');

$id = $_POST['id'];
$kode = $_POST['kode_konsumen'];
$nik = $_POST['nik'];
$nama = $_POST['nama'];
$kelamin = $_POST['kelamin'];
$alamat = $_POST['alamat'];
$telp = $_POST['telp'];

$sql = "UPDATE konsumen SET kode_konsumen = '$kode', nik = '$nik', nama = '$nama', jenis_kelamin = '$kelamin', alamat = '$alamat', telp = '$telp' WHERE id = '$id'";
$result = mysqli_query($koneksi, $sql);

if ($result) {
    header("Location: ../../indexx.php?page=konsumen");
} else {
    echo "Error" . "<br>" . mysqli_error($koneksi);
}
