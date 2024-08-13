<main id="main" class="main">

    <div class="pagetitle">
        <h1>Mobil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Cetak Struck</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cetak Strcuk</h5>

                        <div class="text-end mb-3">
                            <button class="btn btn-primary" type="button" onclick="window.print()">Cetak Struk</button>
                        </div>

                        <!-- Table with stripped rows -->
                        <table id="table-mobil">
                            <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Kode Mobil</th>
                                    <th>No Polisi</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Subtotal</th>
                                    <th>Bayar</th>
                                    <th>Kembalian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                include_once './config/koneksi.php';

                                $sql = "SELECT headtrans.id_trans, headtrans.tanggal_transaksi, detailtrans.kode_mobil, detailtrans.no_polisi, detailtrans.harga, headtrans.total, detailtrans.subtotal, headtrans.bayar, headtrans.kembalian FROM headtrans INNER JOIN detailtrans ON headtrans.id_trans = detailtrans.id_trans;";

                                $data = mysqli_query($koneksi, $sql);

                                foreach ($data as $key => $value) { ?>
                                    <tr>
                                        <td><?= $value['id_trans'] ?></td>
                                        <td><?= $value['tanggal_transaksi'] ?></td>
                                        <td><?= $value['kode_mobil'] ?></td>
                                        <td><?= $value['no_polisi'] ?></td>
                                        <td><?= $value['harga'] ?></td>
                                        <td><?= $value['total'] ?></td>
                                        <td><?= $value['subtotal'] ?></td>
                                        <td><?= $value['bayar'] ?></td>
                                        <td><?= $value['kembalian'] ?></td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        <div class="col-lg-2 mt-2">
                            <div class="input-group">
                                <a href="indexx.php?page=transaksi">
                                    <button class="btn btn-primary" type="button">Kembali</button>
                                </a>
                            </div>
                        </div>
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