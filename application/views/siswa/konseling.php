<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">
            <?= form_error(
                'topik',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>'
            ) ?>
            <?= form_error(
                'solusi',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>'
            ) ?>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4 class="mb-5 header-title"><i class="fas fa-list"></i> <?= $title ?>

                        <div class="float-right">
                            <a href="" class="btn btn-block btn-sm btn-info" data-toggle="modal" data-target="#addNewData"><i class="fa fa-plus-circle"></i> Tambah</a>
                        </div>
                    </h4>
                    <?= $this->session->flashdata('message') ?>

                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Topik masalah</th>
                                    <th scope="col">Solusi</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($konseling as $d) : ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $d['topik'] ?>
                                            <?php if ($d['status']  == 'Terbaca siswa') : ?>
                                                <span class="badge badge-info badge-pill disabled float-right" aria-disabled="true"><i class="fa fa-eye"></i></span>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $d['solusi'] ?></td>
                                        <td><?= date('d-m-Y', strtotime($d['tgl_pengajuan'])); ?></td>
                                        <td>
                                            <?php if ($d['status']  == 'Respon') : ?>
                                                <span class="badge badge-primary badge-pill disabled" aria-disabled="true">Respon</span>
                                            <?php elseif ($d['status']  == 'Respon siswa') : ?>
                                                <span class="badge badge-primary badge-pill disabled" aria-disabled="true">Proses</span>
                                            <?php elseif ($d['status']  == 'Terbaca') : ?>
                                                <span class="badge badge-info badge-pill disabled" aria-disabled="true">Terbaca</span>
                                            <?php elseif ($d['status']  == 'Terbaca siswa') : ?>
                                                <span class="badge badge-primary badge-pill disabled" aria-disabled="true">Proses</span>
                                            <?php elseif ($d['status']  == 'Selesai') : ?>
                                                <span class="badge badge-success badge-pill disabled" aria-disabled="true">Selesai</span>
                                            <?php elseif ($d['status']  == 'Pending') : ?>
                                                <span class="badge badge-warning badge-pill disabled" aria-disabled="true">Pending</span>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if (($d['status']  !== 'Selesai') && ($d['status']  !== 'Pending')) : ?>
                                                <a href="<?= base_url('siswa/balas_konseling?id=') ?><?= $this->secure->encrypt($d['id']) ?>" class="badge badge-success">Balas</a>
                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#tutupData<?= $d['id'] ?>">Tutup</a>
                                            <?php endif ?>

                                            <?php if ($d['status']  == 'Pending') : ?>
                                                <a href="" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>">edit</a>
                                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>"><i class="fa fa-trash"></i> Hapus</a>
                                            <?php endif ?>

                                            <?php if ($d['status']  == 'Selesai') : ?>
                                                <span class="badge badge-info">Penutup <?= $d['penutup'] ?></span>
                                            <?php endif ?>
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Ubah Konseling</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_konseling/siswa') ?>" method="post">
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="siswa">Tanggal</label>
                                                            <input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($d['tgl_pengajuan'])); ?>" readonly>
                                                            <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                            <input type="hidden" name="siswa" value="<?= $user['id'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="topik">Topik Masalah</label>
                                                            <input type="text" class="form-control" name="topik" value="<?= $d['topik'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="solusi">Solusi</label>
                                                            <textarea class="form-control" type="text" id="solusi" name="solusi"><?= $d['solusi'] ?></textarea>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Ubah</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal fade" id="tutupData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Tutup Konseling</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menutup data <b><?= $d['topik'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <form action="<?= base_url('update/tutup_konseling/siswa') ?>" method="post">
                                                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                        <input type="hidden" name="siswa" value="<?= $user['nama'] ?>">
                                                        <input type="hidden" name="topik" value="<?= $d['topik'] ?>">
                                                        <input type="hidden" name="penutup" value="siswa">
                                                        <button type="submit" class="btn btn-warning">Tutup</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!--delete Data-->
                                    <div class="modal fade" id="deleteData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus Konseling</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus data konseling <b><?= $d['topik'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_konseling/siswa?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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


    <!-- Modal -->
    <div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Tambah Konseling</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('siswa/konseling') ?>" method="post">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="siswa">Tanggal</label>
                            <input type="text" class="form-control" value="<?= date('d-m-Y', strtotime(date('Y-m-d'))); ?>" readonly>
                            <input type="hidden" name="siswa" value="<?= $user['id'] ?>">
                        </div>

                        <div class="form-group">
                            <label for="topik">Topik Masalah</label>
                            <input type="text" class="form-control" name="topik">
                        </div>

                        <div class="form-group">
                            <label for="solusi">Solusi</label>
                            <textarea class="form-control" type="text" id="solusi" name="solusi"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->