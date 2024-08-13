<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Users</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="index.php?page=mobil">Users</a></li>
                <li class="breadcrumb-item active">Tambah Users</li>
            </ol>
        </nav>
    </div><!--end page title-->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Users</h5>

                        <form action="logic/users/save.php" method="post">

                            <div class="form-group mb-3">
                                <label>Username</label>
                                <input type="text" name="username" placeholder="Input Username" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Passwoard</label>
                                <input type="text" name="password" placeholder="Input Password" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Nama</label>
                                <input type="text" name="nama" placeholder="Input Nama" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Alamat</label>
                                <input type="text" name="alamat" placeholder="Input Alamat" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Telepon</label>
                                <input type="text" name="telp" placeholder="Input Telepon" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Hak Akses</label>
                                <select class="form-control" name="hak">
                                    <option>--Pilih--</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Petugas">Petugas</option>
                                </select>
                            </div>

                            <hr>

                            <div class="text-end">
                                <button type="reset" class="btn btn-warning">Reset</button>
                                <button type="submit" name="Submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>