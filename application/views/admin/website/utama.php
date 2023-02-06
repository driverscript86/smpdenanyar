<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-cog fa-fw"></i> Utama</h1>
            <hr />
        </div>
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Update Home</h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>
                    <?= $this->session->flashdata('messageGambar') ?>
                    <div class="row">

                        <?php foreach ($home as $d) : ?>
                            <div class="col-md-6">
                                <form action="<?= base_url('admin/utama') ?>" method="post">
                                    <div class="body">
                                        <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">

                                        <div class="form-group row">
                                            <label>Judul</label>
                                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul" value="<?= $d['judul'] ?>" />
                                        </div>

                                        <div class="form-group row">
                                            <label>Isi</label>
                                            <textarea type="text" class="form-control" style="height: 100px" id="isi" name="isi" placeholder="Isi"><?= $d['isi'] ?></textarea>
                                        </div>

                                        <div class="form-group row">
                                            <label>Tombol</label>
                                            <input type="text" class="form-control" id="tombol" name="tombol" placeholder="Tombol" value="<?= $d['tombol'] ?>" />
                                        </div>

                                        <div class="form-group row">
                                            <label>Link</label>
                                            <input type="text" class="form-control" id="link" name="link" placeholder="Link" value="<?= $d['link'] ?>" />
                                        </div>

                                    </div>

                                    <div class="pt-3 form-group row">
                                        <label></label>
                                        <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        <?php endforeach ?>

                        <div class="col-md-6">
                            <div class="card shadow mb-4">

                                <div class="card-body">
                                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                                    <?= $this->session->flashdata('messageimg') ?>
                                    <div class="logoset">
                                        <div class="logo">
                                            <?php echo form_open_multipart('update/gambar_utama'); ?>
                                            <input type="file" name="logo" id="logoUpload" style="display:none;" accept="image/x-png,image/gif,image/jpeg"></input>
                                            <div class="title">Gambar</div>
                                            <img style="height:200px;width:auto" id="logo" src="<?= base_url("assets/img/" . $img['img']) ?>" />
                                            <div class="form-group">
                                                <div style="text-align:left;" class="custom-file">
                                                    <input type="file" class="custom-file-input" id="gambar" name="gambar" onchange="previewImg()" value="<?= base_url("assets/img/" . $img['img']) ?>">
                                                    <label class="custom-file-label" for="gambar">Pilih gambar</label>
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
    </div>
</div>

</div>
<!-- End of Main Content -->
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
</script>