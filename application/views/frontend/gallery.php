<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">

    <ol>
      <li><a href="<?= base_url('home'); ?>">Home</a></li>
      <li>Gallery</li>
    </ol>
    <h2>Gallery</h2>

  </div>
</section><!-- End Breadcrumbs -->

<!-- ======= Portfolio Section ======= -->
<section id="portfolio" class="portfolio">

  <div class="container" data-aos="fade-up">

    <!-- <header class="section-header">
      <p>Gallery</p>
    </header> -->

    <div class="row">

      <div class="col-lg-3">

        <div class="sidebar">

          <h3 class="sidebar-title">Kategori</h3>
          <div class="sidebar-item categories">
            <ul>

              <?php foreach ($kategori as $k) : ?>
                <?php $sum_kat = $this->db->get_where('gallery', ['id_Kat' => $k['id']])->num_rows(); ?>

                <li><a href="<?= base_url('kategori_gallery/' . $k['uniq']); ?>"><?= $k['nama'] ?> <span>(<?= $sum_kat ?>)</span></a></li>

              <?php endforeach ?>

            </ul>
          </div><!-- End sidebar categories-->

        </div><!-- End sidebar -->

      </div><!-- End blog sidebar -->


      <div class="col-lg-9 shadow">

        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">

              <?php $title = $this->db->get_where('kategori_gallery', ['uniq' => $this->uri->segment(2)])->row_array(); ?>
              <?php if ($title == TRUE) : ?>
                <li data-filter="*" class="filter-active"><?= $title['nama'] ?></li>
              <?php else : ?>
                <li data-filter="*" class="filter-active">Semua</li>
              <?php endif ?>
            </ul>
          </div>
        </div>

        <div class="row gy-4 portfolio-container pb-3" data-aos="fade-up" data-aos-delay="200">

          <?php foreach ($daftar as $g) : ?>
            <?php $kate = $this->db->get_where('kategori_gallery', ['id' => $g['id_kat']])->row_array(); ?>

            <div class="col-lg-4 col-md-6 portfolio-item">
              <div class="portfolio-wrap">
                <img style="height: 200px;width: 400px;" src="<?= base_url('assets/'); ?>img/gallery/<?= $g['img'] ?>" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4><?= $g['nama'] ?></h4>
                  <p><?= $kate['nama'] ?></p>
                  <div class="portfolio-links">
                    <a href="<?= base_url('assets/'); ?>img/gallery/<?= $g['img'] ?>" data-gallery="portfolioGallery" class="portfokio-lightbox" title="<?= $g['nama'] ?>"><i class="bi bi-plus"></i></a>
                    <a href="<?= base_url('detail_gallery?id=' . $g['id']); ?>" title="Lihat Detail"><i class="bi bi-link"></i></a>
                  </div>
                </div>
              </div>
            </div>

          <?php endforeach ?>

        </div>


        <div class="portfolio-pagination pt-5">
          <ul class="justify-content-center">
            <li class="disabled" aria-disabled="true"><a>Total data: <?= $total; ?></a></li>
            <?php echo $pagination; ?>
          </ul>
        </div>


      </div>

    </div>

  </div>
</section><!-- End Portfolio Section -->