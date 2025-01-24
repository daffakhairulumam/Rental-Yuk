<?php
include_once('../../config/koneksi.php');

$id = $_POST['kode_konsumen'];
$kode = $_POST['kode_konsumen'];
$email = $_POST['email'];
$nik = $_POST['nik'];
$nama = $_POST['nama'];
$kelamin = $_POST['kelamin'];
$alamat = $_POST['alamat'];
$telp = $_POST['telp'];

// Cek apakah email sudah ada
$cek_email = "SELECT * FROM konsumen WHERE email = '$email'";
$result_cek = mysqli_query($koneksi, $cek_email);

if (mysqli_num_rows($result_cek) > 0) { ?>
    <script>
        alert("Email Sudah Ada Yang Pakai");
        window.location = '../../index.php?page=konsumen/create';
    </script>
<?php
    exit();
}

$sql = "INSERT INTO konsumen (kode_konsumen, email, nik, nama, jenis_kelamin, alamat, telp) VALUES ('$kode', '$email', '$nik', '$nama', '$kelamin', '$alamat', '$telp')";

$result = mysqli_query($koneksi, $sql);

if ($result) { ?>
    <script>
        alert("Data Berhasil Ditambahkan");
        window.location = '../../index.php?page=konsumen';
    </script>
<?php
} else { ?>
    <script>
        alert("Gagal Menambahkan Data");
        window.location = '../../index.php?page=konsumen';
    </script>
<?php
}
?>