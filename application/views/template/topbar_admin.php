<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">


                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow mx-1 show">
                    <a class="nav-link dropdown-toggle" target="_blank" href="<?= base_url('home') ?>">
                        <i class="fas fa-bell fa-globe pr-1"></i>
                        <span> Website</span>
                    </a>

                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['nama'] ?></span>
                        <img class="img-profile rounded-circle" src="<?= base_url('assets/') ?>img/profile/default.jpg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <?php if ($user['role_id'] == '6') : ?>
                        <a class="dropdown-item" href="<?= base_url('marketing/setting'); ?>">
                    <?php else : ?>
                        <a class="dropdown-item" href="<?= base_url('admin/setting'); ?>">
                    <?php endif; ?>
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            My Profile
                        </a>

                        <?php if($user['role_id'] == '1') : ?>
                            <a class="dropdown-item" href="<?= base_url('admin/website') ?>">
                                <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                                Setting Website
                            </a>
                        <?php endif; ?>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Keluar
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->