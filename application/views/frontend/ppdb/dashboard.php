<!-- Custom styles for this template-->
<link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

<style type="text/css">
    img[src=""] {
        display: none;
    }

    .pointer {
        cursor: pointer;
    }

input[type="checkbox"][class^="cb"] {
  display: none;
}

label {
  border: 1px solid #fff;
  display: block;
  position: relative;
  cursor: pointer;
}

label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}

label img {
  height: 35px;
  width: 80px;
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
}

:checked + label {
  border-color: #ddd;
}

:checked + label:before {
  content: "✓";
  background-color: grey;
  transform: scale(1);
}
:checked + .bg {
    background-color: darkgray;
    color: white;
}
:checked + label img {
    transform: scale(0.9);
    z-index: -1;
}
</style>
<main id="main" style="padding-top: 30px;">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <ol>
                <li><a href="<?= base_url('home'); ?>">Home</a></li>
                <li>Dashboard</li>
            </ol>

        </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
        <div class="container">


            <!-- Begin Page Content -->
            <div class="container-fluid">

                <div class="row">
                    <?php if ($user['status'] == 2) : ?>
                        <div class="col-md-12">
                            <div class="card-footer bg-info text-white shadow mb-2">
                                <div class="card-body">
                                    <strong><i class="bi bi-bell"></i> Informasi Penolakan.</strong><br />
                                    <span><?= $user['alasan'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <div class="col-md-4">
                        
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-list-alt fa-fw"></i> <b>Informasi</b></h6>
                            </div>
                            <div class="card-body">
                                <img src="<?php if (!empty($user['img_siswa'])) {
                                                echo base_url('assets/img/data/' . $user['img_siswa']);
                                            } ?>" class="img-thumbnail">
                                <br /><br />
                                <table style="font-size: 14px;" cellpadding="3">
                                    <tbody>
                                        <tr>
                                            <td>Nomor Daftar</td>
                                            <td>: <b><?= $user['no_daftar'] ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>: <?= $user['nama'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Daftar Ulang</td>
                                            <?php if ($user['inv']  !== '1') : ?>
                                                <td>: <span class="badge badge-danger badge-pill disabled" aria-disabled="true">Belum Bayar</span></td>
                                            <?php elseif ($user['inv']  == '1') : ?>
                                                <td>: <span class="badge badge-success badge-pill disabled" aria-disabled="true">Lunas</span></td>
                                            <?php endif ?>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <?php if ($user['status']  == '0') : ?>
                                                <td>: <span class="badge badge-warning badge-pill disabled" aria-disabled="true">Pending</span></td>
                                            <?php elseif ($user['status']  == '1') : ?>
                                                <td>: <span class="badge badge-success badge-pill disabled" aria-disabled="true">Konfirmasi</span></td>
                                            <?php elseif ($user['status']  == '2') : ?>
                                                <td>: <span class="badge badge-danger badge-pill disabled" aria-disabled="true">Di Tolak</span></td>
                                            <?php endif ?>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Daftar</td>
                                            <td>: <?= mediumdate_indo(date($user['date_created'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>: <?= $user['email'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>NIS</td>
                                            <td>: <?= $user['nis'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="card-footer">
                                <?php if ($user['status']  == '1') : ?>
                                    <a target="_blank" href="<?= base_url('laporan/cetak_formulir?id=' . $this->secure->encrypt($user['id'])) ?>" class="btn btn-info"><i class="bi bi-printer"></i> Cetak Formulir</a>
                                <?php endif ?>
                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#logoutModal"><i class="bi bi-box-arrow-right"></i> Logout</a>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-list-alt fa-fw"></i> <b>Informasi Daftar Ulang</b></h6>
                            </div>
                            <div class="card-body">
                                <table style="font-size: 14px;" cellpadding="3">
                                    <tbody>
                                        <?php $sum = 0; foreach ($pembayaran as $d) : ?>
                                        <?php $sum += $d['jumlah']; ?>
                                            <tr>
                                                <td><?= $d['nama'] ?></td>
                                                <td>: <?= 'Rp.' . number_format($d['jumlah'], 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                                <br>
                                Total pembayaran : <b><?= 'Rp.' . number_format($sum, 0, ',', '.') ?>,-</b>
                            </div>
                            <div class="card-footer">
                                <?php if ($user['inv']  == '1') : ?>
                                    <a target="_blank" href="<?= base_url('laporan/cetak_invoice?id=' . $this->secure->encrypt($user['id'])) ?>" class="btn btn-info"><i class="bi bi-printer"></i> Cetak Invoice</a>
                                <?php endif ?>
                                <?php if ($user['inv']  == '2') : ?>
                                    <a href="<?= $user['url_inv'] ?>" class="btn btn-primary btn-block"><i class="bi bi-credit-card"></i> Bayar <b><?= 'Rp.' . number_format($sum, 0, ',', '.') ?></b></a>
                                <?php elseif ($user['inv']  == '0') : ?>
                                    <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#payModal"><i class="bi bi-credit-card"></i> Bayar <b><?= 'Rp.' . number_format($sum, 0, ',', '.') ?></b></a>
                                <?php endif ?>
                            </div>
                        </div>

                        <!-- Payment Modal-->
                        <div class="modal fade" id="payModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Pilih Jenis Pembayaran :</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= base_url('ppdb/payment') ?>" method="post" id="payy">
                                            <input type="hidden" name="jumlah" value="<?= $sum ?>">
                                            <div id="jenis_pay"></div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                        <button class="btn btn-success" onclick="$('#payy').submit()"><i class="bi bi-credit-card"></i> Bayar <b><?= 'Rp.' . number_format($sum, 0, ',', '.') ?></b></button>
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
                                                        <span><?= $user['img_siswa'] ?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <img src="<?php if (!empty($user['img_siswa'])) {
                                                                        echo base_url('assets/img/data/' . $user['img_siswa']);
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
                                                        <span><?= $user['img_kk'] ?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <img src="<?php if (!empty($user['img_kk'])) {
                                                                        echo base_url('assets/img/data/' . $user['img_kk']);
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
                                                        <span><?= $user['img_ijazah'] ?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <img src="<?php if (!empty($user['img_ijazah'])) {
                                                                        echo base_url('assets/img/data/' . $user['img_ijazah']);
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
                                                        <span><?= $user['img_ktp'] ?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <img src="<?php if (!empty($user['img_ktp'])) {
                                                                        echo base_url('assets/img/data/' . $user['img_ktp']);
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
                                <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-list-alt fa-fw"></i> <b>Form Data Diri</b></h6>
                            </div>
                            <div class="card-body">
                                <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                                <?= $this->session->flashdata('message') ?>

                                <?= form_open_multipart('ppdb/dashboard'); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>NIK</label>
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <input type="hidden" name="status" value="<?= $user['status'] ?>">
                                            <input type="number" class="form-control" id="nik" name="nik" placeholder="Nomor Induk Kependudukan" value="<?= $user['nik'] ?>" require>
                                            <?= form_error('nik', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label>NIS</label>
                                            <input type="text" class="form-control" id="nis" name="nis" placeholder="Nomor Induk siswa" value="<?= $user['nis'] ?>" require>
                                            <?= form_error('nis', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>
                                        <div class="form-group form-box">
                                            <label>Password </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div onclick="myFunction()" class="input-group-text pointer"><i id="icon" class="bi bi-eye"></i></div>
                                                </div>
                                                <input type="text" class="active form-control" id="password" name="password" placeholder="Password">
                                            </div>
                                            <small class="text-info">Kosongkan jika tidak di ubah. </small>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= $user['nama'] ?>" require>
                                            <?= form_error('nama', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= $user['email'] ?>" require>
                                            <?= form_error('email', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>

                                        <div class="form-group">
                                            <label>Nomor Hp</label>
                                            <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor Hp" value="<?= $user['no_hp'] ?>" require>
                                            <?= form_error('no_hp', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="jk" class="col-form-label">Jenis Kelamin :</label>
                                            <select class="form-control" id="jk" name="jk">
                                                <option value="">- Jenis Kelamin -</option>
                                                <option <?php if ($user['jk'] == "L") {
                                                            echo "selected='selected'";
                                                        } ?> value="L">Laki-Laki</option>
                                                <option <?php if ($user['jk'] == "P") {
                                                            echo "selected='selected'";
                                                        } ?> value="P">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="ttl" name="ttl" value="<?= $user['ttl'] ?>">
                                            <?= form_error('ttl', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Provinsi</label>
                                            <select class="form-control" id="prov" name="prov">
                                                <?php foreach ($prov as $v) : ?>
                                                    <option <?php if ($user['prov'] == $v['nama']) {
                                                                echo "selected='selected'";
                                                            } ?> value="<?= $v['id_prov'] ?>"><?= $v['nama'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?= form_error('prov', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Kabupaten</label>
                                            <select class="form-control" id="kab" name="kab">
                                                <option value="<?= $user['kab']; ?>"><?= $user['kab']; ?></option>
                                                <option>- Pilih provinsi dahulu -</option>
                                            </select>
                                            <?= form_error('kab', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Kecamatan</label>
                                            <select class="form-control" id="kec" name="kec">
                                                <option value="<?= $user['kec']; ?>"><?= $user['kec']; ?></option>
                                                <option value="">- Pilih kabupaten dahulu -</option>
                                            </select>
                                            <?= form_error('kec', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Keluarahan</label>
                                            <select class="form-control" id="kel" name="kel">
                                                <option value="<?= $user['kel']; ?>"><?= $user['kel']; ?></option>
                                                <option value="">- Pilih kecamatan dahulu -</option>
                                            </select>
                                            <?= form_error('kel', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea type="text" rows="4" class="form-control" id="alamat" name="alamat" placeholder="Alamat Lengkap"><?= $user['alamat'] ?></textarea>
                                            <?= form_error('alamat', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Ayah</label>
                                            <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Nama Orang Tua" value="<?= $user['nama_ayah'] ?>">
                                            <?= form_error('nama_ayah', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Ibu</label>
                                            <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Nama Orang Tua" value="<?= $user['nama_ibu'] ?>">
                                            <?= form_error('nama_ibu', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>

                                        <div class="form-group">
                                            <label>Nama Wali</label>
                                            <input type="text" class="form-control" id="nama_wali" name="nama_wali" placeholder="Nama Wali" value="<?= $user['nama_wali'] ?>">
                                            <small class="text-info">* Kosongkan jika tidak ada.</small>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Pekerjaan Ayah</label>
                                            <select class="form-control" id="pek_ayah" name="pek_ayah" value="<?= $user['pek_ayah'] ?>">
                                                <option value="">- Pekerjaan Ayah -</option>
                                                <option <?php if ($user['pek_ayah'] == "Wiraswasta") {
                                                            echo "selected='selected'";
                                                        } ?> value="Wiraswasta">Wiraswasta</option>
                                                <option <?php if ($user['pek_ayah'] == "Pedagang") {
                                                            echo "selected='selected'";
                                                        } ?> value="Pedagang">Pedagang</option>
                                                <option <?php if ($user['pek_ayah'] == "Buruh") {
                                                            echo "selected='selected'";
                                                        } ?> value="Buruh">Buruh</option>
                                                <option <?php if ($user['pek_ayah'] == "Pensiunan") {
                                                            echo "selected='selected'";
                                                        } ?> value="Pensiunan">Pensiunan</option>
                                                <option <?php if ($user['pek_ayah'] == "Guru") {
                                                            echo "selected='selected'";
                                                        } ?> value="Guru">Guru</option>
                                                <option <?php if ($user['pek_ayah'] == "Honorer") {
                                                            echo "selected='selected'";
                                                        } ?> value="Honorer">Honorer</option>
                                                <option <?php if ($user['pek_ayah'] == "PNS") {
                                                            echo "selected='selected'";
                                                        } ?> value="PNS">PNS</option>
                                            </select>
                                            <?= form_error('pek_ayah', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>

                                        <div class="form-group">
                                            <label>Pekerjaan Ibu</label>
                                            <select class="form-control" id="pek_ibu" name="pek_ibu" value="<?= $user['pek_ibu'] ?>">
                                                <option value="">- Pekerjaan Ibu -</option>
                                                <option <?php if ($user['pek_ibu'] == "Ibu Rumah Tangga") {
                                                            echo "selected='selected'";
                                                        } ?> value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                                <option <?php if ($user['pek_ibu'] == "Wiraswasta") {
                                                            echo "selected='selected'";
                                                        } ?> value="Wiraswasta">Wiraswasta</option>
                                                <option <?php if ($user['pek_ibu'] == "Pedagang") {
                                                            echo "selected='selected'";
                                                        } ?> value="Pedagang">Pedagang</option>
                                                <option <?php if ($user['pek_ibu'] == "Buruh") {
                                                            echo "selected='selected'";
                                                        } ?> value="Buruh">Buruh</option>
                                                <option <?php if ($user['pek_ibu'] == "Pensiunan") {
                                                            echo "selected='selected'";
                                                        } ?> value="Pensiunan">Pensiunan</option>
                                                <option <?php if ($user['pek_ibu'] == "Guru") {
                                                            echo "selected='selected'";
                                                        } ?> value="Guru">Guru</option>
                                                <option <?php if ($user['pek_ibu'] == "Honorer") {
                                                            echo "selected='selected'";
                                                        } ?> value="Honorer">Honorer</option>
                                                <option <?php if ($user['pek_ibu'] == "PNS") {
                                                            echo "selected='selected'";
                                                        } ?> value="PNS">PNS</option>
                                                <?= form_error('pek_ibu', '<small class="text-danger pl-3">', ' </small>') ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Pekerjaan Wali</label>
                                            <select class="form-control" id="pek_wali" name="pek_wali">
                                                <option value="">- Pekerjaan Wali -</option>
                                                <option <?php if ($user['pek_wali'] == "Tidak ada wali") {
                                                            echo "selected='selected'";
                                                        } ?> value="Tidak ada wali">Tidak ada wali</option>
                                                <option <?php if ($user['pek_wali'] == "Wiraswasta") {
                                                            echo "selected='selected'";
                                                        } ?> value="Wiraswasta">Wiraswasta</option>
                                                <option <?php if ($user['pek_wali'] == "Pedagang") {
                                                            echo "selected='selected'";
                                                        } ?> value="Pedagang">Pedagang</option>
                                                <option <?php if ($user['pek_wali'] == "Buruh") {
                                                            echo "selected='selected'";
                                                        } ?> value="Buruh">Buruh</option>
                                                <option <?php if ($user['pek_wali'] == "Pensiunan") {
                                                            echo "selected='selected'";
                                                        } ?> value="Pensiunan">Pensiunan</option>
                                                <option <?php if ($user['pek_wali'] == "Guru") {
                                                            echo "selected='selected'";
                                                        } ?> value="Guru">Guru</option>
                                                <option <?php if ($user['pek_wali'] == "Honorer") {
                                                            echo "selected='selected'";
                                                        } ?> value="Honorer">Honorer</option>
                                                <option <?php if ($user['pek_wali'] == "PNS") {
                                                            echo "selected='selected'";
                                                        } ?> value="PNS">PNS</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Penghasilan Ortu / Wali</label>
                                            <select class="form-control" id="peng_ortu" name="peng_ortu">
                                                <option value="">- Penghasilan / Bulan -</option>
                                                <option <?php if ($user['peng_ortu'] == "< Rp.1.000.000") {
                                                            echo "selected='selected'";
                                                        } ?> value="< Rp.1.000.000">
                                                    << Rp.1.000.000</option>
                                                <option <?php if ($user['peng_ortu'] == "Rp.1.000.000 - Rp.2.000.000") {
                                                            echo "selected='selected'";
                                                        } ?> value="Rp.1.000.000 - Rp.2.000.000">Rp.1.000.000 - Rp.2.000.000</option>
                                                <option <?php if ($user['peng_ortu'] == "Rp.2.000.000 - Rp.3.000.000") {
                                                            echo "selected='selected'";
                                                        } ?> value="Rp.2.000.000 - Rp.3.000.000">Rp.2.000.000 - Rp.3.000.000</option>
                                                <option <?php if ($user['peng_ortu'] == "Rp.3.000.000 - Rp.4.000.000") {
                                                            echo "selected='selected'";
                                                        } ?> value="Rp.3.000.000 - Rp.4.000.000">Rp.3.000.000 - Rp.4.000.000</option>
                                                <option <?php if ($user['peng_ortu'] == "Rp.4.000.000 - Rp.5.000.000") {
                                                            echo "selected='selected'";
                                                        } ?> value="Rp.4.000.000 - Rp.5.000.000">Rp.4.000.000 - Rp.5.000.000</option>
                                                <option <?php if ($user['peng_ortu'] == "Rp.5.000.000 >") {
                                                            echo "selected='selected'";
                                                        } ?> value="Rp.5.000.000 >">
                                                    Rp.5.000.000 >></option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Nomor Telepon Ortu / Wali</label>
                                            <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon" value="<?= $user['no_telp'] ?>">
                                            <?= form_error('no_telp', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>

                                        <div class="form-group">
                                            <label>Sekolah Asal</label>
                                            <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" placeholder="Sekolah Asal" value="<?= $user['sekolah_asal'] ?>">
                                            <?= form_error('sekolah_asal', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>

                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Kelas" value="<?= $user['kelas'] ?>">
                                            <?= form_error('kelas', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Tahun Lulus</label>
                                            <input type="number" class="form-control" id="thn_lls" name="thn_lls" placeholder="Tahun Lulus" value="<?= $user['thn_lls'] ?>">
                                            <?= form_error('thn_lls', '<small class="text-danger pl-3">', ' </small>') ?>
                                        </div>

                                        <br />

                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <img src="<?php if (!empty($user['img_siswa'])) {
                                                                echo base_url('assets/img/data/' . $user['img_siswa']);
                                                            } ?>" width="100" height="85" id="preview" class="img-thumbnail mt-3">
                                            </div>
                                            <div class="col-sm-9">
                                                <input hidden type="file" name="img_siswa" class="file" accept="image/*" id="imgInp">
                                                <div class="input-group my-3">
                                                    <input type="text" class="form-control" disabled placeholder="Foto siswa" id="file">
                                                    <div class="input-group-append">
                                                        <button type="button" class="browse btn btn-primary">Browse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <img src="<?php if (!empty($user['img_kk'])) {
                                                                echo base_url('assets/img/data/' . $user['img_kk']);
                                                            } ?>" width="100" height="85" id="preview1" class="img-thumbnail mt-3">
                                            </div>
                                            <div class="col-sm-9">
                                                <input hidden type="file" name="img_kk" class="file1" accept="image/*" id="imgInp1">
                                                <div class="input-group my-3">
                                                    <input type="text" class="form-control" disabled placeholder="Foto KK (Kartu keluarga)" id="file1">
                                                    <div class="input-group-append">
                                                        <button type="button" class="browse1 btn btn-primary">Browse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <img src="<?php if (!empty($user['img_ijazah'])) {
                                                                echo base_url('assets/img/data/' . $user['img_ijazah']);
                                                            } ?>" width="100" height="85" id="preview2" class="img-thumbnail mt-3">
                                            </div>
                                            <div class="col-sm-9">
                                                <input hidden type="file" name="img_ijazah" class="file2" accept="image/*" id="imgInp2">
                                                <div class="input-group my-3">
                                                    <input type="text" class="form-control" disabled placeholder="Foto Ijazah" id="file2">
                                                    <div class="input-group-append">
                                                        <button type="button" class="browse2 btn btn-primary">Browse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <img src="<?php if (!empty($user['img_ktp'])) {
                                                                echo base_url('assets/img/data/' . $user['img_ktp']);
                                                            } ?>" width="100" height="85" id="preview3" class="img-thumbnail mt-3">
                                            </div>
                                            <div class="col-sm-9">
                                                <input hidden type="file" name="img_ktp" class="file3" accept="image/*" id="imgInp3">
                                                <div class="input-group my-3">
                                                    <input type="text" class="form-control" disabled placeholder="Foto Akte / KTP" id="file3">
                                                    <div class="input-group-append">
                                                        <button type="button" class="browse3 btn btn-primary">Browse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <hr class="sidebar-divider">
                                        <hr class="sidebar-divider">

                                        <div class="form-group">
                                            <label>Tahun Masuk</label>
                                            <select class="form-control" id="thn_msk" name="thn_msk">
                                                <option>- Pilih Periode -</option>
                                                <?php foreach ($thn_msk as $row) : ?>
                                                    <option <?php if ($user['thn_msk'] == $row['id']) {
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

                                                                        <option <?php if ($user['id_pend'] == $row['id']) {
                                                                                    echo "selected='selected'";
                                                                                } ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>

                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <?= form_error('pendidikan', '<small class="text-danger pl-3">', ' </small>') ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div id="jurus" class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Kejuruan</label>
                                                                <select class="form-control" id="jurusan" name="jurusan">
                                                                    <option>- Pilih Jurusan -</option>
                                                                    <?php foreach ($jurusan as $s) : ?>

                                                                    <option <?php if ($user['id_majors'] == $s['id']) {
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
                                        <button type="submit" onclick="return confirm('Lanjutkan Simpan Data?');" class="btn btn-block btn-success"><i class="bi bi-arrow-clockwise"></i> Perbaharui Data</button>
                                    </div>
                                </div>

                                <?php form_close(); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.container-fluid -->


        </div>
    </section>

</main><!-- End #main -->

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yakin ingin meninggalkan dashboard?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Pilih <b>Keluar</b> jika kamu ingin keluar dari dashboard</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-danger" href="<?= base_url('ppdb/logout') ?>"><i class="bi bi-box-arrow-right"></i> Keluar</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var input = document.getElementById('password'),
        icon = document.getElementById('icon');

    icon.onclick = function() {

        if (input.className == 'active form-control') {
            input.setAttribute('type', 'text');
            icon.className = 'bi bi-eye';
            input.className = 'form-control';

        } else {
            input.setAttribute('type', 'password');
            icon.className = 'bi bi-eye-slash';
            input.className = 'active form-control';
        }

    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        <?php if ($user['id_majors'] == 0) : ?>
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

        $.ajax({
            type: 'POST',
            url: '<?= site_url('get/get_jenis_pay'); ?>',
            cache: false,
            success: function(response) {
                $('#jenis_pay').html();
                $('#jenis_pay').html(response);
            }
        });

        $(document).on('change', ".cb", function() {
            $(".cb").not(this).prop('checked', false); 
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
</script>