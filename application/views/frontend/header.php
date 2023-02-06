<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= $web['nama'] ?></title>
  <meta content="" name="<?= $web['deskripsi'] ?>">

  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url('assets/'); ?>img/<?= $web['fav'] ?>" rel="icon">
  <link href="<?= base_url('assets/'); ?>img/<?= $web['fav'] ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets/'); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url('assets/'); ?>css/style.css" rel="stylesheet">

  <!-- Select2 CSS -->
  <link href="<?= base_url('assets/') ?>select2/dist/css/select2.min.css" rel="stylesheet" />

  <!-- jQuery library -->
  <script src="<?= base_url('assets/') ?>js/jquery-3.3.1.min.js"></script>

</head>

<body>


  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="<?= base_url('home'); ?>" class="logo d-flex align-items-center">
        <!-- <img src="<?= base_url('assets/'); ?>img/logo.png" alt=""> -->
        <span><?= $web['nama'] ?></span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto <?php if ($menu == 'home') {
                                            echo 'active';
                                          } ?>" href="<?= base_url('home'); ?>">Home</a></li>
          <li><a class="nav-link scrollto <?php if ($menu == 'acara') {
                                            echo 'active';
                                          } ?>" href="<?= base_url('acara'); ?>">Acara</a></li>
          <li><a class="nav-link scrollto <?php if ($menu == 'gallery') {
                                            echo 'active';
                                          } ?>" href="<?= base_url('gallery'); ?>">Gallery</a></li>
          <li><a class="nav-link scrollto <?php if ($menu == 'about') {
                                            echo 'active';
                                          } ?>" href="<?= base_url('about'); ?>">Tentang Kami</a></li>
          <li><a class="nav-link scrollto <?php if ($menu == 'kontak') {
                                            echo 'active';
                                          } ?>" href="<?= base_url('kontak'); ?>">Kontak</a></li>
          <!-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li> -->
          <li><a class="getstarted scrollto" href="<?= base_url('auth'); ?>">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->