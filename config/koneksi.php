<?php

$koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");

if (!$koneksi) {
    die("Connection Failed: " . mysqli_connect_error());
}
return $koneksi;
