<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="col-md-12">
        <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $title ?> Tanggal : <?= mediumdate_indo(date($tgl_absen)) ?></h1>
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
                        <a href="<?= base_url('admin/absen_pegawai') ?>" class="btn btn-sm btn-danger mb-3"><i class="fa fa-angle-double-left"></i> Kembali</a>
                        <?php if ($daftar_absen['status'] == 0) :  ?>
                            <a href="" class="btn btn-warning mb-3 btn-sm" data-toggle="modal" data-target="#tutupData"><i class="fa fa-times"></i> Tutup Absen</a>

                        <?php elseif ($daftar_absen['status'] == 1) :  ?>
                            <a href="" class="btn btn-info mb-3 btn-sm" data-toggle="modal" data-target="#printData"><i class="fa fa-print"></i> Print</a>
                        <?php endif ?>
                        <div class="float-right mr-1">
                            <span href="" class="btn btn-block btn-success btn-sm"><i class="fa fa-calendar-alt"></i> <?= date('d-m-Y', strtotime($tgl_absen)); ?></span>
                        </div>
                    </h4>


                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '
          </div>') ?>
                    <?= $this->session->flashdata('message') ?>

                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Pegawai</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Jam Masuk</th>
                                    <th scope="col">Absen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($absen as $d) : ?>
                                    <?php $san = $this->db->get_where('karyawan', ['id' => $d['id_peng']])->row_array(); ?>

                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $san['nama'] ?></td>
                                        <td><?= mediumdate_indo(date($d['tgl'])) ?></td>
                                        <td><?= $d['jam_masuk'] ?></td>
                                        <td>
                                            <?php if ($d['status'] == 0) :  ?>
                                                <a href="" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>" class="badge badge-primary">Belum Absen</a>
                                            <?php elseif ($d['status'] == 1) :  ?>
                                                <a href="" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>" class="badge badge-success">Hadir</a>
                                            <?php elseif ($d['status'] == 2) :  ?>
                                                <a href="" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>" class="badge badge-danger">Alpha</a>
                                            <?php elseif ($d['status'] == 3) :  ?>
                                                <a href="" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>" class="badge badge-warning">Sakit</a>
                                            <?php elseif ($d['status'] == 4) :  ?>
                                                <a href="" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>" class="badge badge-warning">Izin</a>
                                            <?php endif ?>
                                        </td>
                                    </tr>

                                    <!--update Jam Data-->
                                    <div class="modal fade" id="jamData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Update Jam</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form action="<?= base_url('update/update_time_absen_pegawai') ?>" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                        <div class="form-group">
                                                            <div class='input-group date' id='datetimepicker3'>
                                                                <input type='time' name="jam_keluar" class="form-control">
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <?php if ($d['status'] == 0) :  ?>
                                                            <button type="submit" class="btn btn-success">Submit</button>
                                                        <?php else : ?>
                                                            <button type="submit" class="btn btn-success"><i class="fa fa-redo"></i> Update</button>
                                                        <?php endif ?>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

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
                                                <form action="<?= base_url('update/update_status_absen_pegawai') ?>" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                        <div class="form-group">
                                                            <label for="absen">Status Absen</label>
                                                            <select class="form-control" id="absen" name="absen">
                                                                <option value="">- Pilih status absen -</option>

                                                                <option <?php if (0 == $d['status']) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="0">Belum Absen</option>
                                                                <option <?php if (1 == $d['status']) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="1">Hadir</option>
                                                                <option <?php if (2 == $d['status']) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="2">Alpha</option>
                                                                <option <?php if (3 == $d['status']) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="3">Sakit</option>
                                                                <option <?php if (4 == $d['status']) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="4">Izin</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <?php if ($d['status'] == 0) :  ?>
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
                    <a href="<?= base_url('update/tutup_absen_pegawai/view_absen/' . $daftar_absen['tgl'] . '?id=') ?><?= $daftar_absen['id'] ?>" class="btn btn-warning">Tutup Absen</a>
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
                <form target="_blank" action="<?= base_url('laporan/laporan_absen_pegawai/') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="card bg-secondary text-white shadow">
                                <div class="card-body">
                                    Absensi pegawai
                                    <div class="text-white-50 small">Tanggal : <?= mediumdate_indo(date($daftar_absen['tgl'])) ?></div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?= $daftar_absen['id'] ?>">
                        <div class="form-group">
                            <?php $hadir = $this->db->get_where('absen_pegawai', ['role_absen' => $daftar_absen['id'], 'status' => 1])->num_rows(); ?>
                            <?php $alpha = $this->db->get_where('absen_pegawai', ['role_absen' => $daftar_absen['id'], 'status' => 2])->num_rows(); ?>
                            <?php $sakit = $this->db->get_where('absen_pegawai', ['role_absen' => $daftar_absen['id'], 'status' => 3])->num_rows(); ?>
                            <?php $izin  = $this->db->get_where('absen_pegawai', ['role_absen' => $daftar_absen['id'], 'status' => 4])->num_rows(); ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Absen</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Hadir</td>
                                        <td><?= $hadir ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alpha</td>
                                        <td><?= $alpha ?></td>
                                    </tr>
                                    <tr>
                                        <td>Sakit</td>
                                        <td><?= $sakit ?></td>
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