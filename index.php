<?php

@ob_start();
session_start();

if (isset($_SESSION['login'])) {
  include 'pages/layouts/header.php';
  include 'pages/layouts/navbar.php';
  include 'pages/layouts/sidebar.php';

  if (!empty($_GET['page'])) {
    include 'pages' . '/' . $_GET['page'] . '/index.php';
  } else {
    include 'pages/dashboard/index.php';
  }

  include 'pages/layouts/footer.php';
} else {
  echo '<script>window.location="pages/auth/login.php";</script>';
  exit;
}
