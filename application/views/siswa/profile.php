<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <!-- Page Heading -->
        <div class="col-md-12 text-center">
            <h1 class="h4 mb-2 text-gray-800">My profile</h1>
            <hr class="sidebar-divider">
        </div>

        <!-- DataTales Example -->
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-info-circle fa-fw"></i> Data Akun</h6>
                </div>
                <div class="card-body">

                    <?= $this->session->flashdata('message') ?>
                    <form action="<?= base_url('siswa/profile') ?>" method="post">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" class="form-control" id="nik" name="nik" placeholder="Nomor Induk Kependudukan" value="<?= $user['nik'] ?>">
                                    <?= form_error('nik', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>NIS</label>
                                    <input type="text" class="form-control" id="nis" name="nis" placeholder="Nomor Induk siswa" value="<?= $user['nis'] ?>">
                                    <?= form_error('nis', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= $user['nama'] ?>">
                                    <?= form_error('nama', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= $user['email'] ?>">
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
                                    <label>Kota</label>
                                    <select class="form-control" id="kab" name="kab">
                                        <option value="<?= $user['kab']; ?>"><?= $user['kab']; ?></option>
                                        <option>- Pilih provinsi dahulu -</option>
                                        <?= form_error('kab', '<small class="text-danger pl-3">', ' </small>') ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"><?= $user['alamat'] ?></textarea>
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
                                    <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" placeholder="Sekolah Asalk" value="<?= $user['sekolah_asal'] ?>">
                                    <?= form_error('sekolah_asal', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Kelas</label>
                                    <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Kelas" value="<?= $user['kelas'] ?>">
                                    <?= form_error('kelas', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Tahun Masuk</label>
                                    <input type="text" class="form-control" value="<?= $thn_msk['period_start'].'/'.$thn_msk['period_end'] ?>" disabled>
                                </div>

                                <div class="form-group">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-university fa-fw"></i> Penempatan</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Pendidikan</label>
                                                        <input type="text" class="form-control" value="<?= $pendidikan['nama'] ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kelas</label>
                                                        <input type="text" class="form-control" value="<?= $kelas['nama'] ?>" disabled>
                                                    </div>
                                                </div>
                                                <?php if($pendidikan['majors'] == 1) : ?>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Kejuruan</label>
                                                            <input type="text" class="form-control" value="<?= $majors['nama'] ?>" disabled>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                            </div>

                                        </div>

                                        <div class="card-footer bg-info text-white shadow mb-2">
                                            <div class="card-body">
                                                <i class="fa fa-bell"></i> Untuk mengubah data penempatan siswa, Silahkan hubungi ke karyawan melalui <a href="<?= base_url('siswa/konseling') ?>" class="badge badge-primary"> Konseling</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="pt-3 form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn-block btn btn-primary" onclick="return confirm('Lanjutkan Simpan Data?');">Simpan Data</button>
                            </div>
                        </div>

                    </form>
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
                url: '<?= site_url('get/get_kota'); ?>',
                data: {
                    prov: this.value
                },
                cache: false,
                success: function(response) {
                    $('#kab').html(response);
                }
            });
        });
    });
</script>