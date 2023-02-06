<!-- Begin Page Content -->
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
                                    <th scope="col">#</th>
                                    <th scope="col">Nama siswa</th>
                                    <th scope="col">Kursi</th>
                                    <th scope="col">Tipe</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($kursi as $d) : ?>
                                    <?php $kam = $this->db->get_where('data_kelas', ['id' => $d['id_kelas']])->row_array(); ?>
                                    <?php $san = $this->db->get_where('siswa', ['id' => $d['id_siswa']])->row_array(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?php if (!$d['id_siswa']) : ?>
                                                <span class="badge badge-danger">Masih kosong</span>
                                                <a href="#" class="badge badge-success" data-toggle="modal" data-target="#tambahsiswa<?= $d['id'] ?>">Tambah</a>
                                            <?php else : ?>
                                                <span class="p-2 badge badge-secondary"><?= $san['nama'] ?></span>
                                                <a href="#" class="badge badge-success" data-toggle="modal" data-target="#ubahsiswa<?= $d['id'] ?>">Ubah</a>
                                                <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#kosongData<?= $d['id'] ?>">Kosongkan</a>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $d['nama'] ?></td>
                                        <td><?= $d['tipe'] ?></td>
                                        <td><?= $kam['nama'] ?></td>
                                        <td>
                                            <a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>">Edit</a>
                                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>">Hapus</a>

                                        </td>
                                    </tr>

                                    <!--update Data-->
                                    <div class="modal fade" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Update Data Kursi</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_data_kursi') ?>" method="post">
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="">Nama Kursi</label>
                                                            <input type="text" class="form-control" id="kursi" name="kursi" value="<?= $d['nama'] ?>" placeholder="Nama Kursi">
                                                        </div>
                                                        <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">

                                                        <div class="form-group">
                                                            <label for="tipe">Tipe</label>
                                                            <select class="form-control" id="tipe" name="tipe">

                                                                <?php if ($d['tipe'] == 'Kursi A') : ?>
                                                                    <option value="Kursi A">
                                                                        Kursi A (Terpilih)
                                                                    </option>
                                                                    <option value="Kursi B">Kursi B</option>
                                                                <?php elseif ($d['tipe'] == 'Kursi B') : ?>
                                                                    <option value="Kursi B">
                                                                        Kursi B (Terpilih)
                                                                    </option>
                                                                    <option value="Kursi A">Kursi A</option>
                                                                <?php endif; ?>

                                                                <option value="">Kursi A</option>
                                                                <option value="Kursi B">Kursi B</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <?php $id_kamm = $this->db->get_where('data_kelas', ['id' => $d['id_kelas']])->row_array(); ?>
                                                            <label for="pendidikan">Nama Pendidikan</label>
                                                            <select class="form-control" id="pendidikan<?= $d['id'] ?>" name="pendidikan">
                                                                <option value="">- Pilih Pendidikan -</option>
                                                                <?php foreach ($pendidikan as $row) : ?>

                                                                    <option <?php if ($id_kamm['id_pend'] == $row['id']) {
                                                                                echo "selected='selected'";
                                                                            } ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>

                                                                <?php endforeach; ?>
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
                                                        <div class="form-group">
                                                            <label for="kelas">Nama Kelas</label>
                                                            <select class="form-control" id="kelas<?= $d['id'] ?>" name="kelas">
                                                                <option value="">- Pilih pendidikan dahulu -</option>
                                                                <?php foreach ($kelas as $kmr) : ?>

                                                                    <option <?php if ($d['id_kelas'] == $kmr['id']) {
                                                                                echo "selected='selected'";
                                                                            } ?> value="<?= $kmr['id'] ?>"><?= $kmr['nama'] ?></option>

                                                                <?php endforeach; ?>
                                                            </select>
                                                            <?= form_error('kelas', '<small class="text-danger pl-3">', '</small>'); ?>
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


                                    <div class="modal fade" id="tambahsiswa<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Tambah Isi Kursi</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('tambah/tambah_isi_kursi') ?>" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">
                                                        <div class="form-group">
                                                            <label for="siswa">siswa</label>
                                                            <select style="width:100%!important;" class="form-control js-example-basic-single" name="siswa">
                                                            </select>
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


                                    <div class="modal fade" id="ubahsiswa<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Ubah Isi Kursi</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_isi_kursi/admin') ?>" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">
                                                        <div class="form-group">
                                                            <label for="siswa">Nama siswa</label>
                                                            <input type="text" class="form-control" value="<?= $san['nama'] ?>" disabled>
                                                        </div>
                                                        <div class="form-group text-center">
                                                            Ubah ke <i class="fa fa-exchange"></i>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="siswa">siswa</label>
                                                            <select style="width:100%!important;" class="form-control js-example-basic-single" name="siswa">
                                                            </select>
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
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus Kursi</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus data Kursi <b><?= $d['nama'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_data_kursi?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!--kosong Data-->
                                    <div class="modal fade" id="kosongData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Kosongkan Kursi</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin mengosongkan data Kursi <b><?= $d['nama'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <form action="<?= base_url('update/update_isi_kursi_kosong/admin') ?>" method="post">
                                                        <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Kosongkan</button>
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
    <!-- /.container-fluid -->

    <!-- Modal -->
    <div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Tambah Data Kursi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/data_kursi') ?>" method="post">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="">Nama Kursi</label>
                            <input type="text" class="form-control" id="kursi" name="kursi" placeholder="Nama Kursi">
                        </div>
                        <div class="form-group">
                            <label for="tipe">Tipe</label>
                            <select class="form-control" id="tipe" name="tipe">
                                <option>- Pilih Tipe -</option>
                                <option value="Kursi A">Kursi A</option>
                                <option value="Kursi B">Kursi B</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="pendidikan">Nama Pendidikan</label>
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
                        <div class="form-group">
                            <label for="kelas">Nama Kelas</label>
                            <select class="form-control" id="kelas" name="kelas">
                                <option value="">- Pilih pendidikan dahulu -</option>

                            </select>
                            <?= form_error('kelas', '<small class="text-danger pl-3">', '</small>'); ?>
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

</div>
<!-- End of Main Content -->
<?php foreach ($kursi as $d) : ?>
    <script type="text/javascript">
    $(document).ready(function() {
        var role_id = <?= $user['role_id'] ?>;
        var id_peng = <?= $user['id'] ?>;
        $("#jurus<?= $d['id'] ?>").hide();
        $("#jurus").hide();
        $('#pendidikan<?= $d['id'] ?>').change(function() {
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
                    $('#kelas<?= $d['id'] ?>').html(response);
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
    });
    </script>
<?php endforeach ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            ajax: {
                url: "<?= base_url('get/getsiswa') ?>",
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

<script type="text/javascript">
    $(document).ready(function() {
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