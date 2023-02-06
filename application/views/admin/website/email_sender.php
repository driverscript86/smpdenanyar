<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-cog fa-fw"></i> Email Sender</h1>
            <hr />
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Update Email Sender</h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>
                    <?= $this->session->flashdata('messageGambar') ?>

                    <?php foreach ($email_sender as $d) : ?>

                        <form action="<?= base_url('admin/email_sender') ?>" method="post">
                            <div class="body">
                                <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">

                                <div class="form-group row">
                                    <label>Protocol</label>
                                    <input type="text" class="form-control" id="protocol" name="protocol" placeholder="Protocol" value="<?= $d['protocol'] ?>" />
                                </div>

                                <div class="form-group row">
                                    <label>Host</label>
                                    <input type="text" class="form-control" id="host" name="host" placeholder="Host" value="<?= $d['host'] ?>" />
                                </div>

                                <div class="form-group row">
                                    <label>Port</label>
                                    <input type="text" class="form-control" id="port" name="port" placeholder="Port" value="<?= $d['port'] ?>" />
                                </div>

                                <div class="form-group row">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= $d['email'] ?>" />
                                </div>

                                <div class="form-group row">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?= $d['password'] ?>" />
                                </div>

                                <div class="form-group row">
                                    <label>Charset</label>
                                    <input type="text" class="form-control" id="charset" name="charset" placeholder="Charset" value="<?= $d['charset'] ?>" />
                                </div>

                            </div>

                            <div class="pt-3 form-group row">
                                <label></label>
                                <button onclick="return confirm('Lanjutkan Simpan Data?');" type="submit" class="btn btn-block btn-primary">Simpan</button>
                            </div>
                        </form>

                    <?php endforeach ?>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Test Email Sender</h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('messageTest') ?>
                    <form action="<?= base_url('admin/test_email_sender') ?>" method="post">
                        <div class="body">

                            <div class="form-group">
                                <label>Email Penerima</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= set_value('email') ?>" />
                            </div>

                            <div class="form-group">
                                <label>Subjek</label>
                                <input type="text" class="form-control" id="subjek" name="subjek" placeholder="Subjek" value="<?= set_value('subjek') ?>" />
                            </div>

                            <div class="form-group">
                                <label for="pesan">Isi Pesan</label>
                                <textarea name="pesan" id="editor"><?= set_value('pesan') ?></textarea>
                            </div>

                        </div>

                        <div class="pt-3 form-group">
                            <label></label>
                            <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
                        </div>
                    </form>
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