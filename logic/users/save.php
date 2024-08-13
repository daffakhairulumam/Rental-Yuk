<?php

include_once('../../config/koneksi.php');

$id = $_POST['id'];
$user = $_POST['username'];
$pass = $_POST['password'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telp = $_POST['telp'];
$hak = $_POST['hak'];

$sql = "INSERT INTO user (id, username, password, nama, alamat, telp, hak) VALUES ('$id', '$user', '$pass', '$nama', '$alamat', '$telp', '$hak')";

$result = mysqli_query($koneksi, $sql);

if ($result) {
    header("Location: ../../index.php?page=users");
} else {
    echo "Error: " . "<br>" . mysqli_error($koneksi);
}
