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
                            <a href="index.php?page=konsumen/create">
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
                                    <th>Kode Konsumen</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>Telp</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                include_once './config/koneksi.php';

                                $sql = 'SELECT * FROM konsumen';

                                $data = mysqli_query($koneksi, $sql);

                                foreach ($data as $key => $value) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value['kode_konsumen'] ?></td>
                                        <td><?= $value['nik'] ?></td>
                                        <td><?= $value['nama'] ?></td>
                                        <td><?= $value['jenis_kelamin'] ?></td>
                                        <td><?= $value['alamat'] ?></td>
                                        <td><?= $value['telp'] ?></td>
                                        <td>
                                            <a href="index.php?page=konsumen/edit&id=<?= $value['id'] ?>">
                                                <button type="button" class="btn btn-primary">
                                                    Edit
                                                </button>
                                            </a>
                                            <p></p>
                                            <a href="logic/konsumen/delete.php?id=<?= $value['id'] ?>" onclick="javascript:return confirm('Hapus Data Barang ?');">
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

</main><!-- End #main -->

<script>
    $(document).ready(function() {
        $('#table-mobil').DataTable();
    })
</script>