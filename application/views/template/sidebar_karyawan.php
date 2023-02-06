<?php
$notif_izin      = $this->db->get_where('perizinan', ['status' => 'Pending', 'id_pend' => $user['id_pend']])->num_rows();
$notif_konseling = $this->db->get_where('konseling', ['status' => 'Pending', 'id_peng' => $user['id']])->num_rows();
$notif_ppdb = $this->db->get_where('ppdb', ['status' => '0'])->num_rows();
$notif_kontak = $this->db->get_where('kontak', ['status' => 1])->num_rows();
?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin'); ?>">
        <div class="sidebar-brand-icon">
            <i class="fas fa-home"></i>
        </div>
        <?php if ($user['role_id'] == 2) : ?>
            <div class="sidebar-brand-text mx-3">Kesiswaan</div>
        <?php elseif ($user['role_id'] == 3) : ?>
            <div class="sidebar-brand-text mx-3">Guru</div>
        <?php elseif ($user['role_id'] == 4) : ?>
            <div class="sidebar-brand-text mx-3">Karyawan</div>
        <?php elseif ($user['role_id'] == 5) : ?>
            <div class="sidebar-brand-text mx-3">Bendahara</div>
        <?php elseif ($user['role_id'] == 6) : ?>
            <div class="sidebar-brand-text mx-3">Marketing</div>
        <?php endif ?>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <?php if ($user['role_id'] !== '6') : ?>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('admin'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>
    <?php endif; ?>
    
    <?php if ($user['role_id'] == 2) : ?>
        <?php if ($menu == 'ppdb') : ?>
            <li class="nav-item active">
            <?php else : ?>
            <li class="nav-item">
            <?php endif; ?>
            <a class="nav-link" href="<?= base_url('admin/ppdb'); ?>">
                <i class="fas fa-fw fa-address-card"></i>
                <span>PPDB </span> &nbsp;
                <?php if ($notif_ppdb) : ?>
                    <span class="badge badge-danger" style="font-size: 10px;"><?= $notif_ppdb ?></span>
                <?php endif ?>
            </a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <?php if ($menu == 'menu-1') : ?>
                <li class="nav-item active">
                <?php else : ?>
                <li class="nav-item">
                <?php endif; ?>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-users"></i>
                    <span>siswa</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Pilih menu:</h6>
                        <a class="collapse-item" href="<?= base_url('admin/daftar_siswa'); ?>">Daftar siswa</a>
                        <a class="collapse-item" href="<?= base_url('admin/tambah_siswa'); ?>">Pendaftaran siswa</a>
                    </div>
                </div>
                </li>
            <?php endif ?>

            <?php if ($user['role_id'] !== '4') : ?>
                <?php if ($user['role_id'] !== '2' && $user['role_id'] !== '5') : ?>
                    <!-- Nav Item - Utilities Collapse Menu -->
                    <?php if ($menu == 'menu-3') : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUU" aria-expanded="true" aria-controls="collapseUU">
                            <i class="fas fa-fw fa-list-alt"></i>
                            <span>Data </span>
                            <?php $sum_notif = $notif_konseling + $notif_izin; ?>
                            <?php if ($notif_konseling || $notif_izin) : ?><span class="badge badge-danger" style="font-size: 10px;"> New <?= $sum_notif ?></span><?php endif ?>
                        </a>
                        <div id="collapseUU" class="collapse" aria-labelledby="headingUU" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Pilih Menu:</h6>
                                <a class="collapse-item" href="<?= base_url('admin/konseling'); ?>">Konseling <?php if ($notif_konseling) : ?><span class="badge badge-danger"><?= $notif_konseling ?></span><?php endif ?></a>
                                <a class="collapse-item" href="<?= base_url('admin/perizinan'); ?>">Perizinan <?php if ($notif_izin) : ?><span class="badge badge-danger"><?= $notif_izin ?></span><?php endif ?></a>
                                <a class="collapse-item" href="<?= base_url('admin/daftar_absen'); ?>">Presensi</a>
                                <a class="collapse-item" href="<?= base_url('admin/pelanggaran'); ?>">Pelanggaran</a>
                            </div>
                        </div>
                        </li>

                    <?php endif ?>
                    <?php endif ?>

                    <?php if ($user['role_id'] == '5') : ?>
                    <?php if ($menu == 'menu-9') : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoss" aria-expanded="true" aria-controls="collapseTwoss">
                            <i class="fas fa-fw fa-user-circle"></i>
                            <span>karyawan</span>
                        </a>
                        <div id="collapseTwoss" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Pilih menu:</h6>
                                <a class="collapse-item" href="<?= base_url('admin/karyawan'); ?>">Data Karyawan</a>
                                <a class="collapse-item" href="<?= base_url('admin/tambah_karyawan'); ?>">Tambah Karyawan</a>
                            </div>
                        </div>
                        </li>
                    <?php endif ?>


                    <?php if ($user['role_id'] !== '6') : ?>
                        <?php if ($menu == 'gaji') : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link" href="<?= base_url('admin/penggajian'); ?>">
                            <i class="fas fa-fw fa-address-card"></i>
                            <span>Hist Penggajian </span>
                        </a>
                        </li>
                    <?php endif; ?>

                        <?php if ($menu == 'reff') : ?>
                            <li class="nav-item active">
                            <?php else : ?>
                            <li class="nav-item">
                            <?php endif; ?>
                                <?php if ($user['role_id'] == '6') : ?>
                                    <a class="nav-link" href="<?= base_url('marketing'); ?>">
                                <?php else : ?>
                                    <a class="nav-link" href="<?= base_url('admin/data_referral'); ?>">
                                <?php endif; ?>

                                <i class="fas fa-fw fa-user-plus"></i>
                                <span>Data Referral </span>
                            </a>
                            </li>

                        <?php if ($user['role_id'] == 5 || $user['role_id'] == 3) : ?>
                            <!-- Divider -->
                            <hr class="sidebar-divider">

                            <?php if ($user['role_id'] == 5 || $user['role_id'] == 3) : ?>
                            <div class="sidebar-heading">
                                Keuangan
                            </div>
                           
                            <li class="nav-item <?= ($this->uri->segment(1) == 'payout') ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= base_url('payout'); ?>">
                                <i class="fas fa-fw fa-money-bill"></i>
                                <span>Transaksi Siswa </span>
                            </a>
                            </li>
                            <?php endif ?>
                            <?php if ($user['role_id'] == 5) : ?>
                            <li class="nav-item <?= ($this->uri->segment(2) == 'keluaran' or $this->uri->segment(2) == 'masukan') ? 'active' : '' ?>">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transaksiumum" aria-expanded="true" aria-controls="transaksiumum">
                                    <i class="fa fa-shopping-cart text-stock"></i> <span>Transaksi Umum</span>
                                </a>
                                <div id="transaksiumum" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                                    <div class="bg-white py-2 collapse-inner rounded">
                                        <h6 class="collapse-header">Pilih Menu:</h6>
                                        <a class="collapse-item" href="<?= site_url('manage/masukan') ?>"><i class="fa  <?= ($this->uri->segment(2) == 'masukan') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Pemasukan</a>
                                        <a class="collapse-item" href="<?= site_url('manage/keluaran') ?>"><i class="fa  <?= ($this->uri->segment(2) == 'keluaran') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Pengeluaran</a>
                                    </div>
                                </div>
                            </li>

                            <?php if ($menu == 'gaji') : ?>
                                <li class="nav-item active">
                                <?php else : ?>
                                <li class="nav-item">
                                <?php endif; ?>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities1" aria-expanded="true" aria-controls="collapseUtilities1">
                                    <i class="fas fa-fw fa-money-bill"></i>
                                    <span>Penggajian</span>
                                </a>
                                <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                                    <div class="bg-white py-2 collapse-inner rounded">
                                        <h6 class="collapse-header">Pilih Menu:</h6>
                                        <a class="collapse-item" href="<?= base_url('admin/penggajian'); ?>">Penggajian</a>
                                        <hr class="sidebar-divider">
                                        <h6 class="collapse-header">Data Potongan :</h6>
                                        <a class="collapse-item" href="<?= base_url('admin/data_cicilan'); ?>">Cicilan</a>
                                    </div>
                                </div>
                                </li>

                                <li class="nav-item <?= ($this->uri->segment(2) == 'pembayaran_ppdb' or $this->uri->segment(2) == 'jenis_pembayaran' or $this->uri->segment(2) == 'pos') ? 'active' : '' ?>">
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengaturanpemb" aria-expanded="true" aria-controls="pengaturanpemb">
                                        <i class="fa fa-cog text-stock"></i> <span>Setting Pembayaran</span>
                                    </a>
                                    <div id="pengaturanpemb" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <h6 class="collapse-header">Pilih Menu:</h6>
                                            <a class="collapse-item" href="<?= base_url('manage/pos'); ?>">Data Pembayaran</a>
                                            <a class="collapse-item" href="<?= site_url('manage/jenis_pembayaran') ?>">☆ Jenis Pembayaran</a>
                                            <a class="collapse-item" href="<?= base_url('manage/pembayaran_ppdb'); ?>">Pembayaran PPDB</a>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item <?= ($this->uri->segment(2) == 'report' or $this->uri->segment(3) == 'report_bill') ? 'active' : '' ?>">
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#lappporan" aria-expanded="true" aria-controls="lappporan">
                                        <i class="fa fa-file text-stock"></i> <span>Laporan</span>
                                    </a>
                                    <div id="lappporan" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <h6 class="collapse-header">Pilih Menu:</h6>
                                            <a class="collapse-item" href="<?= site_url('manage/report') ?>">Laporan Total Keuangan</a>
                                            <a class="collapse-item" href="<?= site_url('manage/report_kelas') ?>">Laporan Per-kelas</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- Divider -->
                                <?php endif; ?>
                                <hr class="sidebar-divider">
                            <!-- Heading -->
                            <div class="sidebar-heading">
                                Website
                            </div>



                            <!-- Nav Item - Pages Collapse Menu -->
                            <?php if ($menu == 'acara') : ?>
                                <li class="nav-item active">
                                <?php else : ?>
                                <li class="nav-item">
                                <?php endif; ?>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAcara" aria-expanded="true" aria-controls="collapseAcara">
                                    <i class="fas fa-fw fa-calendar-day"></i>
                                    <span>Acara</span>
                                </a>
                                <div id="collapseAcara" class="collapse" aria-labelledby="headingAcara" data-parent="#accordionSidebar">
                                    <div class="bg-white py-2 collapse-inner rounded">
                                        <h6 class="collapse-header">Pilih Menu:</h6>
                                        <a class="collapse-item" href="<?= base_url('admin/tambah_acara'); ?>">Tambah Acara</a>
                                        <a class="collapse-item" href="<?= base_url('admin/acara'); ?>">Data Acara</a>
                                        <a class="collapse-item" href="<?= base_url('admin/kategori_acara'); ?>">Data Kategori</a>
                                    </div>
                                </div>
                                </li>


                                <!-- Nav Item - Pages Collapse Menu -->
                                <?php if ($menu == 'gallery') : ?>
                                    <li class="nav-item active">
                                    <?php else : ?>
                                    <li class="nav-item">
                                    <?php endif; ?>
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGallery" aria-expanded="true" aria-controls="collapseGallery">
                                        <i class="fas fa-fw fa-image"></i>
                                        <span>Gallery</span>
                                    </a>
                                    <div id="collapseGallery" class="collapse" aria-labelledby="headingGallery" data-parent="#accordionSidebar">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <h6 class="collapse-header">Pilih Menu:</h6>
                                            <a class="collapse-item" href="<?= base_url('admin/tambah_gallery'); ?>">Tambah Gallery</a>
                                            <a class="collapse-item" href="<?= base_url('admin/gallery'); ?>">Data Gallery</a>
                                            <a class="collapse-item" href="<?= base_url('admin/kategori_gallery'); ?>">Data Kategori</a>
                                        </div>
                                    </div>
                                    </li>

                                <?php if ($user['role_id'] == 2) : ?>
                                    <?php if ($menu == 'kontak') : ?>
                                        <li class="nav-item active">
                                        <?php else : ?>
                                        <li class="nav-item">
                                        <?php endif; ?>
                                        <a class="nav-link" href="<?= base_url('admin/kontak'); ?>">
                                            <i class="fas fa-fw fa-address-book"></i>
                                            <span>Kontak</span>
                                            <?php $notif_kontak; ?>
                                            <?php if ($notif_kontak) : ?>
                                                <span class="badge badge-danger" style="font-size: 10px;"> <?= $notif_kontak ?></span>
                                            <?php endif ?>
                                        </a>
                                        </li>

                                    <?php endif ?>
                                <?php endif ?>
                                    <!-- Divider -->
                                    <hr class="sidebar-divider">

                                    <!-- Heading -->
                                    <div class="sidebar-heading">
                                        Pengaturan
                                    </div>

                                <?php if ($user['role_id'] == 2) : ?>
                                    <?php if ($menu == 'menu-2') : ?>
                                        <li class="nav-item active">
                                        <?php else : ?>
                                        <li class="nav-item">
                                        <?php endif; ?>
                                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengaturanumum" aria-expanded="true" aria-controls="pengaturanumum">
                                            <i class="fa fa-wrench text-stock"></i> <span>Setting Umum</span>
                                        </a>
                                        <div id="pengaturanumum" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                                            <div class="bg-white py-2 collapse-inner rounded">
                                                <h6 class="collapse-header">Pilih Menu:</h6>
                                                <a class="collapse-item" href="<?= site_url('student/upgrade') ?>">Kenaikan Kelas</a>
                                                <a class="collapse-item" href="<?= site_url('student/pass') ?>">Kelulusan</a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                    <?php if ($menu == 'menu-5') : ?>
                                        <li class="nav-item active">
                                        <?php else : ?>
                                        <li class="nav-item">
                                        <?php endif; ?>
                                        
                                        <?php if ($user['role_id'] == '6') : ?>
                                            <a class="nav-link" href="<?= base_url('marketing/setting'); ?>">
                                        <?php else : ?>
                                            <a class="nav-link" href="<?= base_url('admin/setting'); ?>">
                                        <?php endif; ?>
                                            <i class="fas fa-fw fa-cog"></i>
                                            <span>Setting Akun</span>
                                        </a>
                                        </li>

                                        <!-- Nav Item - Tables -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="" data-toggle="modal" data-target="#logoutModal">
                                                <i class="fas fa-fw fa-sign-out-alt"></i>
                                                <span>Keluar</span>
                                            </a>
                                        </li>

                                        <!-- Divider -->
                                        <hr class="sidebar-divider d-none d-md-block">

                                        <!-- Sidebar Toggler (Sidebar) -->
                                        <div class="text-center d-none d-md-inline">
                                            <button class="rounded-circle border-0" id="sidebarToggle"></button>
                                        </div>

</ul>
<!-- End of Sidebar -->