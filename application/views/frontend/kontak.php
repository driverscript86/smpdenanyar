<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">

    <ol>
      <li><a href="<?= base_url('home'); ?>">Home</a></li>
      <li>Kontak</li>
    </ol>
    <h2>Kontak Kami</h2>

  </div>
</section><!-- End Breadcrumbs -->

<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">

  <div class="container" data-aos="fade-up">

    <header class="section-header">
      <h2></h2>
      <p>Kontak Kami</p>
    </header>

    <div class="row gy-4">

      <div class="col-lg-6">

        <div class="row gy-4">
          <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-geo-alt"></i>
              <h3>Alamat</h3>
              <p><?= $web['alamat'] ?></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-telephone"></i>
              <h3>Telepon</h3>
              <p><?= $web['telp'] ?></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-envelope"></i>
              <h3>Email</h3>
              <p><?= $web['email'] ?></p>
            </div>
          </div>
          <!-- <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-clock"></i>
              <h3>Open Hours</h3>
              <p>Monday - Friday<br>9:00AM - 05:00PM</p>
            </div>
          </div> -->
        </div>

      </div>

      <div class="col-lg-6">
        <form action="kontak" method="post" class="php-email-form">
          <div class="row gy-4">

            <div class="col-md-6">
              <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= set_value('nama') ?>" required>
            </div>

            <div class="col-md-6 ">
              <input type="email" class="form-control" name="email" placeholder="Email" value="<?= set_value('email') ?>" required>
            </div>

            <div class="col-md-12">
              <input type="text" class="form-control" name="subjek" placeholder="Subjek" value="<?= set_value('subjek') ?>" required>
            </div>

            <div class="col-md-12">
              <textarea class="form-control" name="pesan" rows="6" placeholder="Pesan" value="<?= set_value('pesan') ?>" required></textarea>
            </div>

            <div class="col-md-12 text-center">
              <div class="loading">Loading...</div>
              <div class="sent-message"><strong>Terimakasih!</strong> Pesan kamu berhasil di kirim.</div>
              <div class="error-message">Maaf pesan gagal di kirim.</div>

              <button type="submit">Kirim Pesan</button>
            </div>

          </div>
        </form>

      </div>

    </div>

  </div>

</section><!-- End Contact Section -->

<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">

  <div class="container" data-aos="fade-up">
    <header class="section-header">
      <h2></h2>
      <p>Maps</p>
    </header>

    <div class="col-lg-8 offset-lg-2">
      <div class="row gy-4 php-email-form">
        <?= $web['maps'] ?>
      </div>
    </div>

  </div>
</section><!-- End Contact Section -->