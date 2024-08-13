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
    header("Location: ../../index.php?page=mobil/edit&id=$id");
} else {
    if ($ukuran < 1044070) {
        $xx = $rand . '_' . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], '../../public/img/product/' . $xx);

        $sql = "UPDATE mobil SET kode_mobil = '$kode', no_polisi = '$no', merek = '$merek', harga = '$harga', warna = '$warna', status = '$status', images = '$xx' WHERE id = '$id'";

        if (mysqli_query($koneksi, $sql)) {
            header("Location: ../../index.php?page=mobil");
        } else {
            echo "Error" . "<br>" . mysqli_error($koneksi);
        }
    } else {
        header("Location: ../../index.php?page=mobil/edit&id=$id");
    }
}
