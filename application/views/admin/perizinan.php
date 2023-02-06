<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">
            <?= form_error(
                'siswa',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>'
            ) ?>
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
                'tgl_awal',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>'
            ) ?>
            <?= form_error(
                'tgl_akhir',
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
                            <a href="" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#printData"><i class="fa fa-print"></i> Print</a>
                        </div>
                        <div class="float-right pr-1">
                            <a href="" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#addNewData"><i class="fa fa-plus-circle"></i> Tambah</a>
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
                                    <?php $san = $this->db->get_where('siswa', ['id' => $d['id_siswa']])->row_array(); ?>
                                    <?php $kam = $this->db->get_where('data_kelas', ['id' => $d['id_kelas']])->row_array(); ?>
                                    <?php $izin = $this->db->get_where('data_perizinan', ['id' => $d['id_izin']])->row_array(); ?>
                                    <?php $penddk = $this->db->get_where('data_pendidikan', ['id' => $d['id_pend']])->row_array(); ?>
                                    <?php $majors = $this->db->get_where('data_jurusan', ['id_pend' => $penddk['id']])->row_array(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $san['nama'] ?></td>
                                        <td><?= $kam['nama'] ?> 
                                        <?php if($penddk['majors'] == 1) : ?>
                                        - <?= $majors['nama'] ?>
                                        <?php endif ?>
                                        </td>
                                        <td><?= $izin['nama'] ?></td>
                                        <td><?= $d['keterangan'] ?></td>
                                        <td><?= mediumdate_indo(date($d['tgl'])); ?></td>
                                        <td><?= mediumdate_indo(date($d['expired'])); ?></td>
                                        <td>
                                            <?php if ($d['status']  == 'Success') : ?>
                                                <span class="badge badge-success badge-pill disabled" aria-disabled="true">Sukses</span>
                                            <?php elseif ($d['status']  == 'Pending') : ?>
                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#pendingData<?= $d['id'] ?>">Pending</a>
                                            <?php elseif ($d['status']  == 'Proses') : ?>
                                                <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#prosesData<?= $d['id'] ?>">Proses</a>
                                            <?php elseif ($d['status']  == 'Expired') : ?>
                                                <span class="badge badge-danger badge-pill disabled" aria-disabled="true">Expired</span>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if (($d['status']  == 'Pending') || ($d['status']  == 'Proses')) : ?>
                                                <a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>">Edit</a>
                                            <?php endif ?>
                                            <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>">Hapus</a>

                                        </td>
                                    </tr>

                                    <!--update Data-->
                                    <div class="modal fade" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Update Data Perizinan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_perizinan/admin') ?>" method="post">
                                                    <div class="modal-body row">

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="siswa">Nama siswa</label>
                                                                <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                                <input type="hidden" name="id_izin_lama" value="<?= $d['id_izin'] ?>">
                                                                <input type="hidden" name="siswa" value="<?= $san['nama'] ?>">
                                                                <input type="text" class="form-control" value="<?= $san['nama'] ?>" readonly>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="keterangan">Keterangan</label>
                                                                <textarea class="form-control" type="text" id="keterangan" name="keterangan"><?= $d['keterangan'] ?></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="jenis">Jenis perizinan</label>
                                                                <select class="form-control" id="jenis<?= $d['id'] ?>" name="jenis">
                                                                    <option value="">- Pilih jenis perizinan -</option>
                                                                    <?php foreach ($data_izin as $a) : ?>
                                                                        <option <?php if ($a['id'] == $d['id_izin']) {
                                                                                    echo "selected='selected'";
                                                                                } ?> value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="tanggal">Tanggal</label>
                                                                <input class="form-control" type="date" id="tanggal" name="tanggal" value="<?= $d['tgl'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="expired">Expired</label>
                                                                <input class="form-control" type="date" id="expired" name="expired" value="<?= $d['expired'] ?>">
                                                            </div>
                                                            <div id="ket_point<?= $d['id'] ?>" class="form-group"></div>
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
                                                    <p>Anda yakin ingin menghapus data <b><?= $san['nama'] ?></b> dengan izin <b><?= $izin['nama'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_perizinan/admin?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!--Pending Data-->
                                    <div class="modal fade" id="pendingData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Proses Perizinan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4>Perizinan <?= $izin['nama'] ?>
                                                        <span class="btn btn-warning text-gray-900 btn-pill btn-sm float-right disabled" aria-disabled="true">Pending</span>
                                                    </h4>
                                                    <p>
                                                        <b>Nama siswa : <?= $san['nama'] ?></b> <br>
                                                    </p>
                                                    Keterangan :
                                                    <div class="alert alert-dark" role="alert">
                                                        <?= $d['keterangan'] ?>
                                                    </div>
                                                    <div class="alert alert-info" role="alert">
                                                        <p class="pt-3">
                                                            <b>Tanggal Mulai : </b><br />
                                                            <?= mediumdate_indo(date($d['tgl'])); ?>
                                                        </p>
                                                        <p">
                                                            <b>Expired : </b><br />
                                                            <?= mediumdate_indo(date($d['expired'])); ?>
                                                            </p>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <form action="<?= base_url('update/update_pending_izin/admin') ?>" method="post">
                                                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Beri Izin</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!--Proses Data-->
                                    <div class="modal fade" id="prosesData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Selesai Perizinan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4>Perizinan <?= $izin['nama'] ?>
                                                        <span class="btn btn-primary btn-pill btn-sm float-right disabled" aria-disabled="true">Proses</span>
                                                    </h4>
                                                    <p>
                                                        <b>Nama siswa : <?= $san['nama'] ?></b> <br>
                                                    </p>
                                                    Keterangan :
                                                    <div class="alert alert-dark" role="alert">
                                                        <?= $d['keterangan'] ?>
                                                    </div>
                                                    <div class="alert alert-info" role="alert">
                                                        <p class="pt-3">
                                                            <b>Tanggal Mulai : </b><br />
                                                            <?= mediumdate_indo(date($d['tgl'])); ?>
                                                        </p>
                                                        <p">
                                                            <b>Expired : </b><br />
                                                            <?= mediumdate_indo(date($d['expired'])); ?>
                                                            </p>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <form action="<?= base_url('update/update_proses_izin/admin') ?>" method="post">
                                                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                        <button type="submit" class="btn btn-success">Selesai</button>
                                                    </form>
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
            <form target="_blank" action="<?= base_url('laporan/laporan_perizinan') ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Pendidikan</label>
                        <select class="form-control" id="pendidikan" name="pendidikan">
                            <option value="">- Pilih Pendidikan -</option>
                            <?php foreach ($pendidikan as $row) : ?>
                                <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('pendidikan', '<small class="text-danger pl-3">', ' </small>') ?>
                    </div>
                    <div id="jurus" class="form-group">
                        <label>Kejuruan</label>
                        <select class="form-control" id="jurusan" name="jurusan">
                            <option>- Pilih Jurusan -</option>
                        </select>
                        <?= form_error('jurusan', '<small class="text-danger pl-3">', ' </small>') ?>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <select class="form-control" id="kelas" name="kelas">
                            <option value="">Pilih Pendidikan dahulu</option>
                        </select>
                        <?= form_error('kelas', '<small class="text-danger pl-3">', ' </small>') ?>
                    </div>

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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> Print</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Tambah Perizinan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/perizinan') ?>" method="post">
                <div class="modal-body row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="siswa">Nama siswa</label>
                            <select style="width:100%!important;" class="form-control js-example-basic-single" name="siswa">
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" type="text" id="keterangan" name="keterangan"><?= set_value('keterangan') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="jenis">Jenis perizinan</label>
                            <select class="form-control" id="jenis" name="jenis">
                                <option value="">- Pilih jenis perizinan -</option>
                                <?php foreach ($data_izin as $a) : ?>
                                    <option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input class="form-control" type="date" id="tanggal" name="tanggal" value="<?= set_value('tanggal') ?>">
                        </div>
                        <div class="form-group">
                            <label for="expired">Expired</label>
                            <input class="form-control" type="date" id="expired" name="expired" value="<?= set_value('expired') ?>">
                        </div>
                        <div id="ket_point" class="form-group"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
        </div>
        </form>
    </div>
</div>

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
        $("#desk").hide();
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

        var role_id = <?= $user['role_id'] ?>;
        var id_peng = <?= $user['id'] ?>;
        $("#jurus").hide();
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
                    $('#kelas').html(response);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_majors'); ?>',
                data: {
                    pendidikan: this.value
                },
                cache: false,
                success: function(response) {
                    $('#jurusan').html(response);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_id_majors'); ?>',
                data: {
                    pendidikan: this.value
                },
                cache: false,
                success: function(response) {
                    if(response == 1){
                        $("#jurus").show();
                    }else if(response == 0){
                        $("#jurus").hide();
                    }
                }
            });
        });
        
    });
</script>