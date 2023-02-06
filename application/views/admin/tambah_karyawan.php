<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row">

        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-user-plus fa-fw"></i> Tambah Karyawan Baru</h1>
            <hr />
        </div>
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="pt-2 fa fa-list-alt fa-fw"></i> Form Pendaftaran

                        <div class="float-right">
                            <a href="<?= base_url('admin/karyawan') ?>" class="btn btn-block btn-primary btn-sm"><i class="fa fa-angle-double-left"></i> Data Karyawan</a>
                        </div>
                    </h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>
                    <form action="<?= base_url('admin/tambah_karyawan') ?>" method="post">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="id_fp">Id Fingerprint</label>
                                    <input class="form-control" type="text" id="id_fp" name="id_fp" placeholder="ID Fingerprint" value="<?= set_value('id_fp') ?>" require>
                                    <?= form_error('id_fp', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>

                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" class="form-control" id="nik" name="nik" placeholder="Nomor Induk Kependudukan" value="<?= set_value('nik') ?>" require>
                                    <?= form_error('nik', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= set_value('nama') ?>" require>
                                    <?= form_error('nama', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= set_value('email') ?>" require>
                                    <?= form_error('email', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="<?= set_value('password') ?>" require>
                                    <?= form_error('password', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label for="jk" class="col-form-label">Jenis Kelamin :</label>
                                    <select class="form-control" id="jk" name="jk">
                                        <option value="">- Jenis Kelamin -</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="ttl" name="ttl" value="<?= set_value('ttl') ?>">
                                </div>

                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"><?= set_value('alamat') ?></textarea>
                                    <?= form_error('alamat', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Nomor Telepon</label>
                                    <input type="number" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon" value="<?= set_value('no_telp') ?>">
                                    <?= form_error('no_telp', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label for="level" class="col-form-label">Level</label>
                                    <select class="form-control" id="level" name="level">
                                        <option value="">- Pilih Level -</option>
                                        <option value="2">Kesiswaan</option>
                                        <?php if ($user['role_id'] == '1') : ?>
                                        <option value="5">Bendahara</option>
                                        <?php endif ?>
                                        <option value="3">Guru</option>
                                        <option value="4">Karyawan Umum</option>
                                        <option value="6">Marketing</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6">
                                
                                <div class="form-group">
                                    <label for="divisi">Divisi</label> <a href="<?= base_url('admin/data_divisi') ?>" class="badge badge-success">Tambah</a>
                                    <select class="form-control" id="divisi" name="divisi">
                                        <option value="">- Pilih Divisi -</option>
                                        <?php foreach ($divisi as $a) : ?>
                                            <option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('divisi', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="">Intensif</label>
                                    <input type="number" class="form-control" id="intensif" name="intensif" value="<?= set_value('intensif') ?>" placeholder="Intensif">
                                </div>
                                <div class="form-group">
                                    <label for="">Total Jam</label>
                                    <input type="number" class="form-control" id="jam_mengajar" name="jam_mengajar" value="<?= set_value('jam_mengajar') ?>" placeholder="Jumlah Jam mengajar">
                                </div>.

                                <div class="form-group">
                                    <label for="">Nominal Jam Mengajar</label>
                                    <input type="number" class="form-control" id="nominal_jam" name="nominal_jam" value="<?= set_value('nominal_jam') ?>" placeholder="Nominal Jam mengajar">
                                </div>

                                <div class="form-group">
                                    <label>BPJS</label>
                                    <input type="number" class="form-control" id="bpjs" name="bpjs" placeholder="Nominal BPJS" value="<?= set_value('bpjs') ?>">
                                    <?= form_error('bpjs', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Koperasi</label>
                                    <input type="number" class="form-control" id="koperasi" name="koperasi" placeholder="Nominal Koperasi" value="<?= set_value('koperasi') ?>">
                                    <?= form_error('koperasi', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Simpanan</label>
                                    <input type="number" class="form-control" id="simpanan" name="simpanan" placeholder="Nominal Simpanan" value="<?= set_value('simpanan') ?>">
                                    <?= form_error('simpanan', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Tabungan</label>
                                    <input type="number" class="form-control" id="tabungan" name="tabungan" placeholder="Nominal Tabungan" value="<?= set_value('tabungan') ?>">
                                    <?= form_error('tabungan', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <br />
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
                                                            <option>- Pilih pendidikan -</option>
                                                            <?php foreach ($pendidikan as $row) : ?>
                                                                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('pendidikan', '<small class="text-danger pl-3">', ' </small>') ?>
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
                                <button type="submit" class="btn-block btn btn-primary" onclick="return confirm('Lanjutkan Simpan Data Karyawan?');">Simpan Data Karyawan</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /.container-fluid -->

</div>