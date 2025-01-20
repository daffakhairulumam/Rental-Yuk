<?php

include_once '../../config/koneksi.php';

$id = $_GET['id'];

$sql = "DELETE FROM pesanan WHERE id = $id";

if (mysqli_query($koneksi, $sql)) {
    header("Location: ../../index.php?page=transaksi");
} else {
    echo "Error" . $sql . "<br>" . mysqli_error($koneksi);
}
