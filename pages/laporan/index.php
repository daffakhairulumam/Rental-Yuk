<main id="main" class="main">

    <div class="pagetitle">
        <h1>Mobil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Laporan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Laporan</h5>

                        <div class="text-end mb-3">
                            <a href="">
                                <button type="button" class="btn btn-primary" onclick="window.print()">
                                    Cetak PDF
                                </button>
                            </a>
                        </div>

                        <!-- Table with stripped rows -->
                        <table id="table-mobil">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ID Transaksi</th>
                                    <th>Merek</th>
                                    <th>Kode Mobil</th>
                                    <th>No Polisi</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                include_once './config/koneksi.php';

                                $sql = "SELECT headtrans.id_trans, mobil.kode_mobil, mobil.merek, detailtrans.no_polisi, detailtrans.harga, headtrans.total FROM headtrans INNER JOIN detailtrans ON headtrans.id_trans = detailtrans.id_trans INNER JOIN mobil ON detailtrans.kode_mobil = mobil.kode_mobil;";

                                $data = mysqli_query($koneksi, $sql);

                                foreach ($data as $key => $value) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value['id_trans'] ?></td>
                                        <td><?= $value['kode_mobil'] ?></td>
                                        <td><?= $value['merek'] ?></td>
                                        <td><?= $value['no_polisi'] ?></td>
                                        <td><?= $value['harga'] ?></td>
                                        <td><?= $value['total'] ?></td>
                                    </tr>
                                <?php }
                                ?>
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
        $('#table-mobil').DataTable();
    })
</script>