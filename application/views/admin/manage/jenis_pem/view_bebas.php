<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
			<h1 class="h3 mb-4 text-gray-800 text-center"><i class="fas fa-list"></i> <?= $title ?></h1>
            <div class="card shadow mb-4">
                <div class="card-body">
					<div class="box-header with-border">
						<h3 class="box-title">Tarif - <?= $payment['pos_name'] . ' - T.A ' . $payment['period_start'] . '/' . $payment['period_end'] ?></h3>
					</div><!-- /.box-header -->
					<?= $this->session->flashdata('message') ?>
					<div class="row">
						<div class="col-md-12">
							<div class="box box-success">
							
								<div class="box-body">
									<?= form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
									<div class="form-row">
										<div class="form-group col-lg-3">
											<label>Pilih Pendidikan</label>
											<select class="form-control" id="pendidikan" name="pend">
												<option>- Pilih pendidikan -</option>
												<?php foreach ($pend as $row) : ?>
													<option <?= (isset($q['pend']) and $q['pend'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
												<?php endforeach; ?>
											</select>
										</div>

										<div id="jurus" class="form-group col-lg-3">
											<label>Pilih Kejuruan</label>
											<select class="form-control" id="majors" name="k">
												<option value="">-- Pilih Jurusan --</option>
												<?php foreach ($majors as $row) : ?>
													<option <?= (isset($q['k']) and $q['k'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
												<?php endforeach; ?>
											</select>
										</div>

										<div id="kelasan" class="form-group col-lg-3">
											<label>Pilih Kelas</label>
											<select class="form-control" id="kelas" name="pr">
												<option value="">-- Pilih Kelas --</option>
												<?php foreach ($class as $row) : ?>
													<option <?= (isset($q['pr']) and $q['pr'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										
										<div class="form-group col-lg-3">
											<label>Tampil Data</label><br>
											<button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Tampilkan Data</button>
										</div>

									</div>

									</form>
									<hr>
									<div class="col-sm-10 text-center">
									<label for="" class="col-sm-2"><b>Setting Tarif</b></label>
										<a class="btn btn-primary btn-sm" href="<?= site_url('manage/jenis_pembayaran/add_payment_bebas_pend/' . $payment['payment_id']) ?>"><span class="fa fa-plus"></span> Berdasarkan Pendidikan</a>
										<a class="btn btn-warning btn-sm" href="<?= site_url('manage/jenis_pembayaran/add_payment_bebas/' . $payment['payment_id']) ?>"><span class="fa fa-plus"></span> Berdasarkan Kelas</a>
										<?php if(!empty($pendkkn['majors'])) : ?>
										<a class="btn btn-success btn-sm" href="<?= site_url('manage/jenis_pembayaran/add_payment_bebas_majors/' . $payment['payment_id']) ?>"><span class="fa fa-plus"></span> Berdasarkan Jurusan</a>
										<?php endif ?>
										<a class="btn btn-info btn-sm" href="<?= site_url('manage/jenis_pembayaran/add_payment_bebas_student/' . $payment['payment_id']) ?>"><span class="fa fa-plus"></span> Berdasarkan Siswa</a>
										<a class="btn btn-secondary btn-sm" href="<?= site_url('manage/jenis_pembayaran') ?>"><span class="fa fa-angle-double-left"></span> Kembali</a>
									</div>
								</div><!-- /.box-body -->
							</div><!-- /.box -->

							<?php if ($q) { ?>
								<div class="box box-success">
									<div class="box-body table-responsive">
										<table class="table table-hover" id="mytable">
											<thead>
											<tr>
												<th>No</th>
												<th>NIS</th>
												<th>Nama</th>
												<th>Pendidikan</th>
												<th>Kelas</th>
												<?php if(!empty($pendkkn['majors'])) : ?>
												<th>Jurusan</th>
												<?php endif ?>
												<th>Tagihan</th>
												<th>Aksi</th>
											</tr>
											</thead>
											<tbody>
												<?php
												$i = 1;
												foreach ($student as $row) :
												?>
													<tr>
														<td><?= $i; ?></td>
														<td><?= $row['nis']; ?></td>
														<td><?= $row['nama']; ?></td>
														<td><?= $row['pend_name']; ?></td>
														<td><?= $row['class_name']; ?></td>
														<?php if(!empty($pendkkn['majors'])) : ?>
														<td><?= $row['majors_name']; ?></td>
														<?php endif ?>
														<td><?= 'Rp. ' . number_format($row['bebas_bill'], 0, ',', '.') ?></td>
														<td>
															<a href="<?= site_url('manage/jenis_pembayaran/edit_payment_bebas/' . $row['payment_payment_id'] . '/' . $row['student_student_id'] . '/' . $row['bebas_id']) ?>" class="badge badge-warning" data-toggle="tooltip" title="Ubah Tarif"><i class="fa fa-edit"></i></a>
															<a href="#" data-toggle="modal" data-target="#deletePayBebas<?= $row['student_student_id'] ?>" class="badge badge-danger"><i class="fa fa-trash"></i></a>
														</td>
													</tr>
											<?php
													$i++;
												endforeach;
											} ?>
											</tbody>
										</table>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php foreach ($student as $row) : ?>
<div class="modal fade" id="deletePayBebas<?= $row['student_student_id'] ?>">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Konfirmasi Hapus</h4>
			</div>
			<form action="<?= site_url('hapus/data_payment_bebas') ?>" method="POST">
				<div class="modal-body">
					<p>Apakah anda akan menghapus pembayaran a.n <b><?= $row['nama'] ?></b>?</p>
					<input type="hidden" name="student_id" value="<?= $row['student_student_id'] ?>">
					<input type="hidden" name="payment_id" value="<?= $row['payment_payment_id'] ?>">
					<input type="hidden" name="bebas_id" class="bebasID" value="<?= $row['bebas_id'] ?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Hapus</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php endforeach ?>

<script>
	function getId(id) {
		$('#paymentID').val(id),
			$('#studentID').val(id)

	}
</script>

<script type="text/javascript">
$(document).ready(function() {
	<?php if(!isset($q['pend']) || empty($q['pend']) || $q['pend'] = '') : ?>
	$("#kelasan").hide();
	<?php endif ?>
	<?php if(!isset($q['pend']) || empty($pendkkn['majors'])) : ?>
	$("#jurus").hide();
	<?php endif ?>
	
	$('#pendidikan').change(function() {
		$.ajax({
			type: 'POST',
			url: '<?= site_url('get/get_kelas_all'); ?>',
			data: {
				pendidikan: this.value
			},
			cache: false,
			success: function(response) {
				$('#kelas').html(response);
				$("#kelasan").show();
			}
		});
		$.ajax({
			type: 'POST',
			url: '<?= site_url('get/get_id_majors'); ?>',
			data: {
				pendidikan: this.value
			},
			cache: false,
			success: function(response) {
				if(response == 1){
					$("#jurus").show();
				}else if(response == 0){
					$("#jurus").hide();
				}
			}
		});
	});
});
</script>