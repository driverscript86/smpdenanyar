<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?>
                        <?php if ($user['role_id'] == '1') : ?>
                        <div class="float-right">
                            <a href="" class="btn btn-block btn-sm btn-info" data-toggle="modal" data-target="#addNewData"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                        </div>
                        <?php endif ?>
                    </h1>
                    <?= $this->session->flashdata('message') ?>
                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Kelas</th>
                                    <th scope="col">Wali Kelas</th>
                                    <th scope="col">Pendidikan</th>
                                    <th scope="col">Jumlah Kursi</th>
                                    <th scope="col">Jumlah siswa</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($kelas as $d) : ?>
                                    <?php $peng = $this->db->get_where('karyawan', ['id' => $d['id_peng']])->row_array(); ?>
                                    <?php $majors = $this->db->get_where('data_jurusan', ['id' => $d['id_jurus']])->row_array(); ?>
                                    <?php $rib = $this->db->get_where('data_pendidikan', ['id' => $d['id_pend']])->row_array(); ?>
                                    <?php $sum_kursi = $this->db->get_where('data_kursi', ['id_kelas' => $d['id']])->num_rows(); ?>
                                    <?php $sum_siswa = $this->db->get_where('siswa', ['id_kelas' => $d['id']])->num_rows(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $d['nama'] ?>
                                        <?php if(!empty($d['id_jurus'])) : ?>
                                         - <?= $majors['nama'] ?>
                                        <?php endif ?>
                                        </td>
                                        <td><?= $peng['nama'] ?></td>
                                        <td><?= $rib['nama'] ?></td>
                                        <td><?= $sum_kursi ?></td>
                                        <td><?= $sum_siswa ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/view_kelas/') ?><?= $d['id'] ?>" class="badge badge-primary">View</a>
                                            <?php if ($user['role_id'] == '1') : ?>
                                            <a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>">Edit</a>
                                            <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>">Hapus</a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <!--update Data-->
                                    <div class="modal fade" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Ubah Nama Kelas</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_kelas') ?>" method="post">
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="">Nama Kelas</label>
                                                            <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">
                                                            <input type="text" class="form-control" id="kelas" name="kelas" value="<?= $d['nama'] ?>" placeholder="Pelanggaran">
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="hidden" name="karyawan1" value="<?= $d['id_peng'] ?>">
                                                            <label for="karyawan">Wali Kelas</label>
                                                            <select style="width:100%!important;" class="form-control js-example-basic-single" name="karyawan">
                                                            </select>
                                                            <small>Biarkan kosong jika tidak diubah.</small>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="pendidikan">Pendidikan</label>
                                                            <select class="form-control" id="pendidikan<?= $d['id'] ?>" name="pendidikan">
                                                                <option>- Pilih Pendidikan -</option>
                                                                <?php foreach ($pendidikan as $a) : ?>

                                                                    <option <?php if ($d['id_pend'] == $a['id']) {
                                                                                echo "selected='selected'";
                                                                            } ?> value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>

                                                                <?php endforeach ?>
                                                            </select>
                                                            <?= form_error('pendidikan', '<small class="text-danger pl-3">', '</small>'); ?>
                                                        </div>
                                                        <div id="jurus<?= $d['id'] ?>" class="form-group">
                                                            <label>Kejuruan</label>
                                                            <select class="form-control" id="jurusan<?= $d['id'] ?>" name="jurusan">
                                                                <option>- Pilih Jurusan -</option>
                                                            </select>
                                                            <?= form_error('jurusan', '<small class="text-danger pl-3">', ' </small>') ?>
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
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus Kelas</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus data <b><?= $d['nama'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_kelas?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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
        <!-- /.container-fluid -->
    </div>
</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Tambah Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/kelas') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Nama Kelas">
                    </div>
                    <div class="form-group">
                        <label for="karyawan">Wali Kelas</label>
                        <select style="width:100%!important;" class="form-control js-example-basic-single" name="karyawan">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pendidikan">Pendidikan</label>
                        <select class="form-control" id="pendidikan" name="pendidikan">
                            <option value="">- Pilih Pendidikan -</option>
                            <?php foreach ($pendidikan as $a) : ?>
                                <option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <?= form_error('pendidikan', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div id="jurus" class="form-group">
                        <label>Kejuruan</label>
                        <select class="form-control" id="jurusan" name="jurusan">
                            <option>- Pilih Jurusan -</option>
                        </select>
                        <?= form_error('jurusan', '<small class="text-danger pl-3">', ' </small>') ?>
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
    <?php foreach ($kelas as $d) : ?>
    $("#jurus<?= $d['id'] ?>").hide();
        $('#pendidikan<?= $d['id'] ?>').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_majors'); ?>',
                data: {
                    pendidikan: this.value
                },
                cache: false,
                success: function(response) {
                    $('#jurusan<?= $d['id'] ?>').html(response);
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
                        $("#jurus<?= $d['id'] ?>").show();
                    }else if(response == 0){
                        $("#jurus<?= $d['id'] ?>").hide();
                    }
                }
            });
        });
        <?php endforeach ?>
    });
</script>
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
            placeholder: 'Ketik Nama Wali Kelas',
            minimumInputLength: 3,
        });

        $("#jurus").hide();
        $('#pendidikan').change(function() {
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