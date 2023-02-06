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
                'tanggal',
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
                                    <th scope="col">Pendidikan</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Pelanggaran</th>
                                    <th scope="col">Point</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($pelanggaran as $d) : ?>
                                    <?php $san = $this->db->get_where('siswa', ['id' => $d['id_siswa']])->row_array(); ?>
                                    <?php $kam = $this->db->get_where('data_kelas', ['id' => $d['id_kelas']])->row_array(); ?>
                                    <?php $rib = $this->db->get_where('data_pendidikan', ['id' => $d['id_pend']])->row_array(); ?>
                                    <?php $pel = $this->db->get_where('data_pelanggaran', ['id' => $d['id_pelang']])->row_array(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $san['nama'] ?></td>
                                        <td><?= $rib['nama'] ?></td>
                                        <td><?= $kam['nama'] ?></td>
                                        <td><?= $pel['nama'] ?></td>
                                        <td><span style="border-radius:25px" class="btn btn-sm btn-rounded btn-danger" disabled><?= $pel['point'] ?></span></td>

                                        <td><?= mediumdate_indo(date($d['tgl'])); ?></td>

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
                                                    <h5 class="modal-title" id="addNewDataLabel">Update Data pelanggaran</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_pelanggaran') ?>" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                        <input type="hidden" name="id_pelang_lama" value="<?= $d['id_pelang'] ?>">
                                                        <div class="form-group">

                                                            <input type="text" class="form-control bg-secondary text-white" value="<?= $san['nama'] ?>" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal</label>
                                                            <input class="form-control" type="date" id="tanggal" name="tanggal" value="<?= $d['tgl'] ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jenis">Jenis pelanggaran</label>
                                                            <select class="form-control" id="jenis<?= $d['id'] ?>" name="jenis">
                                                                <?php foreach ($data_pelanggaran as $a) : ?>
                                                                    <option <?php if ($a['id'] == $d['id_pelang']) {
                                                                                echo "selected='selected'";
                                                                            } ?> value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group" id="desk<?= $d['id'] ?>">
                                                            <label for="pelanggaran">Point</label>
                                                            <div class="alert alert-secondary" role="alert" id="pelanggaran<?= $d['id'] ?>" readonly="">
                                                            </div>
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

                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#desk<?= $d['id'] ?>").hide();

                                            $('#jenis<?= $d['id'] ?>').change(function() {
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?= site_url('get/get_point'); ?>',
                                                    data: {
                                                        jenis: this.value
                                                    },
                                                    cache: false,
                                                    success: function(response) {
                                                        $('#pelanggaran<?= $d['id'] ?>').html(response);
                                                        $('#desk<?= $d['id'] ?>').show(600);
                                                    }
                                                });
                                            });
                                        });
                                    </script>


                                    <!--delete Data-->
                                    <div class="modal fade" id="deleteData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus pelanggaran</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus data <b><?= $san['nama'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_pelanggaran/admin/' . $d['id_pelang'] . '?id=' . $d['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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
            <form target="_blank" action="<?= base_url('laporan/laporan_pelanggaran') ?>" method="post">
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Tambah Pelanggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/pelanggaran') ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="siswa">Nama siswa</label>
                        <select style="width:100%!important;" class="form-control js-example-basic-single" name="siswa">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input class="form-control" type="date" id="tanggal" name="tanggal">
                    </div>

                    <div class="form-group">
                        <label for="jenis">Jenis pelanggaran</label>
                        <select class="form-control" id="jenis" name="jenis">
                            <option value="">- Pilih jenis pelanggaran -</option>

                            <?php foreach ($data_pelanggaran as $a) : ?>

                                <option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                            <?php endforeach ?>

                        </select>
                    </div>

                    <div class="form-group" id="desk">
                        <label for="pelanggaran">Point</label>
                        <div class="alert alert-secondary" role="alert" id="pelanggaran" name="pelanggaran" readonly="">
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
</div>



<!-- Script -->

<script type="text/javascript">
    $(document).ready(function() {
        var role_id = <?= $user['role_id'] ?>;
        var id_peng = <?= $user['id'] ?>;
        $("#jurus").hide();
        $("#desk").hide();

        $('.js-example-basic-single').select2({
            ajax: {
                url: "<?= base_url('get/getsiswa/' . $user['id']) ?>",
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

        $('#jenis').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_point'); ?>',
                data: {
                    jenis: this.value
                },
                cache: false,
                success: function(response) {
                    $('#pelanggaran').html(response);
                    $('#desk').show(600);
                }
            });
        });


        $("body").on("click", ".remove", function() {
            $(this).parents(".control-group").remove();
        });

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
                    if (response == 1) {
                        $("#jurus").show();
                    } else if (response == 0) {
                        $("#jurus").hide();
                    }
                }
            });
        });
    });
</script>