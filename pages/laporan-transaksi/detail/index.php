<?php
include_once './config/koneksi.php';

$id_transaksi = $_GET['id_transaksi'];
$data = getTransaksi($id_transaksi);

function getTransaksi($idTransaksi = null)
{
    $conn = mysqli_connect("localhost", "root", "", "rental_mobil");

    if ($idTransaksi) {
        $query = "SELECT detailtrans.*, mobil.merek AS nama_mobil, mobil.harga AS harga_mobil, konsumen.nama AS nama_konsumen, konsumen.nik, konsumen.jenis_kelamin, konsumen.alamat, konsumen.telp FROM detailtrans JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil JOIN konsumen ON detailtrans.kode_konsumen = konsumen.kode_konsumen WHERE detailtrans.id_trans = '$idTransaksi' ORDER BY detailtrans.kode_mobil ASC";
    } else {
        $query = "SELECT * FROM headtrans";
    }

    $result = mysqli_query($conn, $query);
    return $result;
}
?>

<style>
    .konsumen-detail {
        color: black !important;
        text-decoration: none;
        cursor: pointer;
    }

    .konsumen-detail:hover {
        color: #444 !important;
    }
</style>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Transaksi</h5>

                        <div class="text-end mb-3">
                            <a href="logic/detail-laporan/xxlshtml.php?id_transaksi=<?= $id_transaksi ?>">
                                <button type="button" class="btn btn-success">
                                    Cetak Excel
                                </button>
                            </a>
                        </div>

                        <table id="table-detail">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ID Transaksi</th>
                                    <th>Kode Konsumen</th>
                                    <th>Kode Mobil</th>
                                    <th>No Polisi</th>
                                    <th>Nama Mobil</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $key => $value) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value['id_trans'] ?></td>
                                        <td>
                                            <span class="konsumen-detail"
                                                data-kode="<?= $value['kode_konsumen'] ?>"
                                                data-nama="<?= $value['nama_konsumen'] ?>"
                                                data-nik="<?= $value['nik'] ?>"
                                                data-jk="<?= $value['jenis_kelamin'] ?>"
                                                data-alamat="<?= $value['alamat'] ?>"
                                                data-telp="<?= $value['telp'] ?>">
                                                <?= $value['kode_konsumen'] ?>
                                            </span>
                                        </td>
                                        <td><?= $value['kode_mobil'] ?></td>
                                        <td><?= $value['no_polisi'] ?></td>
                                        <td><?= $value['nama_mobil'] ?></td>
                                        <td><?= $value['tgl_pinjam'] ?></td>
                                        <td><?= $value['tgl_kembali'] ?></td>
                                        <td><?= number_format($value['harga_mobil'], 0, ',', '.') ?></td>
                                        <td><?= number_format($value['subtotal'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <div class="text-end mt-3">
                            <a href="index.php?page=laporan-transaksi">
                                <button type="button" class="btn btn-secondary">
                                    Kembali
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal -->
<div class="modal fade" id="konsumenModal" tabindex="-1" aria-labelledby="konsumenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="konsumenModalLabel">Detail Konsumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>Kode Konsumen</th>
                        <td id="modalKodeKonsumen"></td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td id="modalNik"></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td id="modalNama"></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td id="modalJenisKelamin"></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td id="modalAlamat"></td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td id="modalTelp"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table-detail').DataTable();

        // Handle click on customer code
        $('.konsumen-detail').click(function(e) {
            // Get data from data attributes
            var kode = $(this).data('kode');
            var nama = $(this).data('nama');
            var nik = $(this).data('nik');
            var jk = $(this).data('jk');
            var alamat = $(this).data('alamat');
            var telp = $(this).data('telp');

            // Set modal content
            $('#modalKodeKonsumen').text(kode);
            $('#modalNik').text(nik);
            $('#modalNama').text(nama);
            $('#modalJenisKelamin').text(jk);
            $('#modalAlamat').text(alamat);
            $('#modalTelp').text(telp);

            // Show modal
            $('#konsumenModal').modal('show');
        });
    });
</script>