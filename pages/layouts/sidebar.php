<?php
if ($page == 'dashboard') {
  $classDashboard = 'nav-link active';
} else {
  $classDashboard = 'nav-link collapsed';
}
if ($page == 'transaksi') {
  $classTransaksi = 'nav-link active';
} else {
  $classTransaksi = 'nav-link collapsed';
}
if ($page == 'laporan') {
  $classLaporan = 'nav-link active';
} else {
  $classLaporan = 'nav-link collapsed';
}
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="<?php echo $classDashboard ?>" href="index.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <!-- contoh menu dropdown -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="master-nav" class="nav-content collapse <?php if ($page == 'mobil' || $page == 'konsumen' || $page == 'users') echo 'show' ?>" data-bs-parent="#sidebar-nav">
        <li>
          <a href="index.php?page=mobil" class="<?php if ($page == 'mobil') echo 'active' ?>">
            <i class="bi bi-circle"></i><span>Mobil</span>
          </a>
        </li>
        <li>
          <a href="index.php?page=konsumen" class="<?php if ($page == 'konsumen') echo 'active' ?>">
            <i class="bi bi-circle"></i><span>Konsumen</span>
          </a>
        </li>
        <li>
          <a href="index.php?page=users" class="<?php if ($page == 'users') echo 'active' ?>">
            <i class="bi bi-circle"></i><span>Users</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End Master Nav -->

    <li class="nav-item">
      <a class="<?php echo $classTransaksi ?>" href="index.php?page=transaksi">
        <i class="bi bi-pc-display-horizontal"></i>
        <span>Transaksi</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="<?php echo $classLaporan ?>" href="index.php?page=laporan">
        <i class="bi bi-file-bar-graph"></i>
        <span>Laporan</span>
      </a>
    </li><!-- End Dashboard Nav -->

  </ul>

</aside><!-- End Sidebar-->