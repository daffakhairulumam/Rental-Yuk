<?php

include_once '../../config/koneksi.php';

$id = $_GET['id'];

$sql = "DELETE FROM mobil WHERE id = $id";

if (mysqli_query($koneksi, $sql)) {
    header("Location: ../../index.php?page=mobil");
} else {
    echo "Error" . $sql . "<br>" . mysqli_error($koneksi);
}
