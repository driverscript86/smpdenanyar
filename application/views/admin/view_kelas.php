<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelas <b><?= $kelas['nama'] ?></b></h1>
        <div class="float-right mr-1">
            <a href="<?= base_url('admin/kelas') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa fa-arrow-left"></i> Data Kelas</a>
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">

        <?php $sum_san = $this->db->get_where('siswa', ['id_kelas' => $kelas['id']])->num_rows(); ?>
        <?php $sum_kam = $this->db->get_where('data_kursi', ['id_kelas' => $kelas['id']])->num_rows(); ?>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-bottom-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah siswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sum_san ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-bottom-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Kursi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sum_kam ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-server fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-bottom-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <a href="" data-toggle="modal" data-target="#tambahKursi">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tambah Kursi</div>
                            </a>
                            <a href="#" class="badge badge-success" data-toggle="modal" data-target="#tambahKursi">Tambah Kursi</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-server fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row">

        <!-- Area Chart -->
        <div class="col-md-12">
            <?= $this->session->flashdata('message') ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="text-center card-header">
                            <h6 class="mb-1 font-weight-bold">Kursi A</h6>
                        </div>

                        <div class="row p-2">
                            <?php foreach ($kursi_a as $a) : ?>
                                <?php $san = $this->db->get_where('siswa', ['id' => $a['id_siswa']])->row_array(); ?>
                                <?php if ($a['id_siswa']) : ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card bg-secondary text-white shadow">
                                            <div class="card-body text-center">
                                                <?= $a['nama'] ?>
                                                <div class="mb-1 text-white-50 small"><?= $san['nama'] ?></div>
                                                <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#kosongData<?= $a['id'] ?>">Kosongkan</a>
                                                <a href="#" class="badge badge-success" data-toggle="modal" data-target="#ubahsiswa<?= $a['id'] ?>">Ubah</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card bg-info text-white shadow">
                                            <div class="card-body text-center">
                                                <?= $a['nama'] ?><br />
                                                (Kosong) <br />

                                                <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $a['id'] ?>"><i class="fa fa-trash"></i> Hapus</a>
                                                <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#tambahsiswa<?= $a['id'] ?>"><i class="fa fa-plus-circle"></i> Tambah</a>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <div class="modal fade" id="tambahsiswa<?= $a['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNewDataLabel">Tambah Isi Kursi</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="<?= base_url('tambah/tambah_isi_kursi_kelas') ?>" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_kelas" id="id_kelas" value="<?= $a['id_kelas'] ?>">
                                                    <input type="hidden" name="id" id="id" value="<?= $a['id'] ?>">
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
                            <?php endforeach ?>
                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="text-center card-header">
                            <h6 class="mb-1 font-weight-bold">Kursi B</h6>
                        </div>

                        <div class="row p-2">
                            <?php foreach ($kursi_b as $a) : ?>
                                <?php $san = $this->db->get_where('siswa', ['id' => $a['id_siswa']])->row_array(); ?>
                                <?php if ($a['id_siswa']) : ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card bg-secondary text-white shadow">
                                            <div class="card-body text-center">
                                                <?= $a['nama'] ?>
                                                <div class="mb-1 text-white-50 small"><?= $san['nama'] ?></div>
                                                <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#kosongData<?= $a['id'] ?>">Kosongkan</a>
                                                <a href="#" class="badge badge-success" data-toggle="modal" data-target="#ubahsiswa<?= $a['id'] ?>">Ubah</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card bg-info text-white shadow">
                                            <div class="card-body text-center">
                                                <?= $a['nama'] ?><br />
                                                (Kosong) <br />

                                                <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $a['id'] ?>"><i class="fa fa-trash"></i> Hapus</a>
                                                <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#tambahsiswa<?= $a['id'] ?>"><i class="fa fa-plus-circle"></i> Tambah</a>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <div class="modal fade" id="tambahsiswa<?= $a['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNewDataLabel">Tambah Isi Kursi</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="<?= base_url('tambah/tambah_isi_kursi_kelas') ?>" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_kelas" id="id_kelas" value="<?= $a['id_kelas'] ?>">
                                                    <input type="hidden" name="id" id="id" value="<?= $a['id'] ?>">
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
                            <?php endforeach ?>
                        </div>

                    </div>
                </div>


            </div>

        </div>

    </div>


    <?php foreach ($kursi_a as $d) : ?>
        <?php $san = $this->db->get_where('siswa', ['id' => $d['id_siswa']])->row_array(); ?>
        <div class="modal fade" id="ubahsiswa<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewDataLabel">Ubah Isi Kursi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('update/update_isi_kursi') ?>" method="post">
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
                        <p>Anda yakin ingin mengosongkan data Kursi <b><?= $d['nama'] ?></b> dengan siswa <b><?= $san['nama'] ?></b></p>
                    </div>

                    <div class="modal-footer">
                        <form action="<?= base_url('update/update_isi_kursi_kosong/') ?>" method="post">
                            <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Kosongkan</button>
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
                        <a href="<?= base_url('hapus/hapus_data_kursi/admin?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                    </div>

                </div>
            </div>
        </div>

    <?php endforeach ?>

    <?php foreach ($kursi_b as $d) : ?>
        <?php $san = $this->db->get_where('siswa', ['id' => $d['id_siswa']])->row_array(); ?>
        <div class="modal fade" id="ubahsiswa<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewDataLabel">Ubah Isi Kursi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('update/update_isi_kursi') ?>" method="post">
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
                        <p>Anda yakin ingin mengosongkan data Kursi <b><?= $d['nama'] ?></b> dengan siswa <b><?= $san['nama'] ?></b></p>
                    </div>

                    <div class="modal-footer">
                        <form action="<?= base_url('update/update_isi_kursi_kosong/') ?>" method="post">
                            <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Kosongkan</button>
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
                        <a href="<?= base_url('hapus/hapus_data_kursi/admin?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                    </div>

                </div>
            </div>
        </div>

    <?php endforeach ?>


    <!-- Modal -->
    <div class="modal fade" id="tambahKursi" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Tambah Data Kursi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/tambah_kursi?id=') ?><?= $this->uri->segment(3) ?>" method="post">
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