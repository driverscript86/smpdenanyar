<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-cog fa-fw"></i> Setting Website</h1>
            <hr />
        </div>
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> About</h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>
                    <?php foreach ($about as $d) : ?>
                        <form action="<?= base_url('admin/about') ?>" method="post">
                            <div class="body row">
                                <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>About</label>
                                        <textarea name="about" id="editor"><?= $d['about'] ?></textarea>
                                    </div>
                                </div>
                                <br />
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Visi</label>

                                        <textarea type="text" class="form-control" style="height: 100px" id="visi" name="visi" placeholder="Visi"><?= $d['visi'] ?></textarea>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Misi</label>

                                        <textarea type="text" class="form-control" style="height: 100px" id="misi" name="misi" placeholder="Misi"><?= $d['misi'] ?></textarea>

                                    </div>
                                </div>

                            </div>
                            <div class="pt-3 form-group row">
                                <label for="staticEmail"></label>
                                <button type="submit" class="btn-block btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Gambar </h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('messageimg') ?>
                    <div class="logoset">
                        <div class="logo">
                            <?php echo form_open_multipart('update/img_about'); ?>
                            <input type="file" name="logo" id="logoUpload" style="display:none;" accept="image/x-png,image/gif,image/jpeg"></input>
                            <div class="title">Gambar</div>
                            <img style="height:200px;width:auto" id="logo" src="<?= base_url("assets/img/" . $img['img']) ?>" />
                            <div class="form-group">
                                <div style="text-align:left;" class="custom-file">
                                    <input type="hidden" name="id" value="<?= $img['id'] ?>">
                                    <input type="file" class="custom-file-input" id="gambar" name="gambar" onchange="previewImg()" value="<?= base_url("assets/img/" . $img['img']) ?>">
                                    <label class="custom-file-label" for="gambar">Pilih gambar</label>
                                </div>

                                <button type="submit" class="btn btn-info mt-3"><i class="fas fa-sync"></i> Ganti Logo</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script src="<?= base_url('assets/'); ?>js/ckeditor/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });
</script>

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
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('editor', {
            height: 300,
        });
    });
</script>