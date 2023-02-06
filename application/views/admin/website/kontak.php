<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?>
                    </h1>
                    <?= $this->session->flashdata('message') ?>
                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Subjek</th>
                                    <th scope="col">Pesan</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($kontak as $d) : ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $d['nama'] ?>
                                            <?php if ($d['status'] == 3) : ?>
                                                <span class="badge badge-success badge-pill disabled float-right">
                                                    <i class="fas fa-paper-plane"></i>
                                                </span>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $d['email'] ?></td>
                                        <td><?= $d['subjek'] ?></td>
                                        <td><?= substr($d['pesan'], 0, 50) ?>..</td>
                                        <td><?= mediumdate_indo(date($d['tgl'])) ?></td>
                                        <td weidth="20">
                                            <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#viewData<?= $d['id'] ?>">View</a>
                                            <a href="#" class="badge badge-success" data-dismiss="modal" data-toggle="modal" data-target="#balasData<?= $d['id'] ?>">Balas</a>
                                            <a href="#" class="badge badge-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>">Hapus</a>
                                        </td>
                                    </tr>
                                <?php $i++;
                                endforeach ?>
                            </tbody>
                        </table>

                        <?php foreach ($kontak as $d) : ?>
                            <!--Proses Data-->
                            <div class="modal fade" id="viewData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addNewDataLabel"><?= $d['nama'] ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h4><?= $d['email'] ?>
                                            </h4>
                                            <br />
                                            <p>
                                                <b>Subjek : <?= $d['subjek'] ?></b> <br>
                                            </p>
                                            Pesan :
                                            <div class="alert alert-dark" role="alert">
                                                <?= $d['pesan'] ?>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#balasData<?= $d['id'] ?>">Balas</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--Proses Data-->


                            <div class="modal fade" id="balasData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                <div class="modal-dialog  modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addNewDataLabel">Balas Kontak</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?= base_url('admin/balas_kontak') ?>" method="post">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="email">Email Penerima</label>
                                                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                    <input type="text" class="form-control" value="<?= $d['email'] ?>" disabled>
                                                    <input type="hidden" name="email" value="<?= $d['email'] ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="subjek">Subjek</label>
                                                    <input type="text" class="form-control" value="<?= $d['subjek'] ?>" disabled>
                                                    <input type="hidden" name="subjek" value="<?= $d['subjek'] ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="pesan">Pesan</label>
                                                    <textarea name="pesan" id="editor"><?= set_value('pesan') ?></textarea>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#balasData<?= $d['id'] ?>"><i class="fas fa-paper-plane"></i> Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!--delete Data-->
                            <div class="modal fade" id="deleteData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addNewDataLabel">Hapus Kontak</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Anda yakin ingin menghapus data <b><?= $d['nama'] ?></b></p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <a href="<?= base_url('hapus/hapus_kontak?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


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