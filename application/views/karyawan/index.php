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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Penempatan</div>
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


        <?php if ($user['role_id'] !== '4') : ?>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="<?= base_url('admin/daftar_absen') ?>">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Presensi</div>
                                </a>
                                <a href="#" class="badge badge-success" data-toggle="modal" data-target="#Absen">Absen baru</a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list-alt fa-2x text-gray-300"></i>
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

                                <?php if ($user['role_id'] == '2') : ?>
                                    <a href="<?= base_url('admin/daftar_siswa') ?>">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">siswa</div>
                                    </a>
                                <?php else : ?>
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">siswa</div>
                                <?php endif ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($sum_siswa, 0, ',', '.') ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                <?php if ($user['role_id'] == '2') : ?>
                                    <a href="<?= base_url('admin/kelas') ?>">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> kelas</div>
                                    </a>
                                <?php else : ?>
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Kelas</div>
                                <?php endif ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $kelas ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-door-open fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>

    </div>


    <!-- Content Row -->

    <div class="row">
        <?php if ($user['role_id'] !== '4') : ?>
            <!-- Color System -->
            <div class="col-xl-4 col-lg-5">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-primary text-white shadow">
                            <div class="card-body">
                                <a href="<?= base_url('admin/konseling') ?>" style="color:white">E-konseling <?php if ($notif_konseling) : ?><span class="badge badge-danger"><?= $notif_konseling ?></span><?php endif ?></a>
                                <div class="text-white-50 small">Total :
                                    <span class="badge badge-success"><?= $sum_konsel ?></span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-success text-white shadow">
                            <div class="card-body">
                                <a href="<?= base_url('admin/perizinan') ?>" style="color:white">Perizinan <?php if ($notif_izin) : ?><span class="badge badge-danger"><?= $notif_izin ?></span><?php endif ?></a>
                                <div class="text-white-50 small">Total :
                                    <span class="badge badge-primary"><?= $sum_izin ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-info text-white shadow">
                            <div class="card-body">
                                <a href="<?= base_url('admin/pelanggaran') ?>" style="color:white">Pelanggaran</a>
                                <div class="text-white-50 small">Total :
                                    <span class="badge badge-warning"><?= $sum_takzir ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($user['role_id'] == '2') : ?>
                        <div class="col-lg-6 mb-4">
                            <div class="card bg-warning text-white shadow">
                                <div class="card-body">
                                    <a href="<?= base_url('admin/kontak') ?>" style="color:white">Kontak <?php if ($notif_kontak) : ?>
                                            <span class="badge badge-danger"> <?= $notif_kontak ?></span>
                                        <?php endif ?></a>
                                    <div class="text-white-50 small">Total :
                                        <span class="badge badge-info"><?= number_format($sum_kontak, 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="<?= base_url('admin/acara') ?>">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Acara</div>
                                            </a>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($sum_acara, 0, ',', '.') ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="<?= base_url('admin/gallery') ?>">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Gallery</div>
                                            </a>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($sum_gallery, 0, ',', '.') ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-image fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>

                </div>
            </div>
        <?php endif ?>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Total siswa : <?= number_format($tot_siswa, 0, ',', '.') ?></h6>
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

    <!-- Content Row -->

    <div class="row">

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list fa-fw"></i> 7 siswa Dengan Point Terendah</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="50px">Top</th>
                                    <th>Nama</th>
                                    <th>Point</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($siswa as $sis) : ?>
                                    <?php if ($no == 1) {
                                        $label = "success";
                                    } else if ($no == 2) {
                                        $label = "primary";
                                    } else if ($no == 3) {
                                        $label = "info";
                                    } else if ($no == 4) {
                                        $label = "warning";
                                    } else if ($no == 5) {
                                        $label = "secondary";
                                    } else if ($no == 6) {
                                        $label = "dark";
                                    } else if ($no == 7) {
                                        $label = "danger";
                                    } ?>
                                    <tr>

                                        <td class="text-center">
                                            <button class="btn-circle btn-<?= $label ?> btn-sm"><?= $no ?></button>
                                        </td>
                                        <td><?= $sis['nama']; ?></td>
                                        <td><?= number_format($sis['point'], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php $no++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list fa-fw"></i> 7 Jenis Pelanggaran Yang Sering Terjadi</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="50px">Top</th>
                                    <th>Nama</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($pelanggaran as $top) : ?>
                                    <?php if ($no == 1) {
                                        $label = "success";
                                    } else if ($no == 2) {
                                        $icon = '';
                                        $label = "primary";
                                    } else if ($no == 3) {
                                        $icon = '';
                                        $label = "info";
                                    } else if ($no == 4) {
                                        $icon = '';
                                        $label = "warning";
                                    } else if ($no == 5) {
                                        $icon = '';
                                        $label = "secondary";
                                    } else if ($no == 6) {
                                        $icon = '';
                                        $label = "dark";
                                    } else if ($no == 7) {
                                        $icon = '';
                                        $label = "danger";
                                    } ?>
                                    <tr>
                                        <td class="text-center">
                                            <button class="btn-circle btn-<?= $label ?> btn-sm"><?= $no ?></button>
                                        </td>
                                        <td><?= $top['nama']; ?></td>
                                        <td><?= number_format($top['jumlah'], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php $no++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>


<!-- Modal -->
<div class="modal fade" id="Absen" role="dialog" aria-labelledby="AbsenLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AbsenLabel">Tambah Absen Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/daftar_absen') ?>" method="post">
                <div class="modal-body">

                <div class="form-group">
                        <label for="pendidikan">Nama Pendidikan</label>
                        <select class="form-control" id="pendidikan" name="pendidikan">
                            <option value="">- Pilih Pendidikan -</option>
                            <?php foreach ($pendidikan as $a) : ?>
                                <option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <?= form_error('pendidikan', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="kelas">Nama Kelas</label>
                        <select class="form-control" id="kelas" name="kelas">
                            <option value="">- Pilih pendidikan dahulu -</option>

                        </select>
                        <?= form_error('kelas', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input class="form-control" type="date" id="tanggal" name="tanggal">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Page level custom scripts -->
<script src="<?= base_url('assets/'); ?>js/demo/chart-area-demo.js"></script>
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
    $(document).ready(function() {
        var role_id = <?= $user['role_id'] ?>;
        var id_peng = <?= $user['id'] ?>;
        $('#pendidikan').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('get/get_kelas/'); ?>',
                data: {
                    role_id: role_id,
                    id_peng: id_peng,
                    pendidikan: this.value
                },
                cache: false,
                success: function(response) {
                    $('#kelas').html();
                    $('#kelas').html(response);
                }
            });
        });
    });
</script>