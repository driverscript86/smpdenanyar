  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h4><?= $home['judul'] ?></h4>
          </div>
          <div class="col-lg-4 text-center text-lg-start">
            <a href="<?= base_url($home['link']); ?>" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
              <span><?= $home['tombol'] ?></span>
              <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-7 col-md-12 footer-info">
            <a href="<?= base_url('home'); ?>" class="logo d-flex align-items-center">
              <!-- <img src="assets/img/logo.png" alt=""> -->
              <span><?= $web['nama'] ?></span>
            </a>
            <br />
            <p><?= $web['deskripsi'] ?></p>
            <div class="social-links mt-3">
              <?php if (!empty($web['link_fb'])) : ?>
                <a target="_blank" href="<?= $web['link_fb'] ?>" class="facebook"><i class="bi bi-facebook"></i></a>
              <?php endif ?>

              <?php if (!empty($web['link_tw'])) : ?>
                <a target="_blank" href="<?= $web['link_tw'] ?>" class="twitter"><i class="bi bi-twitter"></i></a>
              <?php endif ?>

              <?php if (!empty($web['link_ig'])) : ?>
                <a target="_blank" href="<?= $web['link_ig'] ?>" class="instagram"><i class="bi bi-instagram bx bxl-instagram"></i></a>
              <?php endif ?>
            </div>
          </div>

          <!-- <div style="display:blok;" id="foter-hide" class="col-lg-2 col-6 footer-links">
            <h4></h4>
            <ul>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
            </ul>
          </div> -->

          <div class="col-lg-2 col-md-6 footer-links text-center text-md-start">
            <h4>Link Menu</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url('home'); ?>">Home</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url('acara'); ?>">Acara</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url('gallery'); ?>">Gallery</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url('about'); ?>">Tentang Kami</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url('kontak'); ?>">Kontak</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
            <h4>Kontak Kami</h4>
            <p>
              <i class="bi bi-geo-alt"></i> <?= $web['alamat'] ?> <br><br>
              <strong><i class="bi bi-phone"></i> Phone:</strong> <?= $web['telp'] ?><br>
              <strong><i class="bi bi-envelope"></i> Email:</strong> <?= $web['email'] ?><br>
            </p>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span><?= $web['nama'] ?></span></strong> <?= date('Y') ?>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexstart-bootstrap-startup-template/ -->
        <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/') ?>select2/dist/js/select2.min.js"></script>


  <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/aos/aos.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/php-email-form/validate.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/purecounter/purecounter.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url('assets/'); ?>js/main.js"></script>

  <script type="text/javascript">
    var x = document.getElementById("foter-hide");
    myFunction(x)

    function myFunction(x) {
      if (window.matchMedia("(max-width: 700px)").matches) {
        x.style.display = 'none';
      }
    };
  </script>

  </body>

  </html>