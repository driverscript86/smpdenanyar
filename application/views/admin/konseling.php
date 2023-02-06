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
                                    <th scope="col">Nama siswa</th>
                                    <th scope="col">Kelas</th>
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
                                    <?php $san = $this->db->get_where('siswa', ['id' => $d['id_siswa']])->row_array(); ?>
                                    <?php $kam = $this->db->get_where('data_kelas', ['id' => $d['id_kelas']])->row_array(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $san['nama'] ?>
                                            <?php if ($d['status']  == 'Terbaca') : ?>
                                                <span class="badge badge-info badge-pill disabled float-right" aria-disabled="true"><i class="fa fa-eye"></i></span>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $kam['nama'] ?></td>
                                        <td><?= $d['topik'] ?></td>
                                        <td><?= $d['solusi'] ?></td>
                                        <td><?= mediumdate_indo(date($d['tgl_pengajuan'])); ?></td>
                                        <td>
                                            <?php if ($d['status']  == 'Terbaca') : ?>
                                                <span class="badge badge-primary badge-pill disabled" aria-disabled="true">Proses</span>
                                            <?php elseif ($d['status']  == 'Terbaca siswa') : ?>
                                                <span class="badge badge-info badge-pill disabled" aria-disabled="true">Terbaca</span>
                                            <?php elseif ($d['status']  == 'Respon') : ?>
                                                <span class="badge badge-primary badge-pill disabled" aria-disabled="true">Proses</span>
                                            <?php elseif ($d['status']  == 'Respon siswa') : ?>
                                                <span class="badge badge-primary badge-pill disabled" aria-disabled="true">Respon</span>
                                            <?php elseif ($d['status']  == 'Pending') : ?>
                                                <span class="badge badge-warning badge-pill disabled" aria-disabled="true">Pending</span>
                                            <?php elseif ($d['status']  == 'Selesai') : ?>
                                                <span class="badge badge-success badge-pill disabled" aria-disabled="true">Selesai</span>
                                                <span class="badge badge-warning">Penutup <?= $d['penutup'] ?></span>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if ($d['status']  !== 'Selesai') : ?>
                                                <a href="<?= base_url('admin/balas_konseling?id=') ?><?= $this->secure->encrypt($d['id']) ?>" class="badge badge-success">Balas</a>
                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#tutupData<?= $d['id'] ?>">Tutup</a>
                                            <?php endif ?>
                                            <?php if ($d['status']  == 'Selesai') : ?>
                                                <a href="" class="badge badge-info" data-toggle="modal" data-target="#printData<?= $d['id'] ?>"><i class="fa fa-print"></i> Print</a>
                                            <?php endif ?>
                                            <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>">Hapus</a>
                                        </td>
                                    </tr>

                                <?php $i++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($konseling as $d) : ?>

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
                        <p>Anda yakin ingin menutup data <b><?= $san['nama'] ?></b> dengan konseling <b><?= $d['topik'] ?></b></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="<?= base_url('update/tutup_konseling/admin') ?>" method="post">
                            <input type="hidden" name="id" value="<?= $d['id'] ?>">
                            <input type="hidden" name="siswa" value="<?= $san['nama'] ?>">
                            <input type="hidden" name="topik" value="<?= $d['topik'] ?>">
                            <input type="hidden" name="penutup" value="Admin">
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
                        <p>Anda yakin ingin menghapus data <b><?= $san['nama'] ?></b> dengan konseling <b><?= $d['topik'] ?></b></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a href="<?= base_url('hapus/hapus_konseling?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                    </div>

                </div>
            </div>
        </div>

        <!--print Data-->
        <div class="modal fade" id="printData<?= $d['id'] ?>" role="dialog" aria-labelledby="printDataLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="printDataLabel"><i class="fa fa-print"></i> Print Konseling</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form target="_blank" action="<?= base_url('laporan/laporan_konseling') ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="alert alert-dark" role="alert">
                                    <b>Nama :</b> <?= $san['nama'] ?></br>
                                    <b>Tanggal pengajuan :</b> <?= mediumdate_indo(date($d['tgl_pengajuan'])); ?></br>
                                    <b>Tanggal tutup :</b> <?= mediumdate_indo(date($d['tgl_tutup'])); ?>
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="card bg-secondary text-white shadow">
                                    <div class="card-body">
                                        <?= $d['topik'] ?>
                                        <br />
                                        <div class="text-white-50 small">
                                            <?= $d['solusi']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" value="<?= $d['id'] ?>" name="id">
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
    <div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Tambah Konseling</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/konseling') ?>" method="post">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="siswa">Tanggal</label>
                            <input type="text" class="form-control" value="<?= mediumdate_indo(date(date('Y-m-d'))); ?>" readonly>
                            <input type="hidden" name="siswa" value="<?= $user['nama'] ?>">
                        </div>


                        <div class="form-group">
                            <label for="siswa">Nama siswa</label>
                            <select style="width:100%!important;" class="form-control js-example-basic-single" name="siswa">
                            </select>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            ajax: {
                url: "<?= base_url('get/getsiswa/'.$user['id']) ?>",
                dataType: "json",
                type: "post",
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                    }
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Ketik Nama siswa',
            minimumInputLength: 3,
        });
    });
</script>