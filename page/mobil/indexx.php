<main id="main" class="main">

    <div class="pagetitle">
        <h1>Mobil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Mobil</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mobil</h5>

                        <div class="text-end mb-3">
                            <a href="indexx.php?page=mobil/create">
                                <button type="button" class="btn btn-primary">
                                    Tambah
                                </button>
                            </a>
                        </div>

                        <!-- Table with stripped rows -->
                        <table id="table-mobil">
                            <thead>
                                <tr>
                                    <th>Kode Mobil</th>
                                    <th>No Polisi</th>
                                    <th>Merek</th>
                                    <th>Harga</th>
                                    <th>Warna</th>
                                    <th>Status</th>
                                    <th>Gambar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                include_once './config/koneksi.php';

                                $sql = 'SELECT * FROM mobil';

                                $data = mysqli_query($koneksi, $sql);

                                foreach ($data as $key => $value) { ?>
                                    <tr>
                                        <td><?= $value['kode_mobil'] ?></td>
                                        <td><?= $value['no_polisi'] ?></td>
                                        <td><?= $value['merek'] ?></td>
                                        <td><?= $value['harga'] ?></td>
                                        <td><?= $value['warna'] ?></td>
                                        <td><?= $value['status'] ?></td>
                                        <td>
                                            <img src="public/img/product/<?= $value['images'] ?>" width="50px">
                                        </td>
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