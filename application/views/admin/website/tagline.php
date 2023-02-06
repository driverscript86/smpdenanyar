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
                                    <th scope="col">Gambar</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($tagline as $d) : ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><img src="<?= base_url("assets/img/" . $d['img']) ?>" width='50' height='50'></td>
                                        <td><?= $d['nama'] ?></td>
                                        <td><?= substr($d['deskripsi'], 0, 50) ?>..</td>
                                        <td width="20">
                                            <a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>">Edit</a>

                                        </td>
                                    </tr>

                                    <!--update Data-->
                                    <div class="modal fade bd-example-modal-lg" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Ubah Data Tagline</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('admin/tagline') ?>" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id" id="id" value="<?= $d['id'] ?>">
                                                                    <label for="">Nama Tagline</label>
                                                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $d['nama'] ?>" placeholder="Nama Tagline">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Deskripsi</label>
                                                                    <textarea type="text" rows="5" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi"><?= $d['deskripsi'] ?></textarea>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Gambar (PNG)</label>
                                                                    <input hidden type="file" name="gambar" class="file<?= $d['id'] ?>" accept="image/*" id="imgInp<?= $d['id'] ?>">
                                                                    <div class="input-group my-3">
                                                                        <input type="text" class="form-control" disabled placeholder="Pilih Gambar" id="file<?= $d['id'] ?>">
                                                                        <div class="input-group-append">
                                                                            <button type="button" class="browse<?= $d['id'] ?> btn btn-primary">Browse</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <img src="<?= base_url("assets/img/" . $d['img']) ?>" id="preview<?= $d['id'] ?>" class="img-thumbnail rounded mx-auto d-block rounded">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Ubah</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(document).on("click", ".browse<?= $d['id'] ?>", function() {
                                            var file = $(this).parents().find(".file<?= $d['id'] ?>");
                                            file.trigger("click");
                                        });


                                        $('#imgInp<?= $d['id'] ?>').change(function(e) {
                                            var fileName = e.target.files[0].name;
                                            $("#file<?= $d['id'] ?>").val(fileName);

                                            var reader = new FileReader();
                                            reader.onload = function(e) {
                                                // get loaded data and render thumbnail.
                                                document.getElementById("preview<?= $d['id'] ?>").src = e.target.result;
                                            };
                                            // read the image file as a data URL.
                                            reader.readAsDataURL(this.files[0]);
                                        });
                                    </script>

                                <?php $i++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->