<main id="main" class="main">

    <div class="pagetitle">
        <h1>Mobil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
                            <a href="index.php?page=mobil/create">
                                <button type="button" class="btn btn-primary">
                                    Tambah
                                </button>
                            </a>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table table-bordered" id="table-mobil">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Mobil</th>
                                    <th>No Polisi</th>
                                    <th>Nama Mobil</th>
                                    <th>Harga</th>
                                    <th>Warna</th>
                                    <th>Status</th>
                                    <th>Gambar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                include_once './config/koneksi.php';

                                $sql = 'SELECT * FROM mobil';

                                $data = mysqli_query($koneksi, $sql);

                                foreach ($data as $key => $value) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value['kode_mobil'] ?></td>
                                        <td><?= $value['no_polisi'] ?></td>
                                        <td><?= $value['merek'] ?></td>
                                        <td>Rp. <?= number_format($value['harga'], 0, ',', '.') ?></td>
                                        <td><?= $value['warna'] ?></td>
                                        <td>
                                            <?php
                                            if ($value['status'] == 'Tersedia') { ?>
                                                <span class="badge bg-success"><?= $value['status'] ?></span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger"><?= $value['status'] ?></span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <img src="public/img/product/<?= $value['images'] ?>"
                                                width="100px"
                                                class="car-image"
                                                style="cursor: pointer;"
                                                data-merek="<?= $value['merek'] ?>">
                                        </td>
                                        <td>
                                            <a href="index.php?page=mobil/edit&id=<?= $value['id'] ?>">
                                                <button type="button" class="btn btn-primary">
                                                    Edit
                                                </button>
                                            </a>
                                            <p></p>
                                            <a href="logic/mobil/delete.php?id=<?= $value['id'] ?>" onclick="javascript:return confirm('Hapus Data Barang ?');">
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

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Tambahkan Modal untuk Popup Gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Detail Gambar Mobil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Gambar Mobil" style="max-width: 100%; height: auto;">
                    <p class="mt-2"><i>Gambar Mobil - <span id="modalCarName"></span></i></p>
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->

<script>
    $(document).ready(function() {
        $('#table-mobil').DataTable();

        // Menangani klik pada gambar
        $('.car-image').click(function() {
            // Mendapatkan URL gambar dan merek mobil yang diklik
            var imageUrl = $(this).attr('src');
            var carMerek = $(this).data('merek');

            // Mengatur URL gambar dan merek ke dalam modal
            $('#modalImage').attr('src', imageUrl);
            $('#modalCarName').text(carMerek);

            // Menampilkan modal
            $('#imageModal').modal('show');
        });
    })
</script>