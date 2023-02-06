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
                                    <th scope="col">Nama Pembayaran</th>
                                    <th scope="col">Jenis Pembayaran</th>
                                    <th scope="col">Tipe</th>
                                    <th scope="col">Tahun</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($pembayaran as $d) : ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $d['pos_name'] ?></td>
                                        <td><?= $d['pos_name'] . ' - T.P ' . $d['period_start'] . '/' . $d['period_end']; ?></td>
                                        <td><?= ($d['payment_type'] == 'BULAN') ? 'Bulanan' : 'Bebas' ?></td>
                                        <td><?= $d['period_start'] . '/' . $d['period_end']; ?></td>
                                        <td>
                                        <?php if ($d['payment_type'] == 'BULAN') { ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Ubah" class="badge badge-primary" href="<?= site_url('manage/jenis_pembayaran/view_bulan/' . $d['payment_id']) ?>">
                                                Atur Tarif Pembayaran
                                            </a>
                                        <?php } else { ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Ubah" class="badge badge-primary" href="<?= site_url('manage/jenis_pembayaran/view_bebas/' . $d['payment_id']) ?>">
                                                Atur Tarif Pembayaran
                                            </a>
                                        <?php } ?>
                                            <a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $d['payment_id'] ?>">Edit</a>
                                            <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['payment_id'] ?>">Hapus</a>
                                        </td>
                                    </tr>
                                    <!--update Data-->
                                    <div class="modal fade" id="updateData<?= $d['payment_id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Update Pembayaran</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('manage/jenis_pembayaran/add') ?>" method="post">
                                                    <input type="hidden" name="payment_id" value="<?= $d['payment_id'] ?>">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="payment_id" value="<?= $d['payment_id']; ?>">
                                                        <div class="form-group">
                                                            <label>Nama Pembayaran <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                                                            <select name="pos_id" class="form-control">
                                                                <option value="">-Pilih Nama Pembayaran-</option>
                                                                <?php foreach ($pos as $row) : ?>
                                                                    <option value="<?= $row['pos_id']; ?>" <?= ($d['pos_pos_id'] == $row['pos_id']) ? 'selected' : '' ?>><?= $row['pos_name']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Tahun Pelajaran <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                                                            <select name="period_id" class="form-control">
                                                                <option value="">-Pilih Tahun-</option>
                                                                <?php foreach ($period as $row) : ?>
                                                                    <option value="<?= $row['id']; ?>" <?= ($d['period_period_id'] == $row['id']) ? 'selected' : '' ?>><?= $row['period_start'] . '/' . $row['period_end']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Tipe <small data-toggle="tooltip" title="Wajib diisi">*</small></label><br>
                                                            <select name="payment_type" class="form-control" required="">
                                                                <option value="">-Pilih Tipe-</option>
                                                                <option value="BULAN" <?= ($d['payment_type'] == 'BULAN') ? 'selected' : '' ?>>Bulanan</option>
                                                                <option value="BEBAS" <?= ($d['payment_type'] == 'BEBAS') ? 'selected' : '' ?>>Bebas</option>
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
                                    <div class="modal fade" id="deleteData<?= $d['payment_id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus <?= $title ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus <?= $title ?> : <b><?= $d['pos_name'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/jenis_pembayaran/'.$d['payment_type'].'?id=') ?><?= $d['payment_id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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
                <h5 class="modal-title" id="addNewDataLabel">Tambah <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('manage/jenis_pembayaran/add') ?>" method="post">
                <div class="modal-body">
						<div class="form-group">
							<label>Nama Pembayaran <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select name="pos_id" class="form-control">
								<option value="">-Pilih Nama Pembayaran-</option>
								<?php foreach ($pos as $row) : ?>
									<option value="<?= $row['pos_id']; ?>"><?= $row['pos_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
							<label>Tahun Pelajaran <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select name="period_id" class="form-control">
								<option value="">-Pilih Tahun-</option>
								<?php foreach ($period as $row) : ?>
									<option value="<?= $row['id']; ?>"><?= $row['period_start'] . '/' . $row['period_end']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
							<label>Tipe <small data-toggle="tooltip" title="Wajib diisi">*</small></label><br>
							<select name="payment_type" class="form-control" required="">
								<option value="">-Pilih Tipe-</option>
								<option value="BULAN">Bulanan</option>
								<option value="BEBAS">Bebas</option>
							</select>
						</div>

						<p class="text-muted">*) Kolom wajib diisi.</p>

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