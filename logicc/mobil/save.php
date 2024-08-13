<?php

include_once('../../config/koneksi.php');

$id = $_POST['id'];
$kode = $_POST['kode'];
$no = $_POST['no'];
$merek = $_POST['merek'];
$harga = $_POST['harga'];
$warna = $_POST['warna'];
$status = $_POST['status'];

//upload gambar 

$rand = rand();
$ekstensi = array('jpg', 'jpeg', 'png');
$filename = $_FILES['image']['name'];
$ukuran = $_FILES['image']['size'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if (!in_array($ext, $ekstensi)) {
    header("Location: ../../indexx.php?page=mobil/create");
} else {
    if ($ukuran < 1044070) {
        $xx = $rand . '_' . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], '../../public/img/product/' . $xx);

        $sql = "INSERT INTO mobil (id, kode_mobil, no_polisi, merek, harga, warna, status, images) VALUES ('$id', '$kode', '$no', '$merek', '$harga', '$warna', '$status', '$xx')";

        if (mysqli_query($koneksi, $sql)) {
            header("Location: ../../indexx.php?page=mobil");
        } else {
            echo "Error" . "<br>" . mysqli_error($koneksi);
        }
    } else {
        header("Location: ../../indexx.php?page=mobil/create");
    }
}
