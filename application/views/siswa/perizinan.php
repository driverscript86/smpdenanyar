<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">
            <?= form_error(
                'keterangan',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>'
            ) ?>
            <?= form_error(
                'jenis',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>'
            ) ?>
            <?= form_error(
                'tanggal',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>'
            ) ?>
            <?= form_error(
                'expired',
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
                            <a href="" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#addNewData"><i class="fa fa-plus-circle"></i> Tambah</a>
                        </div>
                    </h4>
                    <?= $this->session->flashdata('message') ?>

                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Perizinan</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Expired</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($perizinan as $d) : ?>
                                    <?php $izin = $this->db->get_where('data_perizinan', ['id' => $d['id_izin']])->row_array(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $izin['nama'] ?></td>
                                        <td><?= $d['keterangan'] ?></td>
                                        <td><?= mediumdate_indo(date($d['tgl'])); ?></td>
                                        <td><?= mediumdate_indo(date($d['expired'])); ?></td>
                                        <td>
                                            <?php if ($d['status']  == 'Success') : ?>
                                                <span class="badge badge-success badge-pill disabled" aria-disabled="true">Sukses</span>
                                            <?php elseif ($d['status']  == 'Pending') : ?>
                                                <span class="badge badge-warning badge-pill disabled" aria-disabled="true">Pending</span>
                                            <?php elseif ($d['status']  == 'Proses') : ?>
                                                <span class="badge badge-primary badge-pill disabled" aria-disabled="true">Proses</span>
                                            <?php elseif ($d['status']  == 'Expired') : ?>
                                                <span class="badge badge-danger badge-pill disabled" aria-disabled="true">Expired</span>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if ($d['status']  == 'Proses') : ?>
                                                <spanc class="badge badge-info">Sudah diterima</spanc>
                                            <?php elseif ($d['status']  == 'Pending') : ?>
                                                <a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>">Edit</a>
                                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>">Hapus</a>
                                            <?php elseif ($d['status']  == 'Expired') : ?>
                                                <spanc class="badge badge-danger">Melanggar</spanc>
                                            <?php endif ?>
                                        </td>
                                    </tr>

                                    <!--update Data-->
                                    <div class="modal fade" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Update Data Perizinan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_perizinan/siswa') ?>" method="post">
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="siswa">Nama siswa</label>
                                                            <input type="hidden" class="form-control" name="id" value="<?= $d['id'] ?>" readonly>
                                                            <input type="text" class="form-control" value="<?= $user['nama'] ?>" readonly>
                                                            <input type="hidden" name="siswa" value="<?= $user['id'] ?>">
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="keterangan">Keterangan</label>
                                                            <textarea class="form-control" type="text" id="keterangan" name="keterangan"><?= $d['keterangan'] ?></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="jenis">Jenis perizinan</label>
                                                            <select class="form-control" id="jenis<?= $d['id'] ?>" name="jenis">
                                                                <option>- Pilih jenis perizinan -</option>
                                                                <?php foreach ($data_izin as $a) : ?>
                                                                    <option <?php if ($a['id'] == $d['id_izin']) {
                                                                                echo "selected='selected'";
                                                                            } ?> value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>

                                                        <div id="ket_point<?= $d['id'] ?>" class="form-group"></div>

                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal</label>
                                                            <input class="form-control" type="date" id="tanggal" name="tanggal" value="<?= $d['tgl'] ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expired">Expired</label>
                                                            <input class="form-control" type="date" id="expired" name="expired" value="<?= $d['expired'] ?>">
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
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
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus Perizinan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus data izin <b><?= $izin['nama'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_perizinan/siswa?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Tambah Perizinan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('siswa/perizinan') ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="siswa">Nama siswa</label>
                        <input type="text" class="form-control" value="<?= $user['nama'] ?>" readonly>
                        <input type="hidden" name="siswa" value="<?= $user['id'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" type="text" id="keterangan" name="keterangan"><?= set_value('keterangan') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="jenis">Jenis perizinan</label>
                        <select class="form-control" id="jenis" name="jenis">
                            <option value="<?= set_value('jenis') ?>">- Pilih jenis perizinan -</option>
                            <?php foreach ($data_izin as $a) : ?>
                                <option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div id="ket_point" class="form-group"></div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input class="form-control" type="date" id="tanggal" name="tanggal" value="<?= set_value('tanggal') ?>">
                    </div>
                    <div class="form-group">
                        <label for="expired">Expired</label>
                        <input class="form-control" type="date" id="expired" name="expired" value="<?= set_value('expired') ?>">
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

<!-- Script -->
<script type="text/javascript">
$(document).ready(function() {
    <?php foreach ($perizinan as $d) : ?>
        $("#ket_point<?= $d['id'] ?>").hide();

        $('#jenis<?= $d['id'] ?>').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_ket_point'); ?>',
                data: {
                    jenis: this.value
                },
                dataType: "json",
                cache: false,
                success: function(data) {
                    $('#ket_point<?= $d['id'] ?>').hide();
                    $('#ket_point<?= $d['id'] ?>').html(data['div']);
                    if(data['id'] !== ''){
                        $('#ket_point<?= $d['id'] ?>').show(600);
                    }else{
                        $('#ket_point<?= $d['id'] ?>').hide(600);
                    }
                }
            });

        });
    <?php endforeach ?>    
});
</script>
<!-- Script -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#ket_point").hide();
        $('#jenis').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_ket_point'); ?>',
                data: {
                    jenis: this.value
                },
                dataType: "json",
                cache: false,
                success: function(data) {
                    $('#ket_point').hide();
                    $('#ket_point').html(data['div']);
                    if(data['id'] !== ''){
                        $('#ket_point').show(600);
                    }else{
                        $('#ket_point').hide(600);
                    }
                }
            });

        });

    });
</script>