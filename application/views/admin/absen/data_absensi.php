<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?>
                        <div class="float-right pr-1">
                            <a href="" class="btn btn-block btn-sm btn-info" data-toggle="modal" data-target="#Print"><i class="fa fa-print"></i> Laporan Absen</a>
                        </div>
                    </h1>
                    <?= $this->session->flashdata('message') ?>
                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Sekolah</th>
                                    <th scope="col">Divisi</th>
                                    <th scope="col">Hadir</th>
                                    <!-- <th scope="col">Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($karyawan as $d) : ?>
                                    <?php $sekolah = $this->db->get_where('data_pendidikan', ['id' => $d['id_pend']])->row_array(); ?>
                                    <?php $divisi = $this->db->get_where('data_divisi', ['id' => $d['id_divisi']])->row_array(); ?>
                                    <?php $sum_hadir = $this->db->get_where('absen_pegawai', ['status' => '1', 'id_peng' => $d['id']])->num_rows(); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $d['nama']; ?></td>
                                        <td><?= $sekolah['nama'] ?></td>
                                        <td><?= $divisi['nama'] ?></td>
                                        <td><?= $sum_hadir ?></td>

                                        <!-- <td><a href="" class="badge badge-info" data-toggle="modal" data-target="#printData<?= $d['id'] ?>"><i class="fa fa-print"></i> Print</a> -->

                                        </td>
                                    </tr>

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
<div class="modal fade" id="Print" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Laporan Absensi Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form target="_blank" action="<?= base_url('laporan/laporan_data_absensi_pegawai') ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Sekolah</label>
                        <select class="form-control" id="pendidikan" name="pendidikan">
                            <option value="">- Semua -</option>
                            <?php foreach ($pendidikan as $row) : ?>
                                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('pendidikan', '<small class="text-danger pl-3">', ' </small>') ?>
                    </div>

                    <div class="form-group">
                        <label>Divisi</label>
                        <select class="form-control" id="divisi" name="divisi">
                            <option value="">- Semua -</option>
                            <?php foreach ($data_divisi as $r) : ?>
                                <option value="<?= $r['id'] ?>"><?= $r['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('divisi', '<small class="text-danger pl-3">', ' </small>') ?>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                </div>

            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="importData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Import Data Absensi Pegawai</h5>
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
                    <a href="<?= base_url('assets/contoh/data_absen.xlsx') ?>" class="badge badge-pill badge-success" download>Download</a></label>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" name="submit" value="upload" class="btn btn-success"><i class="fa fa-file-import"></i> Import</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>