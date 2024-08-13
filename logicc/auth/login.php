<?php

include_once('../../config/koneksi.php');

$user = $_POST['username'];
$pass = $_POST['password'];
$sql = "SELECT * FROM user WHERE username = '$user' AND password = '$pass'";
$result = mysqli_query($koneksi, $sql);
$cek = mysqli_num_rows($result);

if ($cek == 1) {
    $data = mysqli_fetch_array($result);
    if ($data['hak'] == "Admin") {
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['id'] = $data['id'];
        $_SESSION['username'] = $data;
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['hak'] = $data['hak'];

        header("Location: ../../index.php");
    } elseif ($data['hak'] == "Petugas") {
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['username'] = $data;
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['hak'] = $data['hak'];

        header("Location: ../../indexx.php");
    } else {
        echo "<script>alert('Password tidak sesuai')</script>";
        header("location: ../../pages/auth/login.php?error=Password tidak sesuai");
    }
} else {
    echo "<script>alert('Akun tidak ditemukan')</script>";
    header("location: ../../pages/auth/login.php?error=Akun tidak ditemukan");
}
