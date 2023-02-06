<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        <div class="float-right mr-1">
            <a href="<?= base_url('admin/acara') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa fa-arrow-left"></i> Data Acara</a>
        </div>
    </div>
    <?php foreach ($acara as $a) : ?>

        <div class="card card-primary">
            <div class="card-header">
                <h6 class="card-title"><i class="fas fa-newspaper"></i> Edit Acara
                    <div class="float-right">
                        <a target="_blank" href="<?= base_url('detail_acara?id=' . $a['id']) ?>" class="btn btn-block btn-sm btn-primary"><i class="fa fas fa-external-link-alt"></i> Detail Acara</a>
                    </div>
                </h6>
            </div>

            <form method="post" action="<?= base_url('admin/edit_acara') ?>" enctype="multipart/form-data">

                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '
                                   </div>') ?>
                    <?= $this->session->flashdata('message') ?>

                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <div class="form-group">
                                <label>Judul Acara</label>
                                <input type="hidden" name="id" id="id" value="<?= $a['id'] ?>">
                                <input type="text" class="form-control" name="judul" value="<?= $a['judul'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Isi Acara</label>
                                <textarea name="isi" id="editor"><?= $a['deskripsi'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label>Kategori Acara <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#addKat"> Tambah</a></label>

                                <select class="form-control" id="kategori" name="kategori">
                                    <?php foreach ($kategori as $kat) : ?>
                                        <option <?php if ($a['id_kat'] == $kat['id']) {
                                                    echo "selected='selected'";
                                                } ?> value="<?= $kat['id'] ?>"><?= $kat['nama'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="">Foto Acara</label>
                                </div>
                                <div class="col-sm-3">

                                    <img src="<?= base_url("assets/img/blog/" . $a['img']) ?>" width="100" height="85" id="preview" class="img-thumbnail">

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
                                <textarea name="tempat" class="form-control"><?= $a['tempat'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Acara</label>
                                <div class="input-group">
                                    <input class="form-control" type="date" id="tgl" name="tgl" value="<?= $a['tgl'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jam Mulai (contoh 14:45 - 15:45)</label>
                                <input type="text" class="form-control" name="jam" value="<?= $a['jam'] ?>">
                            </div>

                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-primary" onclick="return confirm('Lanjutkan Simpan Acara?');"><i class="fa fa-check"></i> Simpan Acara</button>
                    <a href="<?= base_url('admin/acara') ?>" class="btn btn-dark">Kembali</a>
                </div>
            </form>
        </div>
    <?php endforeach ?>
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
            <form action="<?= base_url('admin/kategori_acara/edit/' . $this->input->get('id')) ?>" method="post">
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