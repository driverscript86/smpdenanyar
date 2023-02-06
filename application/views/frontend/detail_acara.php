<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <ol>
                <li><a href="<?= base_url('home'); ?>">Home</a></li>
                <li><a href="<?= base_url('acara'); ?>">Acara</a></li>
            </ol>
            <h2>Detail Acara</h2>

        </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Single Section ======= -->
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">

            <div class="row">

                <div class="col-lg-8 entries">

                    <article class="entry entry-single">

                        <?php foreach ($detail as $d) : ?>

                            <div class="entry-img">
                                <img src="<?= base_url('assets/'); ?>img/blog/<?= $d['img'] ?>" alt="" class="img-fluid">
                            </div>

                            <h2 class="entry-title">
                                <a href="<?= base_url('acara/detail?id=' . $d['id']); ?>"><?= $d['judul'] ?></a>
                            </h2>

                            <div class="entry-meta">
                                <?php $peng = $this->db->get_where('karyawan', ['id' => $d['id_peng']])->row_array(); ?>
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="#"><?= $d['jam'] ?></a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-geo-alt"></i> <a href="#"><?= $d['tempat'] ?></a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-calendar-check"></i> <a href="#"><?= $d['tgl'] ?></a></li>
                                </ul>
                            </div>

                            <div class="entry-content">
                                <?= $d['deskripsi'] ?>
                            </div>

                            <div class="entry-footer">
                                <i class="bi bi-tags"></i>
                                <ul class="tags">
                                    <?php $kat_ = $this->db->get_where('kategori_acara', ['id' => $d['id_kat']])->row_array(); ?>
                                    <li><a href="#"><?= $kat_['nama'] ?></a></li>
                                    <li><i class="bi bi-person"></i> <a href="#"><?= $peng['nama'] ?></a></li>
                                </ul>
                            </div>

                    </article><!-- End blog entry -->

                <?php endforeach ?>

                </div><!-- End blog entries list -->

                <div class="col-lg-4">

                    <div class="sidebar">

                        <h3 class="sidebar-title">Kategori</h3>
                        <div class="sidebar-item categories">
                            <ul>

                                <?php foreach ($kategori as $k) : ?>
                                    <?php $sum_kat = $this->db->get_where('acara', ['id_kat' => $k['id']])->num_rows(); ?>

                                    <li><a href="<?= base_url('kategori_acara/' . $k['uniq']); ?>"><?= $k['nama'] ?> <span>(<?= $sum_kat ?>)</span></a></li>

                                <?php endforeach ?>

                            </ul>
                        </div><!-- End sidebar categories-->

                        <h3 class="sidebar-title">Acara Lain</h3>
                        <div class="sidebar-item recent-posts">

                            <?php foreach ($acara_lain as $a) : ?>

                                <div class="post-item clearfix">
                                    <img src="<?= base_url('assets/'); ?>img/blog/<?= $a['img'] ?>" alt="">
                                    <h4><a href="<?= base_url('detail_acara?id=' . $a['id']); ?>"><?= $a['judul'] ?></a></h4>
                                    <time datetime="2020-01-01"><?= $a['tgl'] ?></time>
                                </div>

                            <?php endforeach ?>

                        </div><!-- End sidebar recent posts-->

                    </div><!-- End sidebar -->

                </div><!-- End blog sidebar -->

            </div>

        </div>
    </section><!-- End Blog Single Section -->

</main><!-- End #main -->