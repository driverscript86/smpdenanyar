<?php
$notif_izin      = $this->db->get_where('perizinan', ['status' => 'Pending', 'id_pend' => $user['id_pend']])->num_rows();
$notif_konseling = $this->db->get_where('konseling', ['status' => 'Pending', 'id_peng' => $user['id']])->num_rows();
$notif_kontak = $this->db->get_where('kontak', ['status' => 1])->num_rows();
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $web['nama'] ?></h1>
        <?php if ($user['role_id'] == '2') : ?>
            <a href="<?= base_url('admin/tambah_siswa'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah siswa</a>
        <?php endif ?>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Pemasukan Harian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($msk, 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php if ($user['role_id'] !== '4') : ?>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pengeluaran Harian</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($klr, 0, ',', '.') ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-check-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">

                                 <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Total Pemasukan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($tot_msk, 0, ',', '.') ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> Total Pengeluaran</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($tot_klr, 0, ',', '.') ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-check-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>

    </div>


    <!-- Content Row -->

    <div class="row">
        <!-- Pie Chart -->
        <!-- <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Total siswa</h6>
                </div>
                <
                <div class="card-body">
                    
                
                </div>
            </div>
        </div> -->


        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile Website</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 20rem;" src="<?= base_url('assets/img/' . $about['img']) ?>" alt="">
                    </div>
                    <p><?= substr($about['about'], 0, 200) ?>..</p>
                    <a target="_blank" href="<?= base_url('about') ?>">Lihat Selengkapnya ⇥</a>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Page level custom scripts -->
<script src="<?= base_url('assets/'); ?>js/demo/chart-area-demo.js"></script>
<script type="text/javascript">
 
</script>