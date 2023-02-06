<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="card card-primary">
        <div class="card-header">
            <h6 class="card-title"><i class="fas fa-newspaper"></i> Tambah Gallery
                <div class="float-right">
                    <a href="<?= base_url('admin/gallery') ?>" class="btn btn-block btn-sm btn-primary"><i class="fa fa-arrow-left"></i> Data Gallery</a>
                </div>
            </h6>
        </div>

        <?= form_open_multipart('admin/tambah_gallery'); ?>
        <div class="card-body">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '
          </div>') ?>
            <?= $this->session->flashdata('message') ?>

            <div class="row">
                <form action="<?= base_url('admin/tagline') ?>" method="post" enctype="multipart/form-data">
                    <div class="col-lg-8 col-md-8">
                        <div class="form-group">
                            <label>Nama Gallery</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= set_value('nama') ?>">
                        </div>
                        <div class="form-group ck-editor__editable_inline">
                            <label>Deskripsi</label>
                            <textarea name="isi" id="editor"><?= set_value('isi') ?></textarea>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>Kategori Gallery <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#addKat"> Tambah</a></label>

                            <select class="form-control" id="kategori" name="kategori">
                                <option>- Pilih Kategori -</option>
                                <?php foreach ($kategori as $kat) : ?>
                                    <option value="<?= $kat['id'] ?>"><?= $kat['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="">Foto Gallery</label>
                            </div>
                            <div class="col-sm-3">
                                <img src="" width="100" height="85" id="preview" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9">
                                <input hidden type="file" name="gambar" class="file" accept="image/*" id="imgInp">
                                <div class="input-group my-3">
                                    <input type="text" class="form-control" disabled placeholder="Gambar 1 (Utama)" id="file">
                                    <div class="input-group-append">
                                        <button type="button" class="browse btn btn-primary">Browse</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3">
                                <img src="" width="100" height="85" id="preview1" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9">
                                <input hidden type="file" name="gambar1" class="file1" accept="image/*" id="imgInp1">
                                <div class="input-group my-3">
                                    <input type="text" class="form-control" disabled placeholder="Gambar 2" id="file1">
                                    <div class="input-group-append">
                                        <button type="button" class="browse1 btn btn-primary">Browse</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3">
                                <img src="" width="100" height="85" id="preview2" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9">
                                <input hidden type="file" name="gambar2" class="file2" accept="image/*" id="imgInp2">
                                <div class="input-group my-3">
                                    <input type="text" class="form-control" disabled placeholder="Gambar 3" id="file2">
                                    <div class="input-group-append">
                                        <button type="button" class="browse2 btn btn-primary">Browse</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3">
                                <img src="" width="100" height="85" id="preview3" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9">
                                <input hidden type="file" name="gambar3" class="file3" accept="image/*" id="imgInp3">
                                <div class="input-group my-3">
                                    <input type="text" class="form-control" disabled placeholder="Gambar 4" id="file3">
                                    <div class="input-group-append">
                                        <button type="button" class="browse3 btn btn-primary">Browse</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-primary" onclick="return confirm('Lanjutkan Simpan Gallery?');"><i class="fa fa-check"></i> Simpan Gallery</button>
            <a href="<?= base_url('admin/gallery') ?>" class="btn btn-dark">Kembali</a>
        </div>
        <?php form_close(); ?>
        </form>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="addKat" role="dialog" aria-labelledby="addKatLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKatLabel">Tambah Kategori Gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/kategori_gallery/tambah') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Kategori Gallery</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Kategori Gallery">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" value="kategori" class="btn btn-primary">Tambah</button>
                </div>
            </form>
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