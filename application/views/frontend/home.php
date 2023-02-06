<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center">

  <div class="container">
    <div class="row">
      <div class="col-lg-6 d-flex flex-column justify-content-center">
        <h1 data-aos="fade-up"><?= $home['judul'] ?></h1>
        <h2 data-aos="fade-up" data-aos-delay="400"><?= $home['isi'] ?></h2>
        <div data-aos="fade-up" data-aos-delay="600">
          <div class="text-center text-lg-start">
            <a href="<?= base_url($home['link']); ?>" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
              <span><?= $home['tombol'] ?></span>
              <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
        <img src="<?= base_url('assets/'); ?>img/<?= $home['img'] ?>" class="img-fluid" alt="">
      </div>
    </div>
  </div>

</section><!-- End Hero -->

<main id="main">
  <!-- ======= About Section ======= -->
  <section id="about" class="about">

    <div class="container" data-aos="fade-up">
      <div class="row gx-0">

        <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
          <div class="content">
            <h3>Tentang Kami</h3>
            <h2><?= $web['nama'] ?></h2>
            <p>
              <?= $web['deskripsi'] ?>
            </p>
            <div class="text-center text-lg-start">
              <a href="<?= base_url('about') ?>" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Selengkapnya</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
          <img style="height: auto;width: 100%;" src="<?= base_url('assets/'); ?>img/<?= $about['img'] ?>" class="img-fluid" alt="">
        </div>

      </div>
    </div>

  </section><!-- End About Section -->

  <!-- ======= Values Section ======= -->
  <section id="values" class="values">

    <div class="container" data-aos="fade-up">

      <header class="section-header">
        <h2></h2>
        <p>Keunggulan Sekolah Kami</p>
      </header>

      <div class="row">

        <?php foreach ($tagline as $tag) : ?>

          <div class="col-lg-4">
            <div class="box" data-aos="fade-up" data-aos-delay="200">
              <img src="<?= base_url('assets/'); ?>img/<?= $tag['img'] ?>" class="img-fluid" alt="">
              <h3><?= $tag['nama'] ?></h3>
              <p><?= $tag['deskripsi'] ?></p>
            </div>
          </div>

        <?php endforeach ?>

      </div>

    </div>

  </section><!-- End Values Section -->

  <!-- ======= Counts Section ======= -->
  <section id="counts" class="counts">
    <div class="container" data-aos="fade-up">

      <div class="row gy-4">

        <div class="col-lg-3 col-md-6">
          <div class="count-box">
            <i class="bi bi-people" style="color: #bb0852;"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="<?= $sum_siswa ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p>Total siswa</p>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="count-box">
            <i class="bi bi-person-circle"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="<?= $sum_karyawan ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p>Guru & Pegawai</p>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="count-box">
            <i class="bi bi-bank2" style="color: #ee6c20;"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="<?= $sum_pendidikan ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p>Pendidikan</p>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="count-box">
            <i class="bi bi-journal-text" style="color: #15be56;"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="<?= $sum_kelas ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p>Kelas</p>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Counts Section -->

  <!-- ======= Features Section ======= -->
  <section id="features" class="features">

    <div class="container" data-aos="fade-up">

      <header class="section-header">
        <h2></h2>
        <p>Ciri Khas Sekolah</p>
      </header>

      <div class="row">

        <div class="col-lg-6">
          <img src="<?= base_url('assets/'); ?>img/features.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-6 mt-5 mt-lg-0 d-flex">
          <div class="row align-self-center gy-4">

            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="200">
              <div class="feature-box d-flex align-items-center">
                <i class="bi bi-check"></i>
                <h3>Sistem Pendidikan Terpadu</h3>
              </div>
            </div>

            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">
              <div class="feature-box d-flex align-items-center">
                <i class="bi bi-check"></i>
                <h3>Spirit But Modern</h3>
              </div>
            </div>

            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="600">
              <div class="feature-box d-flex align-items-center">
                <i class="bi bi-check"></i>
                <h3>Boarding School</h3>
              </div>
            </div>

            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="400">
              <div class="feature-box d-flex align-items-center">
                <i class="bi bi-check"></i>
                <h3>Area Pendidikan yang Luas dan Kondusif</h3>
              </div>
            </div>

            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="700">
              <div class="feature-box d-flex align-items-center">
                <i class="bi bi-check"></i>
                <h3>Full Development Of Personality</h3>
              </div>
            </div>

            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="500">
              <div class="feature-box d-flex align-items-center">
                <i class="bi bi-check"></i>
                <h3>International Language</h3>
              </div>
            </div>

          </div>
        </div>

      </div> <!-- / row -->

    </div>

  </section><!-- End Features Section -->

  <!-- ======= Portfolio Section ======= -->
  <section id="portfolio" class="portfolio">

    <div class="container" data-aos="fade-up">

      <header class="section-header">
        <h2></h2>
        <p>Gallery</p>
      </header>

      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-12 d-flex justify-content-center">
          <ul id="portfolio-flters">
            <li data-filter="*" class="filter-active">New</li>
            <?php foreach ($kategori as $k) : ?>
              <li data-filter=".<?= $k['uniq'] ?>"><?= $k['nama'] ?></li>
            <?php endforeach ?>
          </ul>
        </div>
      </div>

      <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">

        <?php foreach ($gallery as $g) : ?>
          <?php $kat = $this->db->get_where('kategori_gallery', ['id' => $g['id_kat']])->row_array(); ?>

          <div class="col-lg-4 col-md-6 portfolio-item <?= $kat['uniq'] ?>">
            <div class="portfolio-wrap">
              <img style="height: 300px;width: 400px;" src="<?= base_url('assets/'); ?>img/gallery/<?= $g['img'] ?>" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><?= $g['nama'] ?></h4>
                <p><?= $kat['nama'] ?></p>
                <div class="portfolio-links">
                  <a href="<?= base_url('assets/'); ?>img/gallery/<?= $g['img'] ?>" data-gallery="portfolioGallery" class="portfokio-lightbox" title="<?= $g['nama'] ?>"><i class="bi bi-plus"></i></a>
                  <a href="<?= base_url('detail_gallery?id=' . $g['id']); ?>" title="Lihat Detail"><i class="bi bi-link"></i></a>
                </div>
              </div>
            </div>
          </div>

        <?php endforeach ?>

      </div>

      <div class="portfolio-pagination text-center pt-5">
        <a href="<?= base_url('gallery') ?>" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
          <span>Selengkapnya</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>

    </div>
  </section><!-- End Portfolio Section -->



  <!-- ======= Recent Blog Posts Section ======= -->
  <section id="recent-blog-posts" class="recent-blog-posts">

    <div class="container" data-aos="fade-up">

      <header class="section-header">
        <p>Informasi Acara</p>
      </header>

      <div class="row">

        <?php foreach ($acara as $d) : ?>

          <div class="col-lg-4">
            <div class="post-box">
              <div class="post-img"><img style="height: 250px;width: 450px;" src="<?= base_url('assets/'); ?>img/blog/<?= $d['img'] ?>" class="img-fluid" alt=""></div>
              <span class="post-date"><?= $d['tgl'] ?></span>
              <h3 class="post-title"><?= $d['judul'] ?></h3>
              <a href="<?= base_url('detail_acara?id=' . $d['id']); ?>" class="readmore stretched-link mt-auto"><span>Selengkapnya</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div>

        <?php endforeach ?>

      </div>

    </div>

  </section><!-- End Recent Blog Posts Section -->

  <!-- ======= F.A.Q Section ======= -->
  <section id="features" class="features">

    <div class="container" data-aos="fade-up">

      <header class="section-header">
        <p class="mb-3">F.A.Q (Tanya Jawab)</p>
        <h2>Pertanyaan dan Jawaban yang sering dilakukan.</h2>
      </header>

      <div id="accordion" class="faq-list">
        <?php foreach ($faq as $d) : ?>
          <div class="card mb-3" data-aos="zoom-out" data-aos-delay="200">
            <div class="feature-box d-flex" id="heading<?= $d['role'] ?>">
              <h5 class="mb-0">
                <a href="#" data-toggle="collapse" data-target="#collapse<?= $d['role'] ?>" aria-expanded="true" aria-controls="collapse<?= $d['role'] ?>">
                  <i class="bi bi-patch-question icon-help"></i> <?= $d['pertanyaan'] ?>
                </a>
              </h5>
            </div>

            <div id="collapse<?= $d['role'] ?>" class="collapse <?php if ($d['role'] == '1') : ?>show<?php endif ?>" aria-labelledby="heading<?= $d['role'] ?>" data-parent="#accordion">
              <div class="card-body">
                <?= $d['jawaban'] ?>
              </div>
            </div>
          </div>

        <?php endforeach ?>
      </div>


    </div>
  </section>
  <!-- End F.A.Q Section -->


</main><!-- End #main -->