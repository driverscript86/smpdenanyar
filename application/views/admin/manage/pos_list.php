<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?>
                        <div class="float-right">
                            <a href="" class="btn btn-block btn-sm btn-info" data-toggle="modal" data-target="#addPos"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                        </div>
                    </h1>
					<?= $this->session->flashdata('message') ?>
					<!-- /.box-header -->
					<div class="box-body table-responsive">
						<table class="table table-hover" id="mytable">
							<tr>
								<th>No</th>
								<th>Nama Pembayaran</th>
								<th>Keterangan</th>
								<th>Aksi</th>
							</tr>
							<tbody>
								<?php
								if (!empty($pos)) {
									$i = 1;
									foreach ($pos as $row) :
								?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['pos_name']; ?></td>
											<td><?php echo $row['pos_description']; ?></td>
											<td>
											<a href="#" class="badge badge-success" data-toggle="modal" data-target="#updateData<?= $row['pos_id'] ?>">Edit</a>
                                            <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteData<?= $row['pos_id'] ?>">Hapus</a>
											</td>
										</tr>
									<?php
									endforeach;
								} else {
									?>
									<tr id="row">
										<td colspan="4" align="center">Data Kosong</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
				<!-- /.box -->
	</div>
</div>
<?php foreach ($pos as $d) : ?>
 <!--update Data-->
 <div class="modal fade" id="updateData<?= $d['pos_id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addNewDataLabel">Ubah <?= $title ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('manage/add_pos') ?>" method="post">
			<input type="hidden" name="pos_id" value="<?= $d['pos_id'] ?>">
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Pembayaran</label>
						<input type="text" required="" name="pos_name" class="form-control" placeholder="Contoh: SPP" value="<?= $d['pos_name'] ?>">
					</div>
					<div class="form-group">
						<label>Keterangan</label>
						<input type="text" required="" name="pos_description" class="form-control" placeholder="Contoh: Sumbangan Pendidikan" value="<?= $d['pos_description'] ?>">
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
<!--delete Data-->
<div class="modal fade" id="deleteData<?= $d['pos_id'] ?>" role="dialog" aria-labelledby="addNewDataLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addNewDataLabel">Hapus <?= $title ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Anda yakin ingin menghapus data <b><?= $d['pos_name'] ?></b></p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<a href="<?= base_url('hapus/data_pos?id=') ?><?= $d['pos_id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
			</div>

		</div>
	</div>
</div>
<?php endforeach ?>
<!-- Modal -->
<div class="modal fade" id="addPos" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Tambah Nama Pembayaran</h4>
			</div>
			<?php echo form_open('manage/add_pos', array('method' => 'post')); ?>
			<div class="modal-body">
				<div class="form-group">
					<label>Nama Pembayaran</label>
					<input type="text" required="" name="pos_name" class="form-control" placeholder="Contoh: SPP">
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<input type="text" required="" name="pos_description" class="form-control" placeholder="Contoh: Sumbangan Pendidikan">
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>