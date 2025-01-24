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
                            <a href="index.php?page=konsumen/create">
                                <button type="button" class="btn btn-primary">
                                    Tambah
                                </button>
                            </a>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table table-bordered" id="table-konsumen">
                            <thead>
                                <tr>
                                    <!-- <th>No.</th> -->
                                    <th>Kode Konsumen</th>
                                    <th>Email</th>
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
                                        <!-- <td><?= $key + 1 ?></td> -->
                                        <td><?= $value['kode_konsumen'] ?></td>
                                        <td><?= $value['email'] ?></td>
                                        <td><?= $value['nik'] ?></td>
                                        <td><?= $value['nama'] ?></td>
                                        <td><?= $value['jenis_kelamin'] ?></td>
                                        <td><?= $value['alamat'] ?></td>
                                        <td><?= $value['telp'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary mb-2 preview-btn" data-bs-toggle="modal" data-bs-target="#printPreviewModal"
                                                data-kode="<?= $value['kode_konsumen'] ?>"
                                                data-email="<?= $value['email'] ?>"
                                                data-nik="<?= $value['nik'] ?>"
                                                data-nama="<?= $value['nama'] ?>"
                                                data-jk="<?= $value['jenis_kelamin'] ?>"
                                                data-alamat="<?= $value['alamat'] ?>"
                                                data-telp="<?= $value['telp'] ?>">
                                                <i class="bi bi-eye"></i>
                                            </button>
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

    <div class="modal fade" id="printPreviewModal" tabindex="-1" aria-labelledby="printPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printPreviewModalLabel">Preview Data Konsumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h4>Data Konsumen</h4>
                    </div>
                    <div class="preview-content">
                        <p><strong>Kode Konsumen:</strong> <span id="preview-kode"></span></p>
                        <p><strong>Email:</strong> <span id="preview-email"></span></p>
                        <p><strong>NIK:</strong> <span id="preview-nik"></span></p>
                        <p><strong>Nama:</strong> <span id="preview-nama"></span></p>
                        <p><strong>Jenis Kelamin:</strong> <span id="preview-jk"></span></p>
                        <p><strong>Alamat:</strong> <span id="preview-alamat"></span></p>
                        <p><strong>No. Telepon:</strong> <span id="preview-telp"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="logic/detail-laporan/pdf.php?kode_konsumen=<?= $value['kode_konsumen'] ?>" target="_blank">
                        <button type="button" class="btn btn-primary">Cetak</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->

<script>
    $(document).ready(function() {
        $('#table-konsumen').DataTable();

        // const today = new Date();
        // const dateString = today.toLocaleDateString('id-ID', {
        //     day: 'numeric',
        //     month: 'long',
        //     year: 'numeric'
        // });
        // $('#printDate').text(dateString);

        // Handle preview button click
        $('.preview-btn').click(function() {
            const data = $(this).data();

            // Populate modal with data
            $('#preview-kode').text(data.kode);
            $('#preview-email').text(data.email);
            $('#preview-nik').text(data.nik);
            $('#preview-nama').text(data.nama);
            $('#preview-jk').text(data.jk);
            $('#preview-alamat').text(data.alamat);
            $('#preview-telp').text(data.telp);
        });
    });

    // function printData() {
    //     const modalContent = document.querySelector('.preview-content').innerHTML;
    //     const printWindow = window.open('', '', 'height=500,width=800');

    //     printWindow.document.write('<html><head><title>Data Konsumen</title>');
    //     printWindow.document.write('<link href="assets/css/bootstrap.min.css" rel="stylesheet">');
    //     printWindow.document.write('<style>body { padding: 20px; }</style>');
    //     printWindow.document.write('</head><body>');
    //     printWindow.document.write('<h4 class="text-center">Data Konsumen</h4>');
    //     printWindow.document.write('<p class="text-center mb-4">Tanggal Cetak: ' + $('#printDate').text() + '</p>');
    //     printWindow.document.write(modalContent);
    //     printWindow.document.write('</body></html>');

    //     printWindow.document.close();
    //     printWindow.focus();

    //     // Add slight delay to ensure styles are loaded
    //     setTimeout(() => {
    //         printWindow.print();
    //         printWindow.close();
    //     }, 250);
    // }
</script>