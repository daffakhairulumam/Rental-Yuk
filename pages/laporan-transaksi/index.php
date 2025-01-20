<?php
include('./config/koneksi.php');

// Ambil nilai ID Transaksi dari query string jika ada
$idTransaksi = isset($_GET['id_transaksi']) ? $_GET['id_transaksi'] : null;
$data = getTransaksi($idTransaksi);

function getTransaksi($idTransaksi = null)
{
    $conn = mysqli_connect("localhost", "root", "", "rental_mobil");

    if ($idTransaksi) {
        $query = "SELECT headtrans.id_trans, headtrans.tanggal_transaksi, mobil.kode_mobil, mobil.merek, detailtrans.no_polisi, detailtrans.tgl_pinjam, detailtrans.tgl_kembali, detailtrans.harga, headtrans.total FROM headtrans INNER JOIN detailtrans ON headtrans.id_trans = detailtrans.id_trans INNER JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil WHERE headtrans.id_trans = '$idTransaksi'";
    } else {
        $query = "SELECT * FROM headtrans";
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


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Laporan Transaksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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
                                    <!-- <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th> -->
                                    <th>Total</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data as $key => $value) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value['id_trans'] ?></td>
                                        <!-- <td><?= $value['tgl_pinjam'] ?></td>
                                        <td><?= $value['tgl_kembali'] ?></td> -->
                                        <td><?= number_format($value['total'], 0, ',', '.') ?></td>
                                        <td><?= $value['tanggal_transaksi'] ?></td>
                                        <td>
                                            <a href="index.php?page=laporan-transaksi/detail&id_transaksi=<?= $value['id_trans'] ?>">
                                                <button type="button" class="btn btn-primary">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </a>
                                        </td>
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

<script>
    $(document).ready(function() {
        // Initialize DataTable with date sorting
        var table = $('#table-transaksi').DataTable({
            columnDefs: [{
                // Target the date column (index 3 - Tanggal Transaksi)
                targets: 3,
                render: function(data, type, row) {
                    // For sorting/filtering, convert to YYYY-MM-DD format
                    if (type === 'sort' || type === 'filter') {
                        var dateParts = data.split('-');
                        if (dateParts.length === 3) {
                            return dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];
                        }
                        return data;
                    }
                    // For display, keep original format
                    return data;
                }
            }]
        });

        // Custom date range filtering function
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var min = $('#min').val();
            var max = $('#max').val();

            // If no filter is set, show all rows
            if (!min && !max) {
                return true;
            }

            // Get date from the correct column (index 3 - Tanggal Transaksi)
            var dateStr = data[3];

            // Convert date string to Date object (assuming DD-MM-YYYY format)
            var dateParts = dateStr.split('-');
            var date = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);

            // Validate date
            if (!isNaN(date.getTime())) {
                // Convert min date
                if (min) {
                    var minDate = new Date(min);
                    minDate.setHours(0, 0, 0, 0);
                    if (date < minDate) {
                        return false;
                    }
                }

                // Convert max date
                if (max) {
                    var maxDate = new Date(max);
                    maxDate.setHours(23, 59, 59, 999);
                    if (date > maxDate) {
                        return false;
                    }
                }
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
    });
</script>