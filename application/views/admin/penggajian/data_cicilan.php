<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?>
                        <div class="float-right">
                            <a href="" class="btn btn-block btn-sm btn-info" data-toggle="modal" data-target="#addNewData"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                        </div>
                    </h1>
                    <?= $this->session->flashdata('message') ?>
                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Karyawan</th>
                                    <th scope="col">Cicilan</th>
                                    <th scope="col">Nominal</th>
                                    <th scope="col">Tenor</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($cicilan as $d) : ?>
                                    <?php $guru = $this->db->get_where('karyawan', ['id' => $d['id_peng']])->row_array(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $guru['nama'] ?></td>
                                        <td><?= $d['nama'] ?></td>
                                        <td>Rp. <?= number_format($d['nominal'], 0, ',', '.') ?></td>
                                        <td><?php if ($d['tenor'] == 0) : ?>
                                                <span class="badge badge-success" aria-disabled="">Lunas</span>
                                            <?php else : ?>
                                                <b><?= number_format($d['tenor'], 0, ',', '.') ?>X</b>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if ($d['status'] == 'Belum Lunas') : ?>
                                                <span class="badge badge-primary"><?= $d['status'] ?></span>
                                            <?php elseif ($d['status'] == 'Lunas') : ?>
                                                <span class="badge badge-success"><?= $d['status'] ?></span> <b><?= mediumdate_indo(date($d['tgl_lunas'])) ?></b>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>">Edit</a>
                                            <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>">Hapus</a>

                                        </td>
                                    </tr>
                                    <!--update Data-->
                                    <div class="modal fade" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Ubah Data Cicilan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_data_cicilan') ?>" method="post">
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">
                                                            <label for="">Nama Cicilan</label>
                                                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $d['nama'] ?>" placeholder="Nama Cicilan">
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="hidden" name="karyawan1" value="<?= $d['id_peng'] ?>">
                                                            <label for="karyawan">Nama Karyawan</label>
                                                            <select style="width:100%!important;" class="form-control js-example-basic-single" name="karyawan">
                                                            </select>
                                                            <small>Biarkan kosong jika tidak diubah.</small>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Nominal</label>
                                                            <input type="number" class="form-control" id="nominal" name="nominal" value="<?= $d['nominal'] ?>" placeholder="Nominal">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tenor">Tenor / x</label>
                                                            <input type="number" class="form-control" id="tenor" name="tenor" value="<?= $d['tenor'] ?>" placeholder="Tenor">
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
                                    <!--delete Data-->
                                    <div class="modal fade" id="deleteData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus Data Cicilan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus data <b><?= $d['nama'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_data_cicilan?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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

<!-- Modal -->
<div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Tambah Data Cicilan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/data_cicilan') ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Nama Cicilan</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Cicilan" value="<?= set_value('nama') ?>">
                    </div>

                    <div class="form-group">
                        <label for="karyawan">Karyawan</label>
                        <select style="width:100%!important;" class="form-control js-example-basic-single" name="karyawan">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="number" class="form-control" id="nominal" name="nominal" value="<?= set_value('nominal') ?>" placeholder="Nominal">
                    </div>

                    <div class="form-group">
                        <label for="tenor">Tenor / x</label>
                        <input type="number" class="form-control" id="tenor" name="tenor" value="<?= set_value('tenor') ?>" placeholder="Tenor">
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

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            ajax: {
                url: "<?= base_url('get/getKaryawan') ?>",
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
            placeholder: 'Ketik Nama Karyawan',
            minimumInputLength: 3,
        });
    });
</script>