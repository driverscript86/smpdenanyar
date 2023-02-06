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
                                    <th scope="col">Level Divisi</th>
                                    <th scope="col">Gaji Pokok</th>
                                    <th scope="col">Tunjangan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($gaji as $d) : ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $d['nama'] ?></td>
                                        <td>Rp. <?= number_format($d['gaji'], 0, ',', '.') ?></td>
                                        <td>Rp. <?= number_format($d['tunjangan'], 0, ',', '.') ?></td>
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
                                                    <h5 class="modal-title" id="addNewDataLabel">Ubah Data Gaji</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_data_divisi') ?>" method="post">
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="">Nama Divisi</label>
                                                            <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">
                                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Level Divisi" value="<?= $d['nama'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="level" class="col-form-label">Level</label>
                                                            <select class="form-control" id="level" name="level">
                                                                <option value="">- Pilih Level -</option>
                                                                <option <?php if ($d['role_id'] == 2) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="2">Kesiswaan</option>
                                                                <option <?php if ($d['role_id'] == 3) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="3">Guru</option>
                                                                <option <?php if ($d['role_id'] == 4) {
                                                                            echo "selected='selected'";
                                                                        } ?> value="3">Karyawan Umum</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Gaji Pokok</label>
                                                            <input type="number" class="form-control" id="gaji" name="gaji" value="<?= $d['gaji'] ?>" placeholder="Gaji Pokok">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Tunjangan</label>
                                                            <input type="number" class="form-control" id="tunjangan" name="tunjangan" value="<?= $d['tunjangan'] ?>" placeholder="Tunjangan">
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
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus Data Gaji</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus data <b><?= $d['nama'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_data_divisi?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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
                <h5 class="modal-title" id="addNewDataLabel">Tambah Data Gaji</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/data_divisi') ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Nama Divisi</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Level Divisi" value="<?= set_value('nama') ?>">
                    </div>

                    <div class="form-group">
                        <label for="level" class="col-form-label">Level</label>
                        <select class="form-control" id="level" name="level">
                            <option value="">- Pilih Level -</option>
                            <option value="2">Kesiswaan</option>
                            <option value="3">Guru</option>
                            <option value="4">Karyawan Umum</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Gaji Pokok</label>
                        <input type="number" class="form-control" id="gaji" name="gaji" value="<?= set_value('gaji') ?>" placeholder="Gaji Pokok">
                    </div>

                    <div class="form-group">
                        <label for="">Tunjangan</label>
                        <input type="number" class="form-control" id="tunjangan" name="tunjangan" value="<?= set_value('tunjangan') ?>" placeholder="Tunjangan">
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