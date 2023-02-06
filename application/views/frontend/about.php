<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
    <div class="container">

        <ol>
            <li><a href="<?= base_url('home'); ?>">Home</a></li>
            <li>Tentang Kami</li>
        </ol>
        <h2>Tentang Kami</h2>

    </div>
</section><!-- End Breadcrumbs -->

<!-- ======= Blog Single Section ======= -->
<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <h2></h2>
            <p>Tentang Kami</p>
        </header>
        <div class="row">

            <div class="col-lg-12 entries">

                <article class="entry entry-single">

                    <div class="entry-img text-center">
                        <img src="assets/img/<?= $about['img'] ?>" alt="" class="img-fluid">
                    </div>

                    <h2 class="entry-title pt-2">
                        <a href="#">Tentang <?= $web['nama'] ?></a>
                    </h2>

                    <div class="entry-content">
                        <p><?= $web['deskripsi'] ?></p>
                        <p><?= $about['about'] ?></p>

                        <h2 class="entry-title pt-5"><a href="#">Visi dan Misi</a></h2>

                        <h3>Visi Sekolah</h3>
                        <p><?= $about['visi'] ?></p>
                        <h3>Misi Sekolah</h3>
                        <p><?= $about['misi'] ?></p>
                    </div>
                </article><!-- End blog entry -->



            </div><!-- End blog entries list -->

        </div>

    </div>
</section><!-- End Blog Single Section -->