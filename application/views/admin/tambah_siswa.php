<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row">

        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-user-plus fa-fw"></i> Pendaftaran siswa Baru</h1>
            <hr />
        </div>
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="pt-2 fa fa-list-alt fa-fw"></i> Form Pendaftaran

                        <div class="float-right">
                            <a href="<?= base_url('admin/daftar_siswa') ?>" class="btn btn-block btn-primary btn-sm"><i class="fa fa-angle-double-left"></i> Data siswa</a>
                        </div>
                    </h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>
                    <form action="<?= base_url('admin/tambah_siswa') ?>" method="post">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" class="form-control" id="nik" name="nik" placeholder="Nomor Induk Kependudukan" value="<?= set_value('nik') ?>" require>
                                    <?= form_error('nik', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>NIS</label>
                                    <input type="text" class="form-control" id="nis" name="nis" placeholder="Nomor Induk siswa" value="<?= set_value('nis') ?>" require>
                                    <small class="text-info">* Password otomatis sama dengan NIS</small><br />
                                    <?= form_error('nis', '<small class="text-danger pl-3">', ' </small>') ?>
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
                                    <label>Provinsi</label>
                                    <select class="form-control" id="prov" name="prov">
                                        <option>- Pilih Provinsi -</option>
                                        <?php foreach ($prov as $v) : ?>
                                            <option value="<?= $v['id_prov'] ?>"><?= $v['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('prov', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Kota</label>
                                    <select class="form-control" id="kab" name="kab">
                                        <option>- Pilih provinsi dahulu -</option>
                                        <?= form_error('kab', '<small class="text-danger pl-3">', ' </small>') ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"><?= set_value('alamat') ?></textarea>
                                    <?= form_error('alamat', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Nama Ayah</label>
                                    <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Nama Orang Tua" value="<?= set_value('nama_ayah') ?>">
                                    <?= form_error('nama_ayah', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Nama Ibu</label>
                                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Nama Orang Tua" value="<?= set_value('nama_ibu') ?>">
                                    <?= form_error('nama_ibu', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Nama Wali</label>
                                    <input type="text" class="form-control" id="nama_wali" name="nama_wali" placeholder="Nama Wali" value="<?= set_value('nama_wali') ?>">
                                    <small class="text-info">* Kosongkan jika tidak ada.</small>
                                </div>

                                <div class="form-group">
                                    <label>Pekerjaan Ayah</label>
                                    <select class="form-control" id="pek_ayah" name="pek_ayah" value="<?= set_value('pek_ayah') ?>">
                                        <option value="">- Pekerjaan Ayah -</option>
                                        <option value="Wiraswasta">Wiraswasta</option>
                                        <option value="Pedagang">Pedagang</option>
                                        <option value="Buruh">Buruh</option>
                                        <option value="Pensiunan">Pensiunan</option>
                                        <option value="Guru">Guru</option>
                                        <option value="Honorer">Honorer</option>
                                        <option value="PNS">PNS</option>
                                    </select>
                                    <?= form_error('pek_ayah', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Pekerjaan Ibu</label>
                                    <select class="form-control" id="pek_ibu" name="pek_ibu" value="<?= set_value('pek_ibu') ?>">
                                        <option value="">- Pekerjaan Ibu -</option>
                                        <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                        <option value="Wiraswasta">Wiraswasta</option>
                                        <option value="Pedagang">Pedagang</option>
                                        <option value="Buruh">Buruh</option>
                                        <option value="Pensiunan">Pensiunan</option>
                                        <option value="Guru">Guru</option>
                                        <option value="Honorer">Honorer</option>
                                        <option value="PNS">PNS</option>
                                        <?= form_error('pek_ibu', '<small class="text-danger pl-3">', ' </small>') ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Pekerjaan Wali</label>
                                    <select class="form-control" id="pek_wali" name="pek_wali">
                                        <option value="">- Pekerjaan Wali -</option>
                                        <option value="Tidak ada wali">Tidak ada wali</option>
                                        <option value="Wiraswasta">Wiraswasta</option>
                                        <option value="Buruh">Buruh</option>
                                        <option value="Pensiunan">Pensiunan</option>
                                        <option value="Guru">Guru</option>
                                        <option value="Honorer">Honorer</option>
                                        <option value="PNS">PNS</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Penghasilan Ortu / Wali</label>
                                    <select class="form-control" id="peng_ortu" name="peng_ortu">
                                        <option value="">- Penghasilan / Bulan -</option>
                                        <option value="< Rp.1.000.000">
                                            << Rp.1.000.000</option>
                                        <option value="Rp.1.000.000 - Rp.2.000.000">Rp.1.000.000 - Rp.2.000.000</option>
                                        <option value="Rp.2.000.000 - Rp.3.000.000">Rp.2.000.000 - Rp.3.000.000</option>
                                        <option value="Rp.3.000.000 - Rp.4.000.000">Rp.3.000.000 - Rp.4.000.000</option>
                                        <option value="Rp.4.000.000 - Rp.5.000.000">Rp.4.000.000 - Rp.5.000.000</option>
                                        <option value="Rp.5.000.000 >">
                                            Rp.5.000.000 >></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Nomor Telepon Ortu / Wali</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon" value="<?= set_value('no_telp') ?>">
                                    <?= form_error('no_telp', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Tahun Masuk</label>
                                    <select class="form-control" id="thn_msk" name="thn_msk">
                                        <option>- Pilih Periode -</option>
                                        <?php foreach ($thn_msk as $row) : ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['period_start'] ?>/<?= $row['period_end'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('thn_msk', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Sekolah Asal</label>
                                    <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" placeholder="Sekolah Asal" value="<?= set_value('sekolah_asal') ?>">
                                    <?= form_error('sekolah_asal', '<small class="text-danger pl-3">', ' </small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Kelas</label>
                                    <input type="text" class="form-control" id="old_kelas" name="old_kelas" placeholder="Kelas" value="<?= set_value('kelas') ?>">
                                    <?= form_error('old_kelas', '<small class="text-danger pl-3">', ' </small>') ?>
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
                                                        <select class="form-control" id="pendidikan" name="pendidikan">
                                                            <option>- Pilih pendidikan -</option>
                                                            <?php foreach ($pendidikan as $row) : ?>
                                                                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('pendidikan', '<small class="text-danger pl-3">', ' </small>') ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kelas</label>
                                                        <select class="form-control" id="kelas" name="kelas">
                                                            <option>- Pilih pendidikan dahulu -</option>
                                                        </select>
                                                        <?= form_error('kelas', '<small class="text-danger pl-3">', ' </small>') ?>
                                                    </div>
                                                </div>
                                                <div id="jurus" class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kejuruan</label>
                                                        <select class="form-control" id="jurusan" name="jurusan">
                                                            <option>- Pilih Jurusan -</option>
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
                                <button type="submit" class="btn-block btn btn-primary" onclick="return confirm('Lanjutkan Simpan Pendaftaran?');">Simpan Pendaftaran</button>
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
<script type="text/javascript">
    $(document).ready(function() {
        $("#jurus").hide();
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