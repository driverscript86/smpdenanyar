<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?>
                        <div class="float-right mr-1">
                            <a href="" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#importData"><i class="fa fa-file-import"></i> Import</a>
                        </div>
                        <div class="float-right pr-1">
                            <a href="" class="btn btn-block btn-sm btn-info" data-toggle="modal" data-target="#Print"><i class="fa fa-print"></i> Laporan Absen</a>
                        </div>
                    </h1>
                    <?= $this->session->flashdata('message') ?>
                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Hadir</th>
                                    <th scope="col">Tidak Hadir</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($absen_pegawai as $d) : ?>
                                    <?php $h = $this->db->get_where('absen_pegawai', ['role_absen' => $d['id'], 'status' => 1])->num_rows(); ?>
                                    <?php $th = $this->db->get_where('absen_pegawai', ['role_absen' => $d['id'], 'status !=' => 1])->num_rows(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= mediumdate_indo(date($d['tgl'])); ?></td>
                                        <td><?= $h ?></td>
                                        <td><?= $th ?></td>
                                        <td><?php if ($d['status'] == 0) : ?>
                                                <span class="badge badge-danger">Belum selesai</span>
                                            <?php elseif ($d['status'] == 1) : ?>
                                                <span class="badge badge-success">Selesai</span>
                                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#batalData<?= $d['id'] ?>">Batal</a>
                                            <?php endif ?>
                                        </td>
                                        <td><?php if ($d['status'] == '1') : ?>
                                                <a href="" class="badge badge-info" data-toggle="modal" data-target="#printData<?= $d['id'] ?>"><i class="fa fa-print"></i> Print</a>
                                                <a href="<?= base_url('admin/view_absen_pegawai/') ?><?= $d['tgl'] ?>?id=<?= $d['id'] ?>" class="badge badge-success"><i class="fa fa-eye"></i> View</a>
                                            <?php endif ?>
                                            <?php if ($d['status'] == '0') : ?>
                                                <a href="<?= base_url('admin/view_absen_pegawai/') ?><?= $d['tgl'] ?>?id=<?= $d['id'] ?>" class="badge badge-primary">View</a>
                                                <a href="" class="badge badge-warning" data-toggle="modal" data-target="#tutupData<?= $d['id'] ?>">Tutup Absen</a>
                                            <?php endif ?>
                                            <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>"><i class="fa fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>

                                    <!--update Data-->
                                    <div class="modal fade" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Ubah Data Gaji</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_data_divisi') ?>" method="post">
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal</label>
                                                            <input class="form-control" type="date" id="tanggal" name="tanggal" value="<?= set_value('tanggal') ?>">
                                                            <?= form_error('tanggal', '<small class="text-danger pl-3">', '</small>'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Ubah</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!--tutup Data-->
                                    <div class="modal fade" id="tutupData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Tutup Absen</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menutup absen pegawai tanggal <b><?= mediumdate_indo(date($d['tgl'])) ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('update/tutup_absen_pegawai/daftar_absen/' . $d['tgl'] . '?id=' . $d['id']) ?>" class="btn btn-warning">Tutup Absen</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!--batal Data-->
                                    <div class="modal fade" id="batalData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Batal Absensi Pegawai</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin membatalkan absensi tanggal <b><?= mediumdate_indo(date($d['tgl'])) ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('update/batal_absen_pegawai/' . $d['tgl'] . '?id=') ?><?= $d['id'] ?>" class="btn btn-danger">Batalkan</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!--delete Data-->
                                    <div class="modal fade" id="deleteData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus Absensi Pegawai</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus absensi tanggal <b><?= mediumdate_indo(date($d['tgl'])) ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_absen_pegawai?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php foreach ($absen_pegawai as $d) : ?>
    <!--print Data-->
    <div class="modal fade" id="printData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
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
                                    <div class="text-white-50 small">Tanggal : <?= mediumdate_indo(date($d['tgl'])) ?></div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
                        <div class="form-group">
                            <?php $hadir = $this->db->get_where('absen_pegawai', ['role_absen' => $d['id'], 'status' => 1])->num_rows(); ?>
                            <?php $alpha = $this->db->get_where('absen_pegawai', ['role_absen' => $d['id'], 'status' => 2])->num_rows(); ?>
                            <?php $sakit = $this->db->get_where('absen_pegawai', ['role_absen' => $d['id'], 'status' => 3])->num_rows(); ?>
                            <?php $izin  = $this->db->get_where('absen_pegawai', ['role_absen' => $d['id'], 'status' => 4])->num_rows(); ?>
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
<?php endforeach ?>

<!-- Modal -->
<div class="modal fade" id="Print" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Laporan Absensi Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form target="_blank" action="<?= base_url('laporan/laporan_absen_pegawai_bulanan') ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="tgl_awal">Dari Tanggal</label>
                        <input class="form-control" type="date" id="tgl_awal" name="tgl_awal" value="<?= set_value('tgl_awal') ?>">
                        <?= form_error('tgl_awal', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="tgl_akhir">Sampai Tanggal</label>
                        <input class="form-control" type="date" id="tgl_akhir" name="tgl_akhir" value="<?= set_value('tgl_akhir') ?>">
                        <?= form_error('tgl_akhir', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                </div>

            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="importData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Import Data Absensi Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?= form_open_multipart(); ?>

                <div class="form-group files">
                    <label>Upload File Excel</label>
                    <input type="file" class="form-control" multiple="" name="excel">
                </div>

                <label>Contoh data excel
                    <a href="<?= base_url('assets/contoh/data_absen.xlsx') ?>" class="badge badge-pill badge-success" download>Download</a></label>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" name="submit" value="upload" class="btn btn-success"><i class="fa fa-file-import"></i> Import</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>