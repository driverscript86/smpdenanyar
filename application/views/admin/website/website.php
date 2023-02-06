<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->



    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-cog fa-fw"></i> Setting Website</h1>
            <hr />
        </div>
        <div class="col-lg-6" id="accordion">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Edit website</h6>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div id="headingOne">
                            <button type="button" class="btn btn-light btn-block" data-toggle="collapse" data-target="#collWeb" aria-expanded="false" aria-controls="collWeb">Website</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="headingTwo">
                            <button type="button" class="btn btn-light btn-block" data-toggle="collapse" data-target="#collSosmed" aria-expanded="false" aria-controls="collSosmed">Link Sosmed</button>
                        </div>
                    </div>
                </div>

                <div id="collWeb" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                        <?= $this->session->flashdata('message') ?>
                        <?php foreach ($website as $d) : ?>
                            <form action="<?= base_url('admin/website') ?>" method="post">
                                <div class="body">
                                    <div class="form-group row">
                                        <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">
                                        <label for="staticEmail">Nama Website</label>

                                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $d['nama'] ?>" placeholder="Nama Lengkap">

                                    </div>

                                    <div class="form-group row">
                                        <label for="staticEmail">Email</label>

                                        <input type="text" class="form-control" id="email" name="email" value="<?= $d['email'] ?>" placeholder="Email">

                                    </div>

                                    <div class="form-group row">
                                        <label for="staticEmail">No Telepon</label>

                                        <input type="number" class="form-control" id="no_telp" name="no_telp" value="<?= $d['telp'] ?>" placeholder="Nomor Telepon">

                                    </div>

                                    <div class="form-group row">
                                        <label for="staticEmail">Meta Deskripsi</label>

                                        <textarea type="text" class="form-control" style="height: 100px" id="deskripsi" name="deskripsi" placeholder="Deskripsi"><?= $d['deskripsi'] ?></textarea>

                                    </div>

                                    <div class="form-group row">
                                        <label for="staticEmail">Alamat</label>

                                        <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"><?= $d['alamat'] ?></textarea>

                                    </div>
                                </div>
                                <div class="pt-3 form-group row">
                                    <label for="staticEmail"></label>
                                    <button type="submit" class="btn-block btn btn-primary">Simpan</button>
                                </div>
                            </form>
                    </div>
                </div>

                <div id="collSosmed" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                        <?= $this->session->flashdata('message') ?>
                        <form action="<?= base_url('update/link_sosmed') ?>" method="post">
                            <div class="body">
                                <div class="form-group row">
                                    <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">
                                    <label for="staticEmail">Link Facebook</label>
                                    <input type="text" class="form-control" id="link_fb" name="link_fb" value="<?= $d['link_fb'] ?>" placeholder="Link Facebook">
                                </div>

                                <div class="form-group row">
                                    <label for="staticEmail">Link Instagram</label>
                                    <input type="text" class="form-control" id="link_ig" name="link_ig" value="<?= $d['link_ig'] ?>" placeholder="Link Instagram">
                                </div>

                                <div class="form-group row">
                                    <label for="staticEmail">Link Twitter</label>
                                    <input type="text" class="form-control" id="link_tw" name="link_tw" value="<?= $d['link_tw'] ?>" placeholder="Link Twitter">
                                </div>

                            </div>
                            <div class="pt-3 form-group row">
                                <label for="staticEmail"></label>
                                <button type="submit" class="btn-block btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Edit G-maps</h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('messageMaps') ?>
                    <form action="<?= base_url('admin/maps') ?>" method="post">
                        <div class="form-group row">
                            <label for="staticEmail">Link G-maps</label>
                            <textarea type="text" class="form-control" style="height: 100px" id="maps" name="maps" placeholder="maps"><?= $d['maps'] ?></textarea>
                        </div>

                        <div class="form-group row">
                            <?= $web['maps'] ?>
                        </div>

                        <div class="pt-3 form-group row">
                            <label for="staticEmail"></label>
                            <button type="submit" class="btn-block btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>


        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Gambar website</h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('messagelogo') ?>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="logoset">
                                <div class="logo">
                                    <?php echo form_open_multipart('update/Logo'); ?>
                                    <input type="file" name="logo" id="logoUpload" style="display:none;" accept="image/x-png,image/gif,image/jpeg"></input>
                                    <div class="title">Logo</div>
                                    <img style="height:70px;" id="logo" src="<?= base_url("assets/img/" . $d['logo']) ?>" />
                                    <div class="form-group">
                                        <div style="text-align:left;" class="custom-file">
                                            <input type="file" class="custom-file-input" id="gambar" name="gambar" onchange="previewImg()" value="<?= base_url("assets/img/" . $d['logo']) ?>">
                                            <label class="custom-file-label" for="gambar">Pilih gambar</label>
                                        </div>
                                        <button type="submit" class="btn btn-info mt-3"><i class="fas fa-sync"></i> Ganti Logo</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="logoset">
                                <div class="favicon">
                                    <?php echo form_open_multipart('update/LogoFav'); ?>
                                    <input type="file" name="logo" id="logoUpload" style="display:none;" accept="image/x-png,image/gif,image/jpeg"></input>
                                    <div class="title">Logo Favicon</div>
                                    <img style="height:70px;" id="logo" src="<?= base_url("assets/img/" . $d['fav']) ?>" />
                                    <div class="form-group">
                                        <div style="text-align:left;" class="custom-file">
                                            <input type="file" class="custom-file-input" id="fav" name="fav" onchange="previewFav()" value="<?= base_url("assets/img/" . $d['fav']) ?>">
                                            <label class="favic custom-file-label" for="fav">Pilih gambar</label>
                                        </div>
                                        <button type="submit" class="btn btn-info mt-3"><i class="fas fa-sync"></i> Ganti Favicon</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="logoset">
                                <div class="logo">
                                    <?php echo form_open_multipart('update/imgUser'); ?>
                                    <input type="file" name="logo" id="logoUpload" style="display:none;" accept="image/x-png,image/gif,image/jpeg"></input>
                                    <div class="title">Login User</div>
                                    <img style="height:70px;" width="80%" id="logo" src="<?= base_url("assets/img/" . $d['img_login']) ?>" />
                                    <div class="form-group">
                                        <div style="text-align:left;" class="custom-file">
                                            <input type="file" class="custom-file-input" id="imgUser" name="imgUser" onchange="previewUser()" value="<?= base_url("assets/img/" . $d['img_login']) ?>">
                                            <label class="imgUser custom-file-label" for="imgUser">Pilih gambar</label>
                                        </div>
                                        <button type="submit" class="btn btn-info mt-3"><i class="fas fa-sync"></i> Ganti Gambar</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="logoset">
                                <div class="logo">
                                    <?php echo form_open_multipart('update/imgAdmin'); ?>
                                    <input type="file" name="logo" id="logoUpload" style="display:none;" accept="image/x-png,image/gif,image/jpeg"></input>
                                    <div class="title">Login Admin</div>
                                    <img style="height:70px;" width="80%" id="logo" src="<?= base_url("assets/img/" . $d['img_login_admin']) ?>" />
                                    <div class="form-group">
                                        <div style="text-align:left;" class="custom-file">
                                            <input type="file" class="custom-file-input" id="imgAdmin" name="imgAdmin" onchange="previewAdmin()" value="<?= base_url("assets/img/" . $d['img_login_admin']) ?>">
                                            <label class="imgAdmin custom-file-label" for="imgAdmin">Pilih gambar</label>
                                        </div>
                                        <button type="submit" class="btn btn-info mt-3"><i class="fas fa-sync"></i> Ganti Gambar</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php endforeach ?>
<script type="text/javascript">
    function previewImg() {

        const gambar = document.querySelector('#gambar');
        const gambarLabel = document.querySelector('.custom-file-label');

        gambarLabel.textContent = gambar.files[0].name;

        const fileGambar = new FileReader();
        fileGambar.readAsDataURL(gambar.file[0]);

        fileGambar.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }

    function previewFav() {

        const foot = document.querySelector('#fav');
        const footLabel = document.querySelector('.favic');

        footLabel.textContent = foot.files[0].name;

        const fileFoot = new FileReader();
        fileFoot.readAsDataURL(foot.file[0]);

        fileFoot.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }

    function previewUser() {

        const fav = document.querySelector('#imgUser');
        const favLabel = document.querySelector('.imgUser');

        favLabel.textContent = fav.files[0].name;

        const fileFav = new FileReader();
        fileFav.readAsDataURL(fav.file[0]);

        fileFav.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }

    function previewAdmin() {

        const fav = document.querySelector('#imgAdmin');
        const favLabel = document.querySelector('.imgAdmin');

        favLabel.textContent = fav.files[0].name;

        const fileFav = new FileReader();
        fileFav.readAsDataURL(fav.file[0]);

        fileFav.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>