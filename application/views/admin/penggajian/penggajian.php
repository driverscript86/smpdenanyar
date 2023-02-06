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
                                    <th scope="col">Nama Karyawan</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">Tanggal Awal</th>
                                    <th scope="col">Tanggal Akhir</th>
                                    <th scope="col">Jumlah Hadir</th>
                                    <th scope="col">Total Jam</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($penggajian as $d) : ?>
                                    <?php $guru = $this->db->get_where('karyawan', ['id' => $d['id_peng']])->row_array(); ?>
                                    <?php $divisi = $this->db->get_where('data_divisi', ['id' => $d['id_divisi']])->row_array(); ?>
                                    <?php
                                    //sum hdir
                                    $this->db->where('tgl >=', $d['tgl_awal']);
                                    $this->db->where('tgl <=', $d['tgl_akhir']);
                                    $this->db->where('id_peng', $d['id_peng']);
                                    $this->db->where('status', '1');
                                    $sum_hadir = $this->db->get('absen_pegawai')->num_rows();
                                    //sum Total Jam
                                    $this->db->select_sum('sum_jam');
                                    $this->db->where('tgl >=', $d['tgl_awal']);
                                    $this->db->where('tgl <=', $d['tgl_akhir']);
                                    $sum_jam = $this->db->get_where('absen_pegawai', ['id_peng' => $d['id_peng']])->row_array();
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $guru['nama'] ?></td>
                                        <td><?= $divisi['nama'] ?></td>
                                        <td><?= mediumdate_indo(date($d['tgl_awal'])); ?></td>
                                        <td><?php if ($d['tgl_akhir'] !== '0000-00-00') : ?>
                                                <?= mediumdate_indo(date($d['tgl_akhir'])); ?>
                                            <?php else : ?>
                                                -
                                            <?php endif ?>
                                        </td>
                                        <td><?= number_format($sum_hadir, 0, ',', '.') ?></td>
                                        <td><?= number_format($sum_jam['sum_jam'], 0, ',', '.') ?></td>
                                        <td><?php if ($d['status'] == 0) : ?>
                                                <span class="badge badge-primary">Belum digaji</span>
                                            <?php elseif ($d['status'] == 1) : ?>
                                                <span class="badge badge-success">Sudah digaji</span>
                                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#batalData<?= $d['id'] ?>">Batal</a>
                                            <?php endif ?>
                                        </td>
                                        <td><?php if ($d['status'] == 0) : ?>
                                                <a href="#" class="badge badge-success" data-toggle="modal" data-target="#prosesData<?= $d['id'] ?>">Proses</a>
                                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>">Hapus</a>
                                            <?php elseif ($d['status'] == 1) : ?>
                                                <a href="" class="badge badge-primary" data-toggle="modal" data-target="#printData<?= $d['id'] ?>"><i class="fa fa-print"></i> Print</a>
                                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>">Hapus</a>
                                            <?php endif ?>
                                        </td>
                                    </tr>


                                    <!--batal Data-->
                                    <div class="modal fade" id="batalData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Batal Penggajian</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin membatalkan pengajian <b><?= $guru['nama'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('update/batal_penggajian?id=' . $d['id']) ?>" class="btn btn-danger">Batalkan</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!--delete Data-->
                                    <div class="modal fade" id="deleteData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus Data Penggajian</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus data <b><?= $guru['nama'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_penggajian?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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

    <!--modal-->
    <?php foreach ($penggajian as $d) : ?>
        <?php
        //sum hdir
        $this->db->where('tgl >=', $d['tgl_awal']);
        $this->db->where('tgl <=', $d['tgl_akhir']);
        $this->db->where('id_peng', $d['id_peng']);
        $this->db->where('status', 1);
        $sum_hadir = $this->db->get('absen_pegawai')->num_rows();
        //sum Total Jam
        $this->db->select_sum('sum_jam');
        $this->db->where('tgl >=', $d['tgl_awal']);
        $this->db->where('tgl <=', $d['tgl_akhir']);
        $sum_jam = $this->db->get_where('absen_pegawai', ['id_peng' => $d['id_peng']])->row_array();
        ?>
        <?php $guru = $this->db->get_where('karyawan', ['id' => $d['id_peng']])->row_array(); ?>
        <?php $divisi = $this->db->get_where('data_divisi', ['id' => $d['id_divisi']])->row_array(); ?>
        <?php $data_cicilan = $this->db->get_where('data_cicilan', ['id_peng' => $d['id_peng'], 'tenor !=' => 0])->result_array(); ?>

        <!--proses Data-->
        <div class="modal fade" id="prosesData<?= $d['id'] ?>" role="dialog" aria-labelledby="printDataLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="printDataLabel">Proses Penggajian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('update/update_penggajian') ?>" method="post">
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="card bg-secondary text-white shadow">
                                    <div class="card-body">

                                        Nama : <?= $guru['nama'] ?><br />
                                        <small> Divisi : <?= $divisi['nama'] ?></small>
                                        <?php if (!empty($guru['dept'])) : ?>
                                            <br />
                                            <small> Departemen : <?= $guru['dept'] ?></small>
                                        <?php endif ?>
                                        <br />
                                        <div class="text-white-50 small">Tanggal Awal: <?= mediumdate_indo(date($d['tgl_awal'])) ?></div>
                                        <div class="text-white-50 small">Tanggal Akhir: <?= mediumdate_indo(date($d['tgl_akhir'])) ?></div>
                                    </div>

                                </div>
                            </div>
                            <input type="hidden" value="<?= $d['id'] ?>" name="id">
                            <input type="hidden" value="<?= $d['id_peng'] ?>" name="id_peng">
                            <div class="form-group">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Jumlah Hadir</td>
                                            <td><?= number_format($sum_hadir, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Jam</td>
                                            <td><?= number_format($sum_jam['sum_jam'], 0, ',', '.') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Proses Penggajian</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!--print Data-->
        <div class="modal fade" id="printData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewDataLabel"><i class="fa fa-print"></i> Print Penggajian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form target="_blank" action="<?= base_url('laporan/laporan_slip?id=' . $d['id']) ?>" method="post">
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="card bg-secondary text-white shadow">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-4">
                                                Nama : <?= $guru['nama'] ?><br />
                                                <small> Divisi : <?= $divisi['nama'] ?></small>
                                                <?php if (!empty($guru['dept'])) : ?>
                                                    <br />
                                                    <small> Departemen : <?= $guru['dept'] ?></small>
                                                <?php endif ?>
                                                <br />
                                                <div class="text-white-50 small">Tanggal Awal: <?= mediumdate_indo(date($d['tgl_awal'])) ?></div>
                                                <div class="text-white-50 small">Tanggal Akhir: <?= mediumdate_indo(date($d['tgl_akhir'])) ?></div>
                                            </div>
                                            <div class="col-md-2">
                                                <?php if (!empty($data_cicilan)) : ?>
                                                    <span class="float-right"> Cicilan :</span>
                                                <?php endif ?>
                                            </div>
                                            <div class="pt-1 col-md-6">
                                                <?php foreach ($data_cicilan as $c) : ?>
                                                    <?php $tot_cicilan = $c['nominal'] * $c['tenor']; ?>
                                                    <div class="text-white-50 small">
                                                        <?= $c['nama'] ?> : <?= number_format($c['nominal'], 0, ',', '.') ?> x <?= $c['tenor'] ?> = Rp. <?= number_format($tot_cicilan, 0, ',', '.') ?>
                                                    </div>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">

                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Jumlah Hadir</td>
                                                <td><?= number_format($sum_hadir, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td>Total Jam</td>
                                                <td><?= number_format($sum_jam['sum_jam'], 0, ',', '.') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Penggajian</th>
                                                    <th>Nominal</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>Gaji Pokok</td>
                                                    <td>Rp. <?= number_format($divisi['gaji'], 0, ',', '.') ?></td>
                                                    <td>Flat</td>
                                                </tr>
                                                <tr>
                                                    <td>Tunjangan</td>
                                                    <td>Rp. <?= number_format($divisi['tunjangan'], 0, ',', '.') ?></td>
                                                    <td>Flat</td>
                                                </tr>
                                                <tr>
                                                    <td>Intensif</td>
                                                    <td>Rp. <?= number_format($guru['intensif'], 0, ',', '.') ?></td>
                                                    <td>Rp. <?= number_format($guru['intensif'] * $sum_hadir, 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Jam</td>
                                                    <td>Rp. <?= number_format($guru['nominal_jam'], 0, ',', '.') ?></td>
                                                    <td>Rp. <?= number_format($guru['nominal_jam'] * $sum_jam['sum_jam'], 0, ',', '.') ?></td>
                                                </tr>
                                                <?php $jumlah_gaji = $divisi['gaji'] + $divisi['tunjangan'] + $guru['intensif'] * $sum_hadir + $guru['nominal_jam'] * $sum_jam['sum_jam']; ?>
                                                <tr>
                                                    <td class="float-right"><b>Jumlah : </b></td>
                                                    <th colspan="2"><b>Rp. <?= number_format($jumlah_gaji, 0, ',', '.') ?>,-</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Potongan</th>
                                                    <th>Nominal</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>Bpjs</td>
                                                    <td>Rp. <?= number_format($guru['bpjs'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Koperasi</td>
                                                    <td>Rp. <?= number_format($guru['koperasi'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Simpanan</td>
                                                    <td>Rp. <?= number_format($guru['simpanan'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tabungan</td>
                                                    <td>Rp. <?= number_format($guru['tabungan'], 0, ',', '.') ?></td>
                                                </tr>
                                                <?php $sum_bkst = $guru['bpjs'] + $guru['koperasi'] + $guru['simpanan'] + $guru['tabungan']; ?>
                                                <?php $sum = 0;
                                                foreach ($data_cicilan as $c) : ?>
                                                    <?php $sum += $c['nominal']; ?>
                                                    <tr>
                                                        <td><?= $c['nama'] ?></td>
                                                        <td>Rp. <?= number_format($c['nominal'], 0, ',', '.') ?></td>
                                                    </tr>
                                                <?php endforeach ?>

                                                <tr>
                                                    <td class="float-right"><b>Jumlah : </b></td>
                                                    <th colspan="2"><b>Rp. <?= number_format($sum + $sum_bkst, 0, ',', '.') ?>,-</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered">
                                            <?php $total_diterima = $jumlah_gaji - $sum - $sum_bkst; ?>
                                            <tbody>
                                                <tr>
                                                    <td><b>Total diterima : </b></td>
                                                    <th class="table-success" colspan="2"><b>Rp. <?= number_format($total_diterima, 0, ',', '.') ?>,-</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- inputan -->
                        <input type="hidden" value="<?= $d['id'] ?>" name="id">
                        <input type="hidden" value="<?= $d['id_peng'] ?>" name="id_peng">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Tambah Penggajian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/penggajian') ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="tgl_awal">Tanggal Awal</label>
                        <input class="form-control" type="date" id="tgl_awal" name="tgl_awal" value="<?= set_value('tgl_awal') ?>">
                        <?= form_error('tgl_awal', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="tgl_akhir">Tanggal Akhir</label>
                        <input class="form-control" type="date" id="tgl_akhir" name="tgl_akhir" value="<?= set_value('tgl_akhir') ?>">
                        <?= form_error('tgl_akhir', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah Penggajian</button>
                </div>

            </form>
        </div>
    </div>
</div>