<?php

include_once('../../config/koneksi.php');

$id = $_POST['id'];
$user = $_POST['username'];
$pass = $_POST['password'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telp = $_POST['telp'];
$hak = $_POST['hak'];

$sql = "UPDATE user SET username = '$user', password = '$pass', nama = '$nama', alamat = '$alamat', telp = '$telp', hak = '$hak' WHERE id = '$id'";
$result = mysqli_query($koneksi, $sql);

if ($result) {
    header("Location: ../../index.php?page=users");
} else {
    echo "Error" . "<br>" . mysqli_error($koneksi);
}
