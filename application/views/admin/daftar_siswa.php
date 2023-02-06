<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4 class="mb-5 header-title"><i class="fas fa-list"></i> <?= $title ?>
                        <div class="float-right mr-1">
                            <a href="" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#exportData"><i class="fa fa-file-export"></i> Export</a>
                        </div>
                        <div class="float-right pr-1">
                            <a href="" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#importData"><i class="fa fa-file-import"></i> Import</a>
                        </div>
                    </h4>
                    <?= $this->session->flashdata('message') ?>
                    <form style="margin: 20px 0;" action="<?= base_url() . 'admin/daftar_siswa'; ?>" method="post">
                        <div class="form-row">
                            <div class="form-group col-lg-3">
                                <label>Tambah siswa</label>
                                <a href="<?= base_url('admin/tambah_siswa'); ?>" class="btn btn-block btn-info"><i class="fa fa-plus-circle"></i> Pendaftaran siswa</a>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Sortir Provinsi</label>
                                <select class="form-control" id="prov" name="prov">
                                    <option value="">Pilih Provinsi</option>
                                    <?php foreach ($prov as $row) : ?>
                                        <option value="<?= $row['id_prov']; ?>"><?= $row['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Sortir kota</label>
                                <select class="form-control" id="kab" name="kab">
                                    <option value="">Pilih provinsi dahulu</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Submit</label>
                                <input class="btn btn-block btn-primary" type="submit" name="filter" value="Filter">
                            </div>
                    </form>
                </div>

                <div class="row pb-3">
                    <div class="col-md-5 offset-md-7">
                        <div class="card-header-form">
                            <button type="button" class="btn btn-dark mr-2 ml-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Point kurang dari 5">
                            </button> Terancam
                            <button type="button" class="btn btn-danger mr-2 ml-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Point dari 5 sampai 49">
                            </button> Bahaya
                            <button type="button" class="btn btn-warning mr-2 ml-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Point dari 50 sampai 75">
                            </button> Peringatan
                            <button type="button" class="btn btn-success mr-2 ml-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Point dari 76 sampai 100">
                            </button> Aman
                        </div>
                    </div>
                </div>

                <div style="width:100%; overflow-x:scroll">
                    <table class="table table-hover display" id="mytable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">NIS</th>
                                <th scope="col">Kota</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Tanggal Lahir</th>
                                <th scope="col">Point</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($siswa as $d) : ?>
                                <?php
                                $ttl = $d['ttl'];
                                $lahir    = new DateTime($ttl);
                                $today        = new DateTime();
                                $diff = $today->diff($lahir);
                                if ($d['point'] == 100) {
                                    $bg = 'success';
                                }elseif ($d['point'] >= 70 || $d['point'] >= 99){
                                    $bg = 'primary';
                                }elseif ($d['point'] >= 50){
                                    $bg = 'warning';
                                }elseif ($d['point'] >= 30 || $d['point'] >= 1){
                                    $bg = 'danger';
                                }elseif ($d['point'] == 0){
                                    $bg = 'secondary';
                                }
                                ?>
                                <tr>
                                    <th scope="row"><?= $i ?></th>
                                    <td width="200"><?= $d['nama'] ?></td>
                                    <td width="100"><?= $d['nis'] ?></td>
                                    <td width="120"><?= $d['kab'] ?></td>
                                    <td width="300"><?= $d['alamat'] ?></td>
                                    <td><?= mediumdate_indo(date($ttl)) ?>
                                        <span class="badge badge-info">
                                            <font size="1.5px"> <?php echo 'Umur ' . $diff->y . ' Tahun';  ?></font>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#resetPoint<?= $d['id'] ?>" style="border-radius:25px" class="btn btn-sm btn-rounded btn-<?= $bg ?>" disabled><?= $d['point'] ?></a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/update_siswa?id=') ?><?= $d['id'] ?>" class="badge badge-success">Edit</a>
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

        <!-- Data Hapus  -->

        <?php foreach ($siswa as $d) : ?>
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
                            <p>Anda yakin ingin menghapus data <?= $d['nama'] ?></p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <a href="<?= base_url('hapus/hapus_siswa?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                        </div>

                    </div>
                </div>
            </div>
            <!--reset Point-->
            <div class="modal fade" id="resetPoint<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewDataLabel">Reset point siswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Anda yakin ingin reset point data <b><?= $d['nama'] ?></b> ke point <b style="color: green;">100</b></p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <a href="<?= base_url('update/reset_point?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-redo"></i> Reset Point</a>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>

    <div class="modal fade" id="importData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Import Data siswa</h5>
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
                        <a href="<?= base_url('assets/contoh/Contoh_data_siswa.xlsx') ?>" class="badge badge-pill badge-success" download>Download</a></label>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="submit" value="upload" class="btn btn-success"><i class="fa fa-file-import"></i> Import</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exportData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Export siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin mengexport data semua siswa</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <a href="<?= base_url('admin/export_data') ?>" class="btn btn-success"><i class="fa fa-file-export"></i> Export</a>
                </div>

            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#prov').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_kota/daftar'); ?>',
                data: {
                    prov: this.value
                },
                cache: false,
                success: function(response) {
                    $('#kab').html(response);
                }
            });
        });

        $('#pendidikan').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_kelas'); ?>',
                data: {
                    pendidikan: this.value
                },
                cache: false,
                success: function(response) {
                    $('#kelas').html(response);
                }
            });
        });
    });
</script>