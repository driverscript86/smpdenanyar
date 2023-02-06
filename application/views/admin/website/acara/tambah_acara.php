<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="card card-primary">
        <div class="card-header">
            <h6 class="card-title"><i class="fas fa-newspaper"></i> Tambah Acara
                <div class="float-right">
                    <a href="<?= base_url('admin/acara') ?>" class="btn btn-block btn-sm btn-primary"><i class="fa fa-arrow-left"></i> Data Acara</a>
                </div>
            </h6>
        </div>

        <form method="post" action="<?= base_url('admin/tambah_acara') ?>" enctype="multipart/form-data">

            <div class="card-body">
                <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '
          </div>') ?>
                <?= $this->session->flashdata('message') ?>

                <div class="row">
                    <form action="<?= base_url('admin/tagline') ?>" method="post" enctype="multipart/form-data">
                        <div class="col-lg-8 col-md-8">
                            <div class="form-group">
                                <label>Judul Acara</label>
                                <input type="text" class="form-control" id="judul" name="judul" value="<?= set_value('judul') ?>">
                            </div>
                            <div class="form-group ck-editor__editable_inline">
                                <label>Isi Acara</label>
                                <textarea name="isi" id="editor"><?= set_value('isi') ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label>Kategori Acara <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#addKat"> Tambah</a></label>

                                <select class="form-control" id="kategori" name="kategori">
                                    <option>- Pilih Kategori -</option>
                                    <?php foreach ($kategori as $kat) : ?>
                                        <option value="<?= $kat['id'] ?>"><?= $kat['nama'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="">Foto Acara</label>
                                </div>
                                <div class="col-sm-3">
                                    <img src="" width="100" height="85" id="preview" class="img-thumbnail">
                                </div>
                                <div class="col-sm-9">
                                    <input hidden type="file" name="gambar" class="file" accept="image/*">
                                    <div class="input-group my-3">
                                        <input type="text" class="form-control" disabled placeholder="Pilih Gambar" id="file">
                                        <div class="input-group-append">
                                            <button type="button" class="browse btn btn-primary">Browse</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tempat Acara</label>
                                <textarea name="tempat" class="form-control" id="tempat" value="<?= set_value('tempat') ?>"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Acara</label>
                                <div class="input-group">
                                    <input class="form-control" type="date" id="tgl" name="tgl" value="<?= set_value('tgl') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jam Mulai (contoh 14:45 - 15:45)</label>
                                <input type="text" class="form-control" name="jam" id="jam" value="<?= set_value('jam') ?>">
                            </div>

                        </div>

                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary" onclick="return confirm('Lanjutkan Simpan Acara?');"><i class="fa fa-check"></i> Simpan Acara</button>
                <a href="<?= base_url('admin/acara') ?>" class="btn btn-dark">Kembali</a>
            </div>
        </form>
        </form>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="addKat" role="dialog" aria-labelledby="addKatLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKatLabel">Tambah Kategori Acara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/kategori_acara/tambah') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Kategori Acara</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Kategori Acara">
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
    $('input[type="file"]').change(function(e) {
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
</script>