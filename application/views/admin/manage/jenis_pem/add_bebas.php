<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
			<h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?></h1>
			<?php echo form_open_multipart(current_url(), array('class' => 'form-horizontal')); ?>
			<?php echo validation_errors(); ?>
			
            <div class="row">
					<div class="col-md-6">
						<div class="card shadow mb-4">
							<div class="card-body">
								<div class="box-header">
									<h3 class="box-title">Informasi Pembayaran</h3>
								</div>
								<hr />
								<div class="box-body">
									<div class="form-group row">
										<label for="" class="col-sm-4 control-label">Jenis Pembayaran</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" value="<?php echo $payment['pos_name'] . ' - T.A ' . $payment['period_start'] . '/' . $payment['period_end'] ?>" readonly="">
										</div>
									</div>
									<div class="form-group row">
										<label for="" class="col-sm-4 control-label">Tahun Pelajaran</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" value="<?php echo $payment['period_start'] . '/' . $payment['period_end'] ?>" readonly="">
										</div>
									</div>
									<div class="form-group row">
										<label for="" class="col-sm-4 control-label">Tipe Pembayaran</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" value="<?php echo ($payment['payment_type'] == 'BULAN' ? 'Bulanan' : 'Bebas') ?>" readonly="">
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="card shadow mb-4">
							<div class="card-body">
								<div class="box-success">
									<div class="box-header">
										<h3 class="box-title">Tarif Tagihan Per Siswa</h3>
									</div>
								</div>
								<hr />
								<div class="box-body table-responsive">
									<table class="table">
										<tbody>
											<tr>
												<td><strong>Pendidikakn</strong></td>
												<td>
													<select name="pendidikan" id="pendidikan" class="form-control" required="">
														<option value="">---Pilih Pendidikan---</option>
														<?php foreach ($pend as $row) : ?>
															<option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
														<?php endforeach; ?>
													</select>
												</td>
											</tr>
											<tr>
												<td><strong>Kelas</strong></td>
												<td>
													<select id="kelas" name="class_id" class="form-control">
														<option value="">-- Pilih pendidikan dahulu --</option>
													</select>
												</td>
											</tr>
											<tr>
												<td><strong>Tarif (Rp.)</strong></td>
												<td><input autofocus="" type="number" name="bebas_bill" placeholder="Masukan Tarif" required="" class="form-control numeric">
												</td>
											</tr>
											<tr>
												<td><strong>Keterangan (Rincian)</strong></td>
												<td><textarea name="bebas_desc" id="" class="form-control"></textarea></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="box-footer">
									<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
									<a href="<?php echo site_url('manage/jenis_pembayaran/view_bebas/' . $payment['payment_id']) ?>" class="btn btn-secondary"><i class="fa fa-angle-double-left"></i> Cancel</a>
								</div>
							</div>
						</div>
					</div>
					<?php echo form_close(); ?>

				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	<?php if(!isset($f['pend']) || empty($f['pend']) || $f['pend'] = '') : ?>
	$("#kelasan").hide();
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
	});
});
</script>