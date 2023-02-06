<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?>
                        <div class="float-right">
                            <a href="" class="btn btn-block btn-sm btn-info" data-toggle="modal" data-target="#addNewData"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                        </div>
                    </h1>
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
                    <?= $this->session->flashdata('message') ?>
                    <div style="width:100%; overflow-x:scroll">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tanggal Pemasukan</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Pemasukan (Rp.)</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($debit as $d) : ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= mediumdate_indo(date($d['debit_date'])) ?></td>
                                        <td><?= $d['debit_desc'] ?></td>
                                        <td><?= 'Rp. ' . number_format($d['debit_value'], 0, ',', '.') ?></td>
                                        <td>
                                            <a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $d['debit_id'] ?>">Edit</a>
                                            <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['debit_id'] ?>">Hapus</a>

                                        </td>
                                    </tr>
                                    <!--update Data-->
                                    <div class="modal fade" id="updateData<?= $d['debit_id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Update Pemasukan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/edit_masukan') ?>" method="post">
                                                    <input type="hidden" name="id" id="id" value="<?= $d['debit_id'] ?>">
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label>Tanggal Pemasukan</label>
                                                            <input type="date" class="form-control" id="debit_date" name="debit_date" value="<?= $d['debit_date'] ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Keterangan</label>
                                                            <textarea type="text" class="form-control" id="debit_desc" name="debit_desc" placeholder="Keterangan"><?= $d['debit_desc'] ?></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="debit_value">Jumlah Pemasukan</label>
                                                            <input type="number" class="form-control" id="debit_value" name="debit_value" placeholder="Juamlah Pemasukan" value="<?= $d['debit_value'] ?>">
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--delete Data-->
                                    <div class="modal fade" id="deleteData<?= $d['debit_id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus Pemasukan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus Pemasukan <br>Tanggal : <b><?= mediumdate_indo(date($d['debit_date'])) ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/masukan?id=') ?><?= $d['debit_id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
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

<!--modal-->
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Tambah Pemasukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('manage/add_masukan') ?>" method="post">
                <input type="hidden" id="uid" name="uid" value="<?= $user['id'] ?>">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Tanggal Pemasukan</label>
                        <input type="date" class="form-control" id="debit_date" name="debit_date">
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea type="text" class="form-control" id="debit_desc" name="debit_desc" placeholder="Keterangan"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Jumah Pemasukan</label>
                        <input type="number" class="form-control" id="debit_value" name="debit_value" placeholder="Jumlah Pemasukan">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            ajax: {
                url: "<?= base_url('get/getTakzir') ?>",
                dataType: "json",
                type: "post",
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                    }
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Cari data Pelanggaran',
            minimumInputLength: 3,
        });

    });
</script>