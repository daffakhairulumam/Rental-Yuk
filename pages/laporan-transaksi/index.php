<?php
include './config/koneksi.php';

// Get transaction data
$data = getTransaksi();

function getTransaksi($idTransaksi = null)
{
    $conn = mysqli_connect("localhost", "root", "", "rental_mobil");

    if ($idTransaksi) {
        $query = "SELECT headtrans.id_trans, headtrans.tanggal_transaksi, GROUP_CONCAT(detailtrans.kode_mobil SEPARATOR ', ') AS kode_mobil, GROUP_CONCAT(mobil.merek SEPARATOR ', ') AS merek, GROUP_CONCAT(mobil.warna SEPARATOR ', ') AS warna, GROUP_CONCAT(mobil.status SEPARATOR ', ') AS status, GROUP_CONCAT(mobil.images SEPARATOR ', ') AS images, GROUP_CONCAT(detailtrans.no_polisi SEPARATOR ', ') AS no_polisi, GROUP_CONCAT(detailtrans.tgl_pinjam SEPARATOR ', ') AS tgl_pinjam, GROUP_CONCAT(detailtrans.tgl_kembali SEPARATOR ', ') AS tgl_kembali, GROUP_CONCAT(detailtrans.harga SEPARATOR ', ') AS harga_mobil, headtrans.total, konsumen.kode_konsumen, konsumen.email, konsumen.nama, konsumen.nik, konsumen.jenis_kelamin, konsumen.alamat, konsumen.telp FROM headtrans INNER JOIN detailtrans ON headtrans.id_trans = detailtrans.id_trans INNER JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil INNER JOIN konsumen ON detailtrans.kode_konsumen = konsumen.kode_konsumen WHERE headtrans.id_trans = '$idTransaksi' GROUP BY headtrans.id_trans";
    } else {
        $query = "SELECT headtrans.id_trans, headtrans.tanggal_transaksi, GROUP_CONCAT(detailtrans.kode_mobil SEPARATOR ', ') AS kode_mobil, GROUP_CONCAT(mobil.merek SEPARATOR ', ') AS merek, GROUP_CONCAT(mobil.warna SEPARATOR ', ') AS warna, GROUP_CONCAT(mobil.status SEPARATOR ', ') AS status, GROUP_CONCAT(mobil.images SEPARATOR ', ') AS images, GROUP_CONCAT(detailtrans.no_polisi SEPARATOR ', ') AS no_polisi, GROUP_CONCAT(detailtrans.tgl_pinjam SEPARATOR ', ') AS tgl_pinjam, GROUP_CONCAT(detailtrans.tgl_kembali SEPARATOR ', ') AS tgl_kembali, GROUP_CONCAT(detailtrans.harga SEPARATOR ', ') AS harga_mobil, headtrans.total, konsumen.kode_konsumen, konsumen.email, konsumen.nama, konsumen.nik, konsumen.jenis_kelamin, konsumen.alamat, konsumen.telp FROM headtrans INNER JOIN detailtrans ON headtrans.id_trans = detailtrans.id_trans INNER JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil INNER JOIN konsumen ON detailtrans.kode_konsumen = konsumen.kode_konsumen GROUP BY headtrans.id_trans";
    }

    $result = mysqli_query($conn, $query);
    $data = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    return $data;
}
?>

<style>
    .konsumen-detail,
    .mobil-detail {
        color: black !important;
        text-decoration: none;
        cursor: pointer;
    }

    .konsumen-detail:hover,
    .mobil-detail:hover {
        color: #444 !important;
    }

    .car-details {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .car-image img {
        height: 300px;
        object-fit: cover;
        width: 100%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .gap-3 {
        gap: 1rem;
    }

    #mobilModal .modal-lg {
        max-width: 800px;
    }
</style>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Laporan Transaksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Laporan Transaksi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Laporan Transaksi</h5>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Awal</label>
                                <input type="date" id="min" name="min" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Akhir</label>
                                <input type="date" id="max" name="max" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <button id="resetFilter" class="btn btn-secondary form-control">Reset Filter</button>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <a href="logic/detail-laporan/xlshtml.php" class="btn btn-success form-control">Cetak Excel</a>
                                <!-- <label class="form-label">&nbsp;</label>
                                <a href="logic/detail-laporan/fpdf.php?id_transaksi=<?= $idTransaksi ?>" target="_blank" class="btn btn-primary form-control">Cetak PDF</a> -->
                            </div>
                        </div>

                        <table id="table-transaksi">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ID Transaksi</th>
                                    <th>Kode Konsumen</th>
                                    <th>Nama Konsumen</th>
                                    <th>Kode Mobil</th>
                                    <th>No Polisi</th>
                                    <!-- <th>Nama Mobil</th> -->
                                    <th>Tanggal Transaksi</th>
                                    <!-- <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th> -->
                                    <th>Harga Mobil</th>
                                    <th>Total</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data as $key => $value) {

                                    $hargaMobilArray = explode(', ', $value['harga_mobil']);

                                    // Create a formatted list of prices
                                    $hargaMobilFormatted = implode(', ', array_map(function ($harga) {
                                        return 'Rp. ' . number_format((float)$harga, 0, ',', '.');
                                    }, $hargaMobilArray));
                                ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value['id_trans'] ?></td>
                                        <td>
                                            <a href="#" class="konsumen-detail"
                                                data-kode="<?= $value['kode_konsumen'] ?>"
                                                data-email="<?= $value['email'] ?>"
                                                data-nama="<?= $value['nama'] ?>"
                                                data-nik="<?= $value['nik'] ?>"
                                                data-jk="<?= $value['jenis_kelamin'] ?>"
                                                data-alamat="<?= $value['alamat'] ?>"
                                                data-telp="<?= $value['telp'] ?>"><?= $value['kode_konsumen'] ?>
                                            </a>
                                        </td>
                                        <td><?= $value['nama'] ?></td>
                                        <td>
                                            <a href="#" class="mobil-detail"
                                                data-kode="<?= $value['kode_mobil'] ?>"
                                                data-no="<?= $value['no_polisi'] ?>"
                                                data-merek="<?= $value['merek'] ?>"
                                                data-warna="<?= ($value['warna'] ?? '') ?>"
                                                data-harga="<?= $hargaMobilFormatted ?>"
                                                data-pinjam="<?= $value['tgl_pinjam'] ?>"
                                                data-kembali="<?= $value['tgl_kembali'] ?>"
                                                data-status="<?= ($value['status'] ?? '') ?>"
                                                data-images="<?= ($value['images'] ?? '') ?>">
                                                <?= $value['kode_mobil'] ?>
                                            </a>
                                        </td>
                                        <td><?= $value['no_polisi'] ?></td>
                                        <!-- <td><?= $value['merek'] ?></td> -->
                                        <!-- <td><?= $value['tanggal_transaksi'] ?></td> -->
                                        <td><?= date('d-m-Y', strtotime($value['tanggal_transaksi'])) ?></td>
                                        <!-- <td><?= $value['tgl_pinjam'] ?></td>
                                        <td><?= $value['tgl_kembali'] ?></td> -->
                                        <td><?= $hargaMobilFormatted ?></td>
                                        <!-- <td>Rp. <?= number_format((float)$value['harga'], 0, ',', '.') ?></td> -->
                                        <td>Rp. <?= number_format((float)$value['total'], 0, ',', '.') ?></td>
                                        <!-- <td>
                                            <a href="index.php?page=laporan-transaksi/detail&id_transaksi=<?= $value['id_trans'] ?>">
                                                <button type="button" class="btn btn-primary">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </a>
                                        </td> -->
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<!-- Modal Konsumen -->
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
                        <th>Email</th>
                        <td id="modalEmail"></td>
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
<!-- End Modal Konsumen -->

<!-- Modal Mobil -->
<div class="modal fade" id="mobilModal" tabindex="-1" aria-labelledby="mobilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mobilModalLabel">Detail Mobil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Container for car details -->
                <div id="carDetailsContainer"></div>

                <!-- Container for images -->
                <div class="mt-4">
                    <h6 class="mb-3"></h6>
                    <div id="modalImages"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        var table = $('#table-transaksi').DataTable({
            columnDefs: [{
                targets: 6,
                type: 'date'
            }]
        });

        // Custom date range filtering function
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var min = $('#min').val();
            var max = $('#max').val();

            // Get date from the table
            var dateStr = data[6]; // index 6 adalah kolom Tanggal Transaksi

            // Convert date string to Date object
            var dateParts = dateStr.split('-');
            var date = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
            date.setHours(0, 0, 0, 0); // Set waktu ke 00:00:00

            // Convert input dates to Date objects and set appropriate times
            var minDate = min ? new Date(min) : null;
            var maxDate = max ? new Date(max) : null;

            if (minDate) minDate.setHours(0, 0, 0, 0); // Set waktu awal ke 00:00:00
            if (maxDate) maxDate.setHours(23, 59, 59, 999); // Set waktu akhir ke 23:59:59

            // If no filter is set
            if (!min && !max) {
                return true;
            }

            // Check if date is within the selected range
            if (minDate && maxDate) {
                return date.getTime() >= minDate.getTime() && date.getTime() <= maxDate.getTime();
            } else if (minDate) {
                return date.getTime() >= minDate.getTime();
            } else if (maxDate) {
                return date.getTime() <= maxDate.getTime();
            }

            return true;
        });

        // Event listener for date inputs
        $('#min, #max').on('change', function() {
            table.draw();
        });

        // Reset filter button
        $('#resetFilter').on('click', function() {
            $('#min').val('');
            $('#max').val('');
            table.draw();
        });

        // Modify the Excel export button click handler
        $('.btn-success').click(function(e) {
            e.preventDefault();
            var startDate = $('#min').val();
            var endDate = $('#max').val();
            var url = 'logic/detail-laporan/xlshtml.php';

            // Add date parameters if they exist
            if (startDate && endDate) {
                url += '?start_date=' + startDate + '&end_date=' + endDate;
            }

            window.location.href = url;
        });

        // Handle click on customer code
        $('.konsumen-detail').click(function(e) {
            e.preventDefault();
            var kode = $(this).data('kode');
            var email = $(this).data('email');
            var nama = $(this).data('nama');
            var nik = $(this).data('nik');
            var jk = $(this).data('jk');
            var alamat = $(this).data('alamat');
            var telp = $(this).data('telp');

            // Set modal content
            $('#modalKodeKonsumen').text(kode);
            $('#modalEmail').text(email);
            $('#modalNik').text(nik);
            $('#modalNama').text(nama);
            $('#modalJenisKelamin').text(jk);
            $('#modalAlamat').text(alamat);
            $('#modalTelp').text(telp);

            // Show modal
            $('#konsumenModal').modal('show');
        });

        // Handle click on car code
        $('.mobil-detail').click(function(e) {
            e.preventDefault();
            var kode = $(this).data('kode');
            var merek = $(this).data('merek');
            var warna = $(this).data('warna');
            var harga = $(this).data('harga');
            var pinjam = $(this).data('pinjam');
            var kembali = $(this).data('kembali');
            var status = $(this).data('status');
            var noPolisi = $(this).data('no');
            var images = $(this).data('images');

            // Split values if they contain commas
            var kodeArray = kode.split(', ');
            var merekArray = merek.split(', ');
            var warnaArray = warna ? warna.split(', ') : [];
            var hargaArray = harga ? harga.split(', ') : [];
            var pinjamArray = pinjam ? pinjam.split(', ') : [];
            var kembaliArray = kembali ? kembali.split(', ') : [];
            var statusArray = status ? status.split(', ') : [];
            var noPolisiArray = noPolisi.split(', ');
            var imagesArray = images ? images.split(', ') : [];

            // Clear previous content
            $('#carDetailsContainer').empty();

            // Create content for each car
            var contentHtml = '';
            for (let i = 0; i < kodeArray.length; i++) {
                contentHtml += `
        <div class="car-details mb-4 row ${i !== 0 ? 'border-top pt-4' : ''}">
            <div class="col-md-8">
                <h6 class="text-primary">Mobil ${i + 1}</h6>
                <div class="row mb-2">
                    <div class="col-5"><strong>Kode Mobil:</strong></div>
                    <div class="col-7">${kodeArray[i]}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><strong>Nama Mobil:</strong></div>
                    <div class="col-7">${merekArray[i]}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><strong>No Polisi:</strong></div>
                    <div class="col-7">${noPolisiArray[i]}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><strong>Warna:</strong></div>
                    <div class="col-7">${warnaArray[i] || 'Tidak tersedia'}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><strong>Harga:</strong></div>
                    <div class="col-7">${hargaArray[i] || 'Tidak tersedia'}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><strong>Tanggal Pinjam:</strong></div>
                    <div class="col-7">${pinjamArray[i] || 'Tidak tersedia'}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><strong>Tanggal Kembali:</strong></div>
                    <div class="col-7">${kembaliArray[i] || 'Tidak tersedia'}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><strong>Status:</strong></div>
                    <div class="col-7">${statusArray[i] || 'Tidak tersedia'}</div>
                </div>
            </div>
            <div class="col-md-4">
                ${imagesArray[i] && imagesArray[i].trim() !== '' ? `
                <img src="public/img/product/${imagesArray[i].trim()}" 
                     alt="${merekArray[i]}" 
                     class="img-fluid rounded"
                     style="width: 100%; height: 250px; object-fit: cover;">
                     <i><p class="text-center mt-2"><small>Gambar Mobil</small></p></i>
                     <p class="text-center mt-2"><small>${merekArray[i]}</small></p>
                ` : ''}
            </div>
        </div>`;
            }

            // Display car details
            $('#carDetailsContainer').html(contentHtml);

            // Show modal
            $('#mobilModal').modal('show');
        });
    });
</script>