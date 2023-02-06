<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="col-md-12">
        <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $this->session->flashdata('messageA') ?>
        </div>

        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4 class="mb-5 header-title">
                        <a href="<?= base_url('admin/daftar_absen') ?>" class="btn btn-sm btn-danger mb-3"><i class="fa fa-angle-double-left"></i> Kembali</a>
                        <?php if ($daftar_absen['status'] == 'Belum Selesai') :  ?>
                            <a href="" class="btn btn-warning mb-3 btn-sm" data-toggle="modal" data-target="#tutupData"><i class="fa fa-times"></i> Tutup Absen</a>

                        <?php elseif ($daftar_absen['status'] == 'Selesai') :  ?>
                            <a href="" class="btn btn-info mb-3 btn-sm" data-toggle="modal" data-target="#printData"><i class="fa fa-print"></i> Print</a>
                        <?php endif ?>
                        <div class="float-right mr-1">
                            <span href="" class="btn btn-block btn-success btn-sm"><i class="fa fa-calendar-alt"></i> <?= date('d-m-Y', strtotime($tgl_absen)); ?></span>
                        </div>
                    </h4>


                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>

                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">siswa</th>
                                    <th scope="col">Tanggal & Waktu</th>
                                    <th scope="col">Status</th>
                                    <?php if ($daftar_absen['status'] == 'Belum Selesai') :  ?>
                                        <th scope="col">Action</th>
                                    <?php endif ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($absen as $d) : ?>
                                    <?php $san = $this->db->get_where('siswa', ['id' => $d['id_siswa']])->row_array(); ?>

                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $san['nama'] ?></td>
                                        <td><?= mediumdate_indo(date($d['tgl'])) ?>, <?= $d['waktu'] ?></td>
                                        <td>
                                            <?php if ($d['status'] == 'Belum Absen') :  ?>
                                                <span class="badge badge-primary"><?= $d['status'] ?></span>
                                            <?php elseif ($d['status'] == 'Hadir') :  ?>
                                                <span class="badge badge-success"><?= $d['status'] ?></span>
                                            <?php elseif ($d['status'] == 'Tidak Hadir') :  ?>
                                                <span class="badge badge-danger"><?= $d['status'] ?></span>
                                            <?php elseif ($d['status'] == 'Izin') :  ?>
                                                <span class="badge badge-warning"><?= $d['status'] ?></span>
                                                <span class="badge badge-primary"><?= $d['ket'] ?></span>
                                            <?php endif ?>
                                        </td>
                                        <?php if ($daftar_absen['status'] == 'Belum Selesai') :  ?>
                                            <td>
                                                <?php if ($d['status'] == 'Belum Absen') :  ?>
                                                    <a href="" class="badge badge-info" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>"><i class="fa fa-plus-circle"></i> Absen</a>
                                                    <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>"><i class="fa fa-trash"></i> Hapus</a>
                                                <?php else : ?>
                                                    <a href="" class="badge badge-warning" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>"><i class="fa fa-trash"></i> Hapus</a>
                                                <?php endif ?>
                                            </td>
                                        <?php endif ?>
                                    </tr>

                                    <!--update Data-->
                                    <div class="modal fade" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Pilih Status Absen</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_status_absen/admin') ?>" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                        <div class="form-group">
                                                            <label for="absen">Status Absen</label>
                                                            <select class="form-control" id="absen" name="absen" onchange="getval(this);">
                                                                <option value="">- Pilih status absen -</option>

                                                                <option <?php if ('Belum Absen' == $d['status']) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="Belum Absen">Belum Absen</option>
                                                                <option <?php if ('Hadir' == $d['status']) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="Hadir">Hadir</option>
                                                                <option <?php if ('Tidak Hadir' == $d['status']) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="Tidak Hadir">Tidak Hadir</option>
                                                                <option <?php if ('Izin' == $d['status']) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="Izin">Izin</option>

                                                            </select>
                                                        </div>
                                                    

                                                        <div id="izins" class="form-group">
                                                            <label>Perizinan</label>
                                                            <select class="form-control" id="izin" name="izin">
                                                                <option>- Pilih Perizinan -</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <?php if ($d['status'] == 'Belum Absen') :  ?>
                                                            <button type="submit" class="btn btn-success">Submit</button>
                                                        <?php else : ?>
                                                            <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button>
                                                        <?php endif ?>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!--delete Data-->
                                    <div class="modal fade" id="deleteData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus siswa</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus siswa <b><?= $san['nama']; ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_absen_siswa/admin/' . $tgl_absen . '') ?>?id=<?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php $i++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tutupData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Tutup Absen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menutup absen tanggal <b><?= date('d-m-Y', strtotime($tgl_absen)) ?></b></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="<?= base_url('update/tutup_absen_kelas/admin?id=') ?><?= $daftar_absen['id'] ?>" class="btn btn-warning">Tutup Absen</a>
                </div>

            </div>
        </div>
    </div>

    <!--print Data-->
    <div class="modal fade" id="printData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel"><i class="fa fa-print"></i> Print Absen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form target="_blank" action="<?= base_url('laporan/laporan_absen/') ?>" method="post">
                    <div class="modal-body">
                        <?php $kelas = $this->db->get_where('data_kelas', ['id' => $daftar_absen['id_kelas']])->row_array(); ?>
                        <div class="form-group">
                            <div class="card bg-secondary text-white shadow">
                                <div class="card-body">
                                    Absensi kelas : <?= $kelas['nama'] ?>
                                    <div class="text-white-50 small">Tanggal : <?= mediumdate_indo(date($daftar_absen['tgl'])) ?></div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?= $daftar_absen['id'] ?>">
                        <div class="form-group">
                            <?php $hadir = $this->db->get_where('absen', ['role_absen' => $daftar_absen['id'], 'status' => 'Hadir'])->num_rows(); ?>
                            <?php $no_hadir = $this->db->get_where('absen', ['role_absen' => $daftar_absen['id'], 'status' => 'Tidak Hadir'])->num_rows(); ?>
                            <?php $izin = $this->db->get_where('absen', ['role_absen' => $daftar_absen['id'], 'status' => 'Izin'])->num_rows(); ?>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Hadir</td>
                                        <td><?= $hadir ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tidak Hadir</td>
                                        <td><?= $no_hadir ?></td>
                                    </tr>
                                    <tr>
                                        <td>Izin</td>
                                        <td><?= $izin ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> Print</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script type="text/javascript">
$(document).ready(function() {
$("#izins").hide();
$('#absen').change(function() {
    $.ajax({
        type: 'POST',
        url: '<?= site_url('get/get_izin'); ?>',
        data: {
            absen: this.value
        },
        cache: false,
        success: function(response) {
            $('#izin').html(response);
        }
    });
    if(this.value == 'Izin'){
        $("#izins").show();
    }else{
        $("#izins").hide();
    }

});

});
</script>