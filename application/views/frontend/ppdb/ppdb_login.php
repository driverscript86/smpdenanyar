<!-- Custom styles for this template-->
<link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

<main id="main" style="padding-top: 30px;">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <ol>
                <li><a href="<?= base_url('home'); ?>">Home</a></li>
                <li>PPDB</li>
            </ol>
            <h2>PPDB</h2>

        </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
        <div class="container" style="padding-left:3px;padding-right:3px">

            <!-- Begin Page Content -->
            <div class="container-fluid">


                <!-- Outer Row -->
                <div class="row justify-content-center">

                    <div class="col-xl-6 col-lg-6 col-md-6">

                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">Login PPDB</h1>
                                            </div>
                                            <?= $this->session->flashdata('message') ?>
                                            <form class="user" action="<?= base_url('ppdb/login'); ?>" method="post">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="text" class="form-control form-control-user" value="<?= set_value('email') ?>" name="email" id="email" placeholder="Email">
                                                    <?= form_error('email', '<small class="text-danger pl-3">', ' </small>') ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                                    <?= form_error('password', '<small class="text-danger pl-3">', ' </small>') ?>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox small">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                                                        <div class="float-right">
                                                            <label><a href="<?= base_url('kontak'); ?>">Lupa Password?</a></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success btn-user btn-block">
                                                    <b>Login</b>
                                                </button>
                                                <hr>
                                            </form>

                                            <div class="text-center">
                                                <a class="small" href="<?= base_url('ppdb'); ?>"><b>⇤ Form Pendaftaran</b></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>
</main>