<?php
include_once './config/koneksi.php';

$idTrans = genereteCodeTransaksi();
$pesanan = getPesanan($idTrans);
$total = 0;
$idTransaksiPrevous = '';
$kodeKonsumen = '';

if (!empty($_GET['id_transaksi'])) {
    $idTransaksiPrevous = $_GET['id_transaksi'];
    $disabledCetak = '';
    $kodeKonsumen = getKodeKonsumen($idTransaksiPrevous);
} else {
    $disabledCetak = 'disabled';
}

function genereteCodeTransaksi()
{
    $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");
    $query = "SELECT max(id_trans) as kode FROM headtrans";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);
    $codeTrans = $data['kode'];

    $noUrut = (int) substr($codeTrans, 3, 3);
    $noUrut++;

    $char = "TRX";
    $newID = $char . sprintf("%03s", $noUrut);

    return $newID;
}

function getPesanan($idTrans = null)
{
    $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");

    if ($idTrans) {
        $query = "SELECT * FROM pesanan JOIN mobil ON pesanan.kode_mobil = mobil.kode_mobil WHERE pesanan.id_transaksi = '$idTrans'";
    }

    $result = mysqli_query($koneksi, $query);

    return $result;
}

function getKodeKonsumen($idTransaksi)
{
    $koneksi = mysqli_connect("localhost", "root", "", "rental_mobil");
    $query = "SELECT kode_konsumen FROM pesanan WHERE id_transaksi = '$idTransaksi' LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    return $data['kode_konsumen'];
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Mobil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Transaksi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi</h5>

                        <?php if (isset($_GET['alert'])) : ?>
                            <?php if ($_GET['alert'] == 'berhasil_transaksi') : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Berhasil
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php elseif ($_GET['alert'] == 'gagal_transaksi') : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Gagal
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <form action="logic/pesanan/save.php" method="post" class="" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label class="input-group-text">Kode Mobil</label>
                                        <select class="form-select" name="kode_mobil" id="kodeMobil" onchange="updateImage()">
                                            <option value="" data-image="" data-merek="" data-harga="" data-status="">--Pilih--</option>
                                            <?php
                                            $sql = 'SELECT * FROM mobil';
                                            $result = mysqli_query($koneksi, $sql);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $disabled = ($row['status'] === 'Sedang Di Sewa' || $row['status'] === 'Sedang Di Pakai') ? 'disabled' : '';
                                            ?>
                                                <option
                                                    value="<?= $row['kode_mobil'] ?>"
                                                    data-image="<?= $row['images'] ?>"
                                                    data-merek="<?= $row['merek'] ?>"
                                                    data-harga="<?= $row['harga'] ?>"
                                                    data-status="<?= $row['status'] ?>"
                                                    <?= $disabled ?>>
                                                    <?= $row['kode_mobil'] ?> <?= $row['merek'] ?> || Rp.<?= $row['harga'] ?> (<?= $row['status'] ?>)
                                                </option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label class="input-group-text">ID Transaksi</label>
                                        <input type="text" class="form-control" name="id_transaksi" id="id_transaksi" value="<?= $idTrans ?>" readonly>
                                        <div id="mobilPreview" style="margin-top: 20px;">
                                            <img id="mobilImage" src="" alt="Preview Mobil" width="30%" style="max-width: 100%; height: auto; display: none;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label class="input-group-text">Kode Konsumen</label>
                                        <select class="form-select" name="kode_konsumen">
                                            <option>--Pilih--</option>
                                            <?php
                                            $sql = 'SELECT * FROM konsumen';
                                            $result = mysqli_query($koneksi, $sql);

                                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                                <option value="<?= $row['kode_konsumen'] ?>"><?= $row['kode_konsumen'] ?> - <?= $row['nik'] ?> || <?= $row['nama'] ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label class="input-group-text">Tanggal Pinjam</label>
                                        <input type="date" name="tgl_pinjam" class="form form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label class="input-group-text">Tanggal Kembali</label>
                                        <input type="date" name="tgl_kembali" class="form form-control">
                                    </div>
                                    <br>
                                    <button type="submit" name="Submit" class="btn btn-primary">SIMPAN</button>
                                </div>
                            </div>
                        </form>

                        <!-- Table with stripped rows -->
                        <table class="table table-bordered" id="table-transaksi">
                            <thead>
                                <tr>
                                    <th>Kode Konsumen</th>
                                    <th>Kode Mobil</th>
                                    <th>No Polisi</th>
                                    <th>Harga</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Total</th>
                                    <th>Gambar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT p.id, p.id_transaksi, p.kode_konsumen, p.kode_mobil, p.no_polisi, p.tgl_pinjam, p.tgl_kembali, p.harga, p.total, m.images, (SELECT SUM(total) FROM pesanan) AS totalseluruh FROM pesanan p INNER JOIN mobil m ON p.kode_mobil = m.kode_mobil";
                                $result = mysqli_query($koneksi, $query);

                                foreach ($result as $key => $value) {
                                    $total += $value['total']; // Hitung total
                                ?>
                                    <tr>
                                        <td><?= $value['kode_konsumen'] ?></td>
                                        <td><?= $value['kode_mobil'] ?></td>
                                        <td><?= $value['no_polisi'] ?></td>
                                        <td>Rp.<?= number_format($value['harga'], 0, ',', '.') ?></td>
                                        <td><?= $value['tgl_pinjam'] ?></td>
                                        <td><?= $value['tgl_kembali'] ?></td>
                                        <td>Rp.<?= number_format($value['total'], 0, ',', '.') ?></td>
                                        <td>
                                            <img src="public/img/product/<?= $value['images'] ?>" width="100px">
                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="modalMasa(<?= $value['id'] ?>, '<?= $value['id_transaksi'] ?>', '<?= $value['kode_mobil'] ?>', '<?= $value['tgl_pinjam'] ?>', '<?= $value['tgl_kembali'] ?>')">
                                                Update Masa Sewa
                                            </button>
                                            <p></p>
                                            <a href="logic/pesanan/delete.php?id=<?= $value['id'] ?>" onclick="javascript:return confirm('Hapus Data Mobil ?');">
                                                <button type="button" class="btn btn-primary">
                                                    Hapus
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <label class="input-group-text">Total</label>
                                    <input type="text" class="form-control" id="total" value="Rp.<?= number_format($total, 0, ',', '.') ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <label class="input-group-text">Bayar</label>
                                    <input type="text" class="form-control" id="bayar" onkeyup="kembalian()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <label class="input-group-text">Kembalian</label>
                                    <input type="text" class="form-control" id="kembalian" readonly>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <button class="btn btn-primary" type="button" onclick="MyFunction()">Bayar</button>
                                </div>
                            </div>
                            <div class="col-lg-2 mt-2">
                                <div class="input-group">
                                    <a href="logic/transaksi/cetak.php?id_transaksi=<?= $idTransaksiPrevous ?>" target="_blank">
                                        <button class="btn btn-primary" type="button" id="cetak-struk" <?= $disabledCetak ?>>Cetak Struk <?= $idTransaksiPrevous ?></button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>

    <!-- Modal Bayar -->
    <div class="modal fade" id="modalBayar" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bayar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="logic/transaksi/save.php" method="POST" id="payment-form">
                        <?php
                        // Ambil kode konsumen dari pesanan berdasarkan id_transaksi
                        $idTrans = isset($_GET['id_transaksi']) ? $_GET['id_transaksi'] : $idTrans;
                        $queryKonsumen = "SELECT DISTINCT kode_konsumen FROM pesanan WHERE id_transaksi = '$idTrans' LIMIT 1";
                        $resultKonsumen = mysqli_query($koneksi, $queryKonsumen);
                        $dataKonsumen = mysqli_fetch_assoc($resultKonsumen);
                        $kodeKonsumen = $dataKonsumen['kode_konsumen'] ?? '';
                        ?>

                        <!-- Hidden input untuk kode konsumen -->
                        <input type="hidden" name="kode_konsumen" value="<?= $kodeKonsumen ?>">

                        <div class="form-group mb-3">
                            <input type="hidden" name="id_transaksi" id="id_transaksi2">
                            <input type="hidden" name="total" id="total2" value="<?= $total ?>">
                            <input type="number" name="bayar" id="bayar2" class="form-control" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label>Kembalian</label>
                            <input type="number" name="kembalian" id="kembalian2" class="form-control" readonly>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="Submit" class="btn btn-success">Bayar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Bayar -->

    <!-- Modal Qty -->
    <div class="modal fade" id="modalMasa" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Qty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="logic/pesanan/update.php" method="POST">
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <input type="hidden" name="id" id="modal-id">
                                <input type="hidden" name="id_transaksi" id="modal-id_transaksi">
                                <input type="hidden" name="kode_mobil" id="modal-kode_mobil">
                                <label class="input-group-text">Tanggal Pinjam</label>
                                <input type="date" name="tgl_pinjam" class="form form-control" id="modal-tgl_pinjam">
                                <label class="input-group-text">Tanggal Kembali</label>
                                <input type="date" name="tgl_kembali" class="form form-control" id="modal-tgl_kembali">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <button type="submit" name="Submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Menu -->

</main>
<!-- End #main -->

<script>
    $(document).ready(function() {
        $('#table-transaksi').DataTable();
    })

    function kembalian() {
        var bayar = $('#bayar').val();
        var total = $('#total').val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
        var kembalian = bayar - total;

        $('#kembalian').val(kembalian);
    }

    function MyFunction() {
        var bayar = $('#bayar').val();
        var total = $('#total').val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
        var idTransaksi = $('#id_transaksi').val();

        var kembalian = bayar - total;

        if (total <= 0) {
            alert('Total Sewa Harus Lebih Dari 0');
            return false;
        }
        if (kembalian < 0) {
            alert('Uang Anda Kurang');
            return false;
        }

        $('#modalBayar').modal('show');

        $('#id_transaksi2').val(idTransaksi);
        $('#total2').val(total);
        $('#bayar2').val(bayar);
        $('#kembalian2').val(kembalian);
    }

    function modalMasa(id, id_transaksi, kode_mobil, tgl_pinjam, tgl_kembali) {
        $('#modalMasa').modal('show');
        $('#modal-id').val(id);
        $('#modal-id_transaksi').val(id_transaksi);
        $('#modal-kode_mobil').val(kode_mobil);
        $('#modal-tgl_pinjam').val(tgl_pinjam);
        $('#modal-tgl_kembali').val(tgl_kembali);
    }

    // JavaScript untuk memperbarui gambar saat opsi dipilih
    function updateImage() {
        const select = document.getElementById('kodeMobil');
        const selectedOption = select.options[select.selectedIndex];

        const imagePath = selectedOption.getAttribute('data-image'); // Ambil path gambar dari atribut
        const imageElement = document.getElementById('mobilImage');

        if (imagePath) {
            imageElement.src = `public/img/product/${imagePath}`; // Ubah path sesuai direktori gambar Anda
            imageElement.style.display = 'block';
        } else {
            imageElement.src = '';
            imageElement.style.display = 'none';
        }
    }
</script>