<style type="text/css">
    img[src=""] {
        display: none;
    }

    .pointer {
        cursor: pointer;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Modal -->
    <div class="modal fade" id="ubahPass" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDataLabel">Ubah Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open_multipart('update/password_ppdb'); ?>
                    <form action="<?= base_url('update/password_ppdb') ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Password Baru</label>
                                <input type="hidden" name="id" value="<?= $siswa['id'] ?>">
                                <input type="text" class="form-control" id="password" name="password" placeholder="Password baru">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-redo"></i> Ubah Password</button>
                        </div>
                    </form>
                <?= form_close() ?>
            </div>
        </div>
    </div>
    <!-- Page Heading -->

    <div class="row">

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-list-alt fa-fw"></i> <b>Informasi</b></h6>
                </div>
                <div class="card-body">
                    <?= $this->session->flashdata('messageInfo') ?>
                    <table style="font-size: 14px;" cellpadding="3">
                        <tbody>
                            <tr>
                                <td>Nomor Daftar</td>
                                <td>: <b><?= $siswa['no_daftar'] ?></b></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>: <?= $siswa['nama'] ?></td>
                            </tr>
                            <tr>
                                <td>Invoice ppdb</td>
                                <?php if ($siswa['inv']  !== '1') : ?>
                                    <td>: <span class="badge badge-danger badge-pill disabled" aria-disabled="true">Belum Bayar</span></td>
                                <?php elseif ($siswa['inv']  == '1') : ?>
                                    <td>: <span class="badge badge-success badge-pill disabled" aria-disabled="true">Lunas</span></td>
                                <?php endif ?>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <?php if ($siswa['status']  == '0') : ?>
                                    <td>: <span class="badge badge-warning badge-pill disabled" aria-disabled="true">Pending</span></td>
                                <?php elseif ($siswa['status']  == '1') : ?>
                                    <td>: <span class="badge badge-success badge-pill disabled" aria-disabled="true">Konfirmasi</span></td>
                                <?php elseif ($siswa['status']  == '2') : ?>
                                    <td>: <span class="badge badge-danger badge-pill disabled" aria-disabled="true">Di Tolak</span></td>
                                <?php endif ?>
                            </tr>
                            <?php if ($user['role_id'] == 1) : ?>
                            <?php if (!empty($siswa['staff_konfirmasi'])) : ?>
                                <tr>
                                    <td>Staff Konfirmasi</td>
                                    <td>: <?= $staff['nama'] ?></td>
                                </tr>
                            <?php endif ?>
                            <?php endif ?>
                            <tr>
                                <td>Tanggal Daftar</td>
                                <td>: <?= mediumdate_indo(date($siswa['date_created'])); ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: <?= $siswa['email'] ?></td>
                            </tr>
                            <tr>
                                <td>NIS</td>
                                <td>: <?= $siswa['nis'] ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="card-footer">
                    <?php if ($siswa['status']  == '0') : ?>
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#tolakModal"><i class="fa fa-times"></i> Tolak</a>
                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#konfirmasiModal"><i class="fa fa-check"></i> Konfirmasi</a>
                    <?php elseif ($siswa['status']  == '1') : ?>
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#batalModal"><i class="fa fa-ban"></i> Batal</a>
                        <a target="_blank" href="<?= base_url('laporan/cetak_formulir?id=' . $this->secure->encrypt($siswa['id'])) ?>" class="btn btn-info"><i class="fa fa-print"></i> Cetak Formulir</a>
                    <?php elseif ($siswa['status']  == '2') : ?>
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#batalTolModal"><i class="fa fa-ban"></i> Batal Tolak</a>
                    <?php endif ?>

                </div>


                <!-- Tolak Modal-->
                <div class="modal fade" id="tolakModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tolak PPDB</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <?= form_open_multipart('update/tolak_ppdb/admin'); ?>
                            <form action="<?= base_url('update/tolak_ppdb/admin') ?>" method="post">
                                <div class="modal-body">
                                    <p>Apakah anda yakin ingin menolak data ppdb <b><?= $siswa['nama'] ?></b></p>

                                    <div class="form-group">
                                        <label>Alasan :</label>
                                        <input type="hidden" name="id" value="<?= $siswa['id'] ?>">
                                        <textarea rows="5" type="text" class="form-control" id="alasan" name="alasan" placeholder="Alasan tolak"></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i> Tolak PPDB</button>
                                </div>
                            </form>
                            <?php form_close(); ?>
                        </div>
                    </div>
                </div>


            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-list fa-fw"></i> <b>Raport / Ijazah</b></h6>
                </div>
                <div class="card-body">
                    <?= $this->session->flashdata('messageRap') ?>

                        <div class="form-group row">
                            <label for="" class="col-sm-4 control-label">Status</label>
                            <div class="col-sm-8">
                                <?php if($siswa['raport'] == '1'){
                                    $stat_rap = 'Diterima';
                                    $pill_rap = 'success';
                                }else{
                                    $stat_rap = 'Belum Diterima';
                                    $pill_rap = 'danger';
                                }
                                ?>
                                <button class="btn btn-xs btn-<?= $pill_rap ?>"><?= $stat_rap ?></button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-4 control-label">Update Status</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="raport" id="raport">
                                    <option value="">-- Pilih Opsi --</option>
                                    <option <?php if ($siswa['raport'] == "1") {
                                                    echo "selected='selected'";
                                                } ?> value="1">Di Terima</option>
                                    <option value="">Batal</option>
                                </select>
                            </div>
                        </div>

                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-image fa-fw"></i> <b>Data Foto</b></h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Foto siswa</div>
                                            <span><?= $siswa['img_siswa'] ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <img src="<?php if (!empty($siswa['img_siswa'])) {
                                                            echo base_url('assets/img/data/' . $siswa['img_siswa']);
                                                        } ?>" width="100" height="85" id="preview1" class="img-thumbnail">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Foto KK</div>
                                            <span><?= $siswa['img_kk'] ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <img src="<?php if (!empty($siswa['img_kk'])) {
                                                            echo base_url('assets/img/data/' . $siswa['img_kk']);
                                                        } ?>" width="100" height="85" id="preview1" class="img-thumbnail">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Foto Ijazah</div>
                                            <span><?= $siswa['img_ijazah'] ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <img src="<?php if (!empty($siswa['img_ijazah'])) {
                                                            echo base_url('assets/img/data/' . $siswa['img_ijazah']);
                                                        } ?>" width="100" height="85" id="preview1" class="img-thumbnail">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Foto Akte / KTP</div>
                                            <span><?= $siswa['img_ktp'] ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <img src="<?php if (!empty($siswa['img_ktp'])) {
                                                            echo base_url('assets/img/data/' . $siswa['img_ktp']);
                                                        } ?>" width="100" height="85" id="preview1" class="img-thumbnail">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-list-alt fa-fw"></i> <b>Form Data Diri</b>
                        <div class="float-right">
                            <a href="<?= base_url('admin/ppdb') ?>" class="btn btn-block btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> Data PPDB</a>
                        </div>
                    </h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>

                    <?= form_open_multipart('admin/edit_ppdb?id=' . $this->input->get('id')); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="hidden" name="id" value="<?= $siswa['id'] ?>">
                                <input type="number" class="form-control" id="nik" name="nik" placeholder="Nomor Induk Kependudukan" value="<?= $siswa['nik'] ?>" require>
                                <?= form_error('nik', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                            <div class="form-group">
                                <label>NIS</label>
                                <input type="text" class="form-control" id="nis" name="nis" placeholder="Nomor Induk siswa" value="<?= $siswa['nis'] ?>" require>
                                <?= form_error('nis', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= $siswa['nama'] ?>" require>
                                <?= form_error('nama', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= $siswa['email'] ?>" require>
                                <?= form_error('email', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Password</label> :
                                <a href="#" class="badge badge-success" data-toggle="modal" data-target="#ubahPass">Ubah Password</a>
                            </div>

                            <div class="form-group">
                                <label>Nomor Hp</label>
                                <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor Hp" value="<?= $siswa['no_hp'] ?>" require>
                                <?= form_error('no_hp', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                            <div class="form-group">
                                <label for="jk" class="col-form-label">Jenis Kelamin :</label>
                                <select class="form-control" id="jk" name="jk">
                                    <option value="">- Jenis Kelamin -</option>
                                    <option <?php if ($siswa['jk'] == "L") {
                                                echo "selected='selected'";
                                            } ?> value="L">Laki-Laki</option>
                                    <option <?php if ($siswa['jk'] == "P") {
                                                echo "selected='selected'";
                                            } ?> value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control" id="ttl" name="ttl" value="<?= $siswa['ttl'] ?>">
                                <?= form_error('ttl', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                            <div class="form-group">
                                <label>Provinsi</label>
                                <select class="form-control" id="prov" name="prov">
                                    <?php foreach ($prov as $v) : ?>
                                        <option <?php if ($siswa['prov'] == $v['nama']) {
                                                    echo "selected='selected'";
                                                } ?> value="<?= $v['id_prov'] ?>"><?= $v['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('prov', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                            <div class="form-group">
                                <label>Kota</label>
                                <select class="form-control" id="kab" name="kab">
                                    <option value="<?= $siswa['kab']; ?>"><?= $siswa['kab']; ?></option>
                                    <option>- Pilih provinsi dahulu -</option>
                                </select>
                                <?= form_error('kab', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <select class="form-control" id="kec" name="kec">
                                    <option value="<?= $siswa['kec']; ?>"><?= $siswa['kec']; ?></option>
                                    <option value="">- Pilih kabupaten dahulu -</option>
                                </select>
                                <?= form_error('kec', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                            <div class="form-group">
                                <label>Keluarahan</label>
                                <select class="form-control" id="kel" name="kel">
                                    <option value="<?= $siswa['kel']; ?>"><?= $siswa['kel']; ?></option>
                                    <option value="">- Pilih kecamatan dahulu -</option>
                                </select>
                                <?= form_error('kel', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"><?= $siswa['alamat'] ?></textarea>
                                <?= form_error('alamat', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Nama Orang Tua" value="<?= $siswa['nama_ayah'] ?>">
                                <?= form_error('nama_ayah', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                            <div class="form-group">
                                <label>Nama Ibu</label>
                                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Nama Orang Tua" value="<?= $siswa['nama_ibu'] ?>">
                                <?= form_error('nama_ibu', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                              
                            <div class="form-group">
                                <label>Nama Wali</label>
                                <input type="text" class="form-control" id="nama_wali" name="nama_wali" placeholder="Nama Wali" value="<?= $siswa['nama_wali'] ?>">
                                <small class="text-info">* Kosongkan jika tidak ada.</small>
                            </div>

                        </div>

                        <div class="col-md-6">
                          
                            <div class="form-group">
                                <label>Pekerjaan Ayah</label>
                                <select class="form-control" id="pek_ayah" name="pek_ayah" value="<?= $siswa['pek_ayah'] ?>">
                                    <option value="">- Pekerjaan Ayah -</option>
                                    <option <?php if ($siswa['pek_ayah'] == "Wiraswasta") {
                                                echo "selected='selected'";
                                            } ?> value="Wiraswasta">Wiraswasta</option>
                                    <option <?php if ($siswa['pek_ayah'] == "Pedagang") {
                                                echo "selected='selected'";
                                            } ?> value="Pedagang">Pedagang</option>
                                    <option <?php if ($siswa['pek_ayah'] == "Buruh") {
                                                echo "selected='selected'";
                                            } ?> value="Buruh">Buruh</option>
                                    <option <?php if ($siswa['pek_ayah'] == "Pensiunan") {
                                                echo "selected='selected'";
                                            } ?> value="Pensiunan">Pensiunan</option>
                                    <option <?php if ($siswa['pek_ayah'] == "Guru") {
                                                echo "selected='selected'";
                                            } ?> value="Guru">Guru</option>
                                    <option <?php if ($siswa['pek_ayah'] == "Honorer") {
                                                echo "selected='selected'";
                                            } ?> value="Honorer">Honorer</option>
                                    <option <?php if ($siswa['pek_ayah'] == "PNS") {
                                                echo "selected='selected'";
                                            } ?> value="PNS">PNS</option>
                                </select>
                                <?= form_error('pek_ayah', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Pekerjaan Ibu</label>
                                <select class="form-control" id="pek_ibu" name="pek_ibu" value="<?= $siswa['pek_ibu'] ?>">
                                    <option value="">- Pekerjaan Ibu -</option>
                                    <option <?php if ($siswa['pek_ibu'] == "Ibu Rumah Tangga") {
                                                echo "selected='selected'";
                                            } ?> value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                    <option <?php if ($siswa['pek_ibu'] == "Wiraswasta") {
                                                echo "selected='selected'";
                                            } ?> value="Wiraswasta">Wiraswasta</option>
                                    <option <?php if ($siswa['pek_ibu'] == "Pedagang") {
                                                echo "selected='selected'";
                                            } ?> value="Pedagang">Pedagang</option>
                                    <option <?php if ($siswa['pek_ibu'] == "Buruh") {
                                                echo "selected='selected'";
                                            } ?> value="Buruh">Buruh</option>
                                    <option <?php if ($siswa['pek_ibu'] == "Pensiunan") {
                                                echo "selected='selected'";
                                            } ?> value="Pensiunan">Pensiunan</option>
                                    <option <?php if ($siswa['pek_ibu'] == "Guru") {
                                                echo "selected='selected'";
                                            } ?> value="Guru">Guru</option>
                                    <option <?php if ($siswa['pek_ibu'] == "Honorer") {
                                                echo "selected='selected'";
                                            } ?> value="Honorer">Honorer</option>
                                    <option <?php if ($siswa['pek_ibu'] == "PNS") {
                                                echo "selected='selected'";
                                            } ?> value="PNS">PNS</option>
                                    <?= form_error('pek_ibu', '<small class="text-danger pl-3">', ' </small>') ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pekerjaan Wali</label>
                                <select class="form-control" id="pek_wali" name="pek_wali">
                                    <option value="">- Pekerjaan Wali -</option>
                                    <option <?php if ($siswa['pek_wali'] == "Tidak ada wali") {
                                                echo "selected='selected'";
                                            } ?> value="Tidak ada wali">Tidak ada wali</option>
                                    <option <?php if ($siswa['pek_wali'] == "Wiraswasta") {
                                                echo "selected='selected'";
                                            } ?> value="Wiraswasta">Wiraswasta</option>
                                    <option <?php if ($siswa['pek_wali'] == "Pedagang") {
                                                echo "selected='selected'";
                                            } ?> value="Pedagang">Pedagang</option>
                                    <option <?php if ($siswa['pek_wali'] == "Buruh") {
                                                echo "selected='selected'";
                                            } ?> value="Buruh">Buruh</option>
                                    <option <?php if ($siswa['pek_wali'] == "Pensiunan") {
                                                echo "selected='selected'";
                                            } ?> value="Pensiunan">Pensiunan</option>
                                    <option <?php if ($siswa['pek_wali'] == "Guru") {
                                                echo "selected='selected'";
                                            } ?> value="Guru">Guru</option>
                                    <option <?php if ($siswa['pek_wali'] == "Honorer") {
                                                echo "selected='selected'";
                                            } ?> value="Honorer">Honorer</option>
                                    <option <?php if ($siswa['pek_wali'] == "PNS") {
                                                echo "selected='selected'";
                                            } ?> value="PNS">PNS</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Penghasilan Ortu / Wali</label>
                                <select class="form-control" id="peng_ortu" name="peng_ortu">
                                    <option value="">- Penghasilan / Bulan -</option>
                                    <option <?php if ($siswa['peng_ortu'] == "< Rp.1.000.000") {
                                                echo "selected='selected'";
                                            } ?> value="< Rp.1.000.000">
                                        << Rp.1.000.000</option>
                                    <option <?php if ($siswa['peng_ortu'] == "Rp.1.000.000 - Rp.2.000.000") {
                                                echo "selected='selected'";
                                            } ?> value="Rp.1.000.000 - Rp.2.000.000">Rp.1.000.000 - Rp.2.000.000</option>
                                    <option <?php if ($siswa['peng_ortu'] == "Rp.2.000.000 - Rp.3.000.000") {
                                                echo "selected='selected'";
                                            } ?> value="Rp.2.000.000 - Rp.3.000.000">Rp.2.000.000 - Rp.3.000.000</option>
                                    <option <?php if ($siswa['peng_ortu'] == "Rp.3.000.000 - Rp.4.000.000") {
                                                echo "selected='selected'";
                                            } ?> value="Rp.3.000.000 - Rp.4.000.000">Rp.3.000.000 - Rp.4.000.000</option>
                                    <option <?php if ($siswa['peng_ortu'] == "Rp.4.000.000 - Rp.5.000.000") {
                                                echo "selected='selected'";
                                            } ?> value="Rp.4.000.000 - Rp.5.000.000">Rp.4.000.000 - Rp.5.000.000</option>
                                    <option <?php if ($siswa['peng_ortu'] == "Rp.5.000.000 >") {
                                                echo "selected='selected'";
                                            } ?> value="Rp.5.000.000 >">
                                        Rp.5.000.000 >></option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nomor Telepon Ortu / Wali</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon" value="<?= $siswa['no_telp'] ?>">
                                <?= form_error('no_telp', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Tahun Masuk</label>
                                <input type="number" class="form-control" id="thn_msk" name="thn_msk" placeholder="Tahun Masuk" value="<?= $siswa['thn_msk'] ?>">
                                <?= form_error('thn_msk', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Sekolah Asal</label>
                                <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" placeholder="Sekolah Asal" value="<?= $siswa['sekolah_asal'] ?>">
                                <?= form_error('sekolah_asal', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text" class="form-control" id="old_kelas" name="old_kelas" placeholder="Kelas" value="<?= $siswa['kelas'] ?>">
                                <?= form_error('old_kelas', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Tahun Lulus</label>
                                <input type="number" class="form-control" id="thn_lls" name="thn_lls" placeholder="Tahun Lulus" value="<?= $siswa['thn_lls'] ?>">
                                <?= form_error('thn_lls', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>
                                        
                            <hr class="sidebar-divider">
                            <hr class="sidebar-divider">

                            <div class="form-group">
                                <label>Tahun Masuk</label>
                                <select class="form-control" id="thn_msk" name="thn_msk">
                                    <option>- Pilih Periode -</option>
                                    <?php foreach ($thn_msk as $row) : ?>
                                        <option <?php if ($siswa['thn_msk'] == $row['id']) {
                                                                        echo "selected='selected'";
                                                } ?> value="<?= $row['id'] ?>"><?= $row['period_start'] ?>/<?= $row['period_end'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('thn_msk', '<small class="text-danger pl-3">', ' </small>') ?>
                            </div>

                            <div class="form-group">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-university fa-fw"></i> Penempatan</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Pendidikan</label>
                                                    <select class="form-control" id="pendidikan" name="pendidikan">
                                                        <option>- Pilih Pendidikan -</option>
                                                        <?php foreach ($pendidikan as $row) : ?>

                                                            <option <?php if ($siswa['id_pend'] == $row['id']) {
                                                                        echo "selected='selected'";
                                                                    } ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>

                                                        <?php endforeach; ?>
                                                    </select>
                                                    <?= form_error('pendidikan', '<small class="text-danger pl-3">', ' </small>') ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Kelas</label>
                                                    <select class="form-control" id="kelas" name="kelas">
                                                        <option>- Pilih Kelas -</option>
                                                        <?php foreach ($kelas as $kmr) : ?>

                                                            <option <?php if ($siswa['id_kelas'] == $kmr['id']) {
                                                                        echo "selected='selected'";
                                                                    } ?> value="<?= $kmr['id'] ?>"><?= $kmr['nama'] ?></option>

                                                        <?php endforeach; ?>
                                                    </select>
                                                    <?= form_error('kelas', '<small class="text-danger pl-3">', ' </small>') ?>
                                                </div>
                                            </div>
                                            <div id="jurus" class="col-md-12">
                                                <div class="form-group">
                                                    <label>Kejuruan</label>
                                                    <select class="form-control" id="jurusan" name="jurusan">
                                                        <option>- Pilih Jurusan -</option>
                                                        <?php foreach ($jurusan as $s) : ?>

                                                        <option <?php if ($siswa['id_majors'] == $s['id']) {
                                                                    echo "selected='selected'";
                                                                } ?> value="<?= $s['id'] ?>"><?= $s['nama'] ?></option>

                                                        <?php endforeach; ?>
                                                    </select>
                                                    <?= form_error('jurusan', '<small class="text-danger pl-3">', ' </small>') ?>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col-md-12">
                            <button type="submit" onclick="return confirm('Lanjutkan Simpan Data?');" class="btn btn-block btn-success"><i class="fa fa-redo"></i> Perbaharui Data</button>
                        </div>
                    </div>

                    <?php form_close(); ?>

                    <?php if ($siswa['status']  == '1') : ?>
                    <div class="pt-3 form-group row">
                        <div class="col-md-12">
                            <a href="<?= base_url('admin/import_ppdb?id=' . $siswa['id']) ?>" onclick="return confirm('Lanjutkan Import Data?');" class="btn btn-block btn-primary"><i class="fa fa-file-import"></i> Import ke Data siswa</a>
                        </div>
                    </div>
                    <?php endif ?>

                </div>
            </div>
        </div>

    </div>
</div>
<!-- /.container-fluid -->

<!-- Konfirmasi Modal-->
<div class="modal fade" id="konfirmasiModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda yakin ingin Konfirmasi data <b><?= $siswa['nama'] ?></b></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-success" href="<?= base_url('update/konfirmasi_ppdb/admin?id=' . $siswa['id'] .'&staff=' . $user['id']) ?>"><i class="fa fa-check"></i> Konfirmasi</a>
            </div>
        </div>
    </div>
</div>

<!-- Batal Konfirmasi Modal-->
<div class="modal fade" id="batalModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Batal Konfirmasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda yakin ingin membatalkan Konfirmasi data <b><?= $siswa['nama'] ?></b></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-danger" href="<?= base_url('update/batal_konfirmasi_ppdb/admin?id=' . $siswa['id']) ?>"><i class="fa fa-ban"></i> Batal Konfirmasi</a>
            </div>
        </div>
    </div>
</div>

<!-- Batal Tolak Modal-->
<div class="modal fade" id="batalTolModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Batal Tolak</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda yakin ingin membatalkan tolakan data <b><?= $siswa['nama'] ?></b></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-danger" href="<?= base_url('update/batal_konfirmasi_ppdb/admin?id=' . $siswa['id']) ?>"><i class="fa fa-ban"></i> Batal Tolak</a>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        <?php if ($siswa['id_majors'] == 0) : ?>
        $("#jurus").hide();
        <?php endif ?>
        $('#prov').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_kota_ppdb'); ?>',
                data: {
                    prov: this.value
                },
                cache: false,
                success: function(response) {
                    $('#kab').html(response);
                }
            });
        });
        $('#kab').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_kec'); ?>',
                data: {
                    kab: this.value
                },
                cache: false,
                success: function(response) {
                    $('#kec').html(response);
                }
            });
        });
        $('#kec').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_kel'); ?>',
                data: {
                    kec: this.value
                },
                cache: false,
                success: function(response) {
                    $('#kel').html(response);
                }
            });
        });
        $('#pendidikan').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get/get_kelas_all'); ?>',
                data: {
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


<script type="text/javascript">
    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });

    $(document).on("click", ".browse1", function() {
        var file = $(this).parents().find(".file1");
        file.trigger("click");
    });

    $(document).on("click", ".browse2", function() {
        var file = $(this).parents().find(".file2");
        file.trigger("click");
    });

    $(document).on("click", ".browse3", function() {
        var file = $(this).parents().find(".file3");
        file.trigger("click");
    });

    $('#imgInp').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });

    $('#imgInp1').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file1").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview1").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });

    $('#imgInp2').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file2").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview2").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });

    $('#imgInp3').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file3").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview3").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });

    $(document).ready(function() {
        $('#raport').on('change',function(){
            $.ajax({
                type: 'POST',
                url: '<?= site_url('update/update_raport'); ?>',
                data: {
                    raport: this.value,
                    id: <?= $siswa['id'] ?>
                },
                cache: false,
                success: function(response) {
                    location.reload();
                }
            });
        });
    });
</script>