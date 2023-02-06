<?php
$notif_izin      = $this->db->get_where('perizinan', ['status' => 'Proses', 'id_siswa' => $user['id']])->num_rows();
$notif_konseling = $this->db->get_where('konseling', ['status' => 'Respon', 'id_siswa' => $user['id']])->num_rows();
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $web['nama'] ?></h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Pendidikan</div>
                            <?php $nama_pendidikan = $this->db->get_where('data_pendidikan', ['id' => $user['id_pend']])->row_array(); ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $nama_pendidikan['nama'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-university fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kelas</div>
                            <?php $nama_kelas = $this->db->get_where('data_kelas', ['id' => $user['id_kelas']])->row_array(); ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $nama_kelas['nama'] ?> 
                            <?php if($nama_pendidikan['majors'] == 1) : ?>
                            - <?= $majors['nama'] ?>
                            <?php endif ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-door-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        


    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Color System -->
        <div class="col-xl-3 col-lg-4">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card bg-primary text-white shadow">
                        <div class="card-body">
                            <a href="<?= base_url('siswa/konseling') ?>" style="color:white">E-konseling <?php if ($notif_konseling) : ?><span class="badge badge-danger"><?= $notif_konseling ?></span><?php endif ?></a>
                            <div class="text-white-50 small">Total :
                                <span class="badge badge-success"><?= $sum_konsel ?></span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-4">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            <a href="<?= base_url('siswa/perizinan') ?>" style="color:white">Perizinan <?php if ($notif_izin) : ?><span class="badge badge-danger"><?= $notif_izin ?></span><?php endif ?></a>
                            <div class="text-white-50 small">Total :
                                <span class="badge badge-primary"><?= $sum_izin ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-4">
                    <div class="card bg-info text-white shadow">
                        <div class="card-body">
                            <a href="<?= base_url('siswa/pelanggaran') ?>" style="color:white">Pelanggaran</a>
                            <div class="text-white-50 small">Total :
                                <span class="badge badge-warning"><?= $sum_takzir ?></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data siswa</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Laki - Laki
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Perempuan
                        </span>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-5 col-lg-6">
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


<script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Perempuan", "Laki - Laki"],
            datasets: [{
                data: [<?= $sum_wanita ?>, <?= $sum_pria ?>],
                backgroundColor: ['#4e73df', '#1cc88a'],
                hoverBackgroundColor: ['#2e59d9', '#17a673'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
</script>
<!-- /.container-fluid -->
<script type="text/javascript">
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Perempuan", "Laki-laki"],
            datasets: [{
                data: [<?= $siswa_pr ?>, <?= $siswa_lk ?>],
                backgroundColor: ['#36b9cc', '#1cc88a'],
                hoverBackgroundColor: ['#2c9faf', '#17a673'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
</script>