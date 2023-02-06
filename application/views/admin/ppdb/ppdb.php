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
                    </h4>
                    <?= $this->session->flashdata('message') ?>

                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover display" id="mytable" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Lengkap</th>
                                    <th scope="col">NIK</th>
                                    <th scope="col">NIS</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Tanggal Lahir</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Status</th>
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
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $d['nama'] ?></td>
                                        <td><?= $d['nik'] ?></td>
                                        <td><?= $d['nis'] ?></td>
                                        <td><?= $d['alamat'] ?></td>
                                        <td><?= mediumdate_indo(date($ttl)) ?>
                                            <span class="badge badge-info">
                                                <font size="1.5px"> <?php echo 'Umur ' . $diff->y . ' Tahun';  ?></font>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($d['inv']  !== '1') : ?>
                                                <span class="badge badge-danger badge-pill disabled" aria-disabled="true">Belum Bayar</span>
                                            <?php elseif ($d['inv']  == '1') : ?>
                                                <span class="badge badge-success badge-pill disabled" aria-disabled="true">Lunas</span>
                                                <a target="_blank" href="<?= base_url('laporan/cetak_invoice?id=' . $this->secure->encrypt($d['id'])) ?>" class="badge badge-info"><i class="fa fa-print"></i> Cetak Invoice</a>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if ($d['status']  == '0') : ?>
                                                <span class="badge badge-warning badge-pill disabled" aria-disabled="true">Pending</span>
                                            <?php elseif ($d['status']  == '1') : ?>
                                                <span class="badge badge-success badge-pill disabled" aria-disabled="true">Konfirmasi</span>
                                            <?php elseif ($d['status']  == '2') : ?>
                                                <span class="badge badge-danger badge-pill disabled" aria-disabled="true">Di Tolak</span>
                                            <?php endif ?>
                                        </td>
                                        
                                        <td>
                                            <a href="<?= base_url('admin/edit_ppdb?id=') ?><?= $d['id'] ?>" class="badge badge-success"><i class="fa fa-redo"></i> Kelola</a>
                                            <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>"><i class="fa fa-trash"></i> Hapus</a>

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
                                <h5 class="modal-title" id="addNewDataLabel">Hapus PPDB</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Anda yakin ingin menghapus data <?= $d['nama'] ?></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <a href="<?= base_url('hapus/hapus_ppdb/admin?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach ?>

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
                    <a href="<?= base_url('admin/export_data/ppdb') ?>" class="btn btn-success"><i class="fa fa-file-export"></i> Export</a>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->