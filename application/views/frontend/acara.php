<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <ol>
                <li><a href="<?= base_url('home'); ?>">Home</a></li>
                <li>Acara</li>
            </ol>
            <h2>Acara</h2>

        </div>
    </section><!-- End Breadcrumbs -->


    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2></h2>
                <p>Informasi Acara</p>
            </header>
            <div class="row gy-4">

                <?php foreach ($daftar as $d) : ?>

                    <div class="col-md-4 entries">

                        <article class="entry">

                            <div class="entry-img">
                                <img style="height: 250px;width: 450px;" src="<?= base_url('assets/'); ?>img/blog/<?= $d['img'] ?>" alt="" class="img-fluid">
                            </div>

                            <h2 class="entry-title">
                                <a href="<?= base_url('detail_acara?id=' . $d['id']); ?>"><?= nl2br(substr($d['judul'], 0, 50)); ?></a>
                            </h2>

                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-geo-alt"></i> <a href="#"><?= $d['tempat'] ?></a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-calendar-check"></i> <a href="#"><?= $d['tgl'] ?></a></li>
                                </ul>
                            </div>

                            <div class="entry-content">
                                <p><?= nl2br(substr($d['deskripsi'], 0, 300)); ?></p>
                                <div class="read-more">
                                    <a href="<?= base_url('detail_acara?id=' . $d['id']); ?>">Baca Selengkapnya</a>
                                </div>
                            </div>

                        </article><!-- End blog entry -->

                    </div>

                <?php endforeach ?>

                <div class="blog-pagination">
                    <ul class="justify-content-center">
                        <li class="disabled" aria-disabled="true"><a>Total data: <?= $total; ?></a></li>
                        <?php echo $pagination; ?>
                    </ul>
                </div>


            </div>
        </div>

    </section><!-- End Blog Section -->

</main><!-- End #main -->