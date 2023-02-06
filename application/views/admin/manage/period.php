<?php
	$inputStartValue = set_value('period_start');
	$inputEndValue = set_value('period_end');
	$inputStatusValue = set_value('period_status');
?>

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
                                    <th scope="col">Periode</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($period as $d) : ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $d['period_start'] .'/'.$d['period_end'] ?></td>
                                        <td><?= ($d['period_status'] == 1) ? 'Aktif' : 'Tidak Aktif' ?></td>
                                        <td>
                                            <a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $d['id'] ?>">Edit</a>
                                            <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $d['id'] ?>">Hapus</a>

                                        </td>
                                    </tr>
                                    <!--update Data-->
                                    <div class="modal fade" id="updateData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Update Data Periode</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('update/update_periode') ?>" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" value="<?= $d['id'] ?>" name="id">
                                                    <div class="form-group">
                                                        <label>Tahun Pelajaran *</label>
                                                        <div class="row">
                                                            <div class="col-sm-6 col-md-6">
                                                                <input type="text" name="period_start" value="<?= $d['period_start'] ?>" class="form-control" onchange="getYear<?= $d['id'] ?>(this.value)" placeholder="Tahun Awal">
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <input type="text" class="form-control" readonly="" name="period_end" id="YearEnd<?= $d['id'] ?>" value="<?= $inputEndValue ?>" placeholder="Tahun Akhir">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="">- Status -</option>
                                                            <option <?php if ($d['period_status'] == 1) {
                                                                        echo "selected='selected'";
                                                                    } ?> value="1">Aktif</option>
                                                            <option <?php if ($d['period_status'] == 0) {
                                                                        echo "selected='selected'";
                                                                    } ?> value="0">Tidak Aktif</option>
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
                                    <div class="modal fade" id="deleteData<?= $d['id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNewDataLabel">Hapus Data Periode</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus data <b><?= $d['period_start'] .'/'.$d['period_end'] ?></b></p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('hapus/hapus_periode?id=') ?><?= $d['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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

<!-- Modal -->
<div class="modal fade" id="addNewData" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewDataLabel">Tambah Data Periode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('manage/period') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tahun Pelajaran *</label>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <input type="text" name="period_start" class="form-control" onchange="getYear(this.value)" placeholder="Tahun Awal">
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <input type="text" class="form-control" readonly="" name="period_end" id="YearEnd" value="<?php echo $inputEndValue ?>" placeholder="Tahun Akhir">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">- Status -</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
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

<script>
	function getYear(value) {

		var yearsend = parseInt(value) + 1;

		$("#YearEnd").val(yearsend);

	}
    <?php foreach ($period as $d) : ?> 
        function getYear<?= $d['id'] ?>(value) {

        var yearsend = parseInt(value) + 1;

        $("#YearEnd<?= $d['id'] ?>").val(yearsend);

        }
    <?php endforeach ?>
</script>