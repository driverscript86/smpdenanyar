<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <a href="<?= base_url('auth'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-person fa-sm text-white-50"></i> Login siswa</a>
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block">
                            <img class="mt-10 pt-5" style="width:115%;height:85%" src="<?= base_url(); ?>assets/img/<?= $web['img_login_admin'] ?>" alt="">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Login Pembimbing</h1>
                                </div>
                                <?= $this->session->flashdata('message') ?>
                                <form class="user" action="<?= base_url('auth/admin'); ?>" method="post">
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
                                            <input type="checkbox" class="custom-control-input" name="remember" id="customCheck" value="">
                                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-user btn-block">
                                        <b>Login</b>
                                    </button>
                                    <hr>
                                </form>

                                <div class="text-center">
                                    <a class="small" href="<?= base_url('home'); ?>"><b>⇤ Kembali Home</b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>