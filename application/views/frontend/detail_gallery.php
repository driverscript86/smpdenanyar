<main id="main">

    <section class="breadcrumbs">
        <div class="container">

            <ol>
                <li><a href="<?= base_url('home'); ?>">Home</a></li>
                <li><a href="<?= base_url('gallery'); ?>">Gallery</a></li>
            </ol>
            <h2>Detail Gallery</h2>

        </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">

            <?php foreach ($gallery as $g) : ?>
                <?php $kat = $this->db->get_where('kategori_gallery', ['id' => $g['id_kat']])->row_array(); ?>

                <div class="row gy-4">

                    <div class="col-lg-8">
                        <div class="portfolio-details-slider swiper-container">
                            <div class="swiper-wrapper align-items-center">

                                <div class="swiper-slide">
                                    <img src="<?= base_url('assets/'); ?>img/gallery/<?= $g['img'] ?>" alt="">
                                </div>

                                <?php if (!empty($g['img1'])) : ?>
                                    <div class="swiper-slide">
                                        <img src="<?= base_url('assets/'); ?>img/gallery/<?= $g['img1'] ?>" alt="">
                                    </div>
                                <?php endif ?>

                                <?php if (!empty($g['img2'])) : ?>
                                    <div class="swiper-slide">
                                        <img src="<?= base_url('assets/'); ?>img/gallery/<?= $g['img2'] ?>" alt="">
                                    </div>
                                <?php endif ?>

                                <?php if (!empty($g['img3'])) : ?>
                                    <div class="swiper-slide">
                                        <img src="<?= base_url('assets/'); ?>img/gallery/<?= $g['img3'] ?>" alt="">
                                    </div>
                                <?php endif ?>

                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="portfolio-info">
                            <h3>Informasi Gambar</h3>
                            <?php $peng = $this->db->get_where('karyawan', ['id' => $g['id_peng']])->row_array(); ?>
                            <ul>
                                <li><strong>Kategori</strong>: <?= $kat['nama'] ?></li>
                                <li><strong>Post by</strong>: <?= $peng['nama'] ?></li>
                                <li><strong>Tanggal</strong>: <?= $g['tgl'] ?></li>
                            </ul>
                        </div>
                        <div class="portfolio-description">
                            <h2><?= $g['nama'] ?></h2>
                            <p>
                                <?= $g['deskripsi'] ?>
                            </p>
                        </div>
                    </div>

                </div>.

            <?php endforeach ?>

        </div>
    </section><!-- End Portfolio Details Section -->

</main><!-- End #main -->