<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-cog fa-fw"></i> WA Gateway</h1>
            <hr />
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Update WA Gateway</h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>

                    <?php foreach ($wa_gateway as $d) : ?>

                        <form action="<?= base_url('admin/wa_gateway') ?>" method="post">
                        <input type="hidden" id="id" name="id" value="<?= $d['id']; ?>">
                            <div class="form-group">
                                <label for="url">Url Gate</label>
                                <input type="text" class="form-control" id="url" name="url" value="<?= $d['url']; ?>">
                                <?= form_error('url', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="api_key">Api Key</label>
                                <input type="text" class="form-control" id="api_key" name="api_key" value="<?= $d['api_key']; ?>">
                                <?= form_error('api_key', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Nomor Sender</label>
                                <input type="number" class="form-control" name="no_sender" value="<?= $d['no_sender']; ?>">
                                <small>Contoh : 6285123456789</small>
                            </div>

                            <button type="submit" class="btn btn-primary btn-rd5">Submit</button>
                        </form>

                    <?php endforeach ?>

                </div>
            </div>
        </div>

        
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-cogs fa-fw"></i> Test WA Gateway</h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('messageTest') ?>
                    <form action="<?= base_url('admin/test_wa_gate') ?>" method="post">
                        <div class="body">

                            <div class="form-group">
                                <label>Nomor Penerima</label>
                                <input type="number" class="form-control" id="nomor" name="nomor" placeholder="Nomor Penerima" value="<?= set_value('nomor') ?>" />
                            </div>

                            <div class="form-group">
                                <label for="pesan">Isi Pesan</label>
                                <textarea name="pesan" class="form-control" rows="3" placeholder="Isi Pesan"><?= set_value('pesan') ?></textarea>
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
<!-- End of Main Content -->