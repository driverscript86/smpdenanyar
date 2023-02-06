<?php

if (isset($bulan)) {

	$inputStudentValue = $bulan['student_id'];
	$inputClassValue = $bulan['class_id'];
	$inputBillValue = $bulan['bulan_bill'];
} else {
	$inputStudentValue = set_value('student_student_id');
	$inputClassValue = set_value('class_id');
	$inputBillValue = set_value('bulan_bill');
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-4">
                    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?></h1>
	
					<?php echo form_open_multipart(current_url(), array('class' => 'form-horizontal')); ?>
					<?php echo validation_errors(); ?>
					<?php if (isset($bulan)) { ?>
						<input type="hidden" name="payment_id" value="<?php echo $payment['payment_id']; ?>">
						<?php } ?>
						
						<div class="row">
							<div class="col-md-5">
								<div class="card shadow mb-4">
									<div class="card-body">
										<div class="box-header with-border">
											<h3 class="box-title">Pilih Kelas</h3>
										</div>
										<hr />
										<div class="box-body">
											<div class="form-group row">
												<label for="" class="col-sm-4 control-label">Jenis Bayar</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $payment['pos_name'] . ' - T.A ' . $payment['period_start'] . '/' . $payment['period_end'] ?>" readonly="">
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 control-label">Tahun Ajaran</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $payment['period_start'] . '/' . $payment['period_end'] ?>" readonly="">
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 control-label">Tipe Bayar</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo ($payment['payment_type'] == 'BULAN' ? 'Bulanan' : 'Bebas') ?>" readonly="">
												</div>
											</div>

											<div class="form-group">
												<div id="selTask" class="row">
													<label for="" class="col-sm-4 control-label">Pendidikan</label>
													<div class="col-sm-8">
														<select name="id_pend" id="id_pend" class="form-control" required="">
															<option value="">---Pilih Pendidikan---</option>
														<?php foreach ($pend as $row) : ?>
															<option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
														<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>

										</div>
									</div>
								</div>
								<div class="card shadow mb-4">
									<div class="card-body">
										<div class="box-header with-border">
											<h3 class="box-title">Tarif Setiap Bulan Sama</h3>
										</div>
										<hr />
										<div class="box-body">
											<div class="form-group">
												<label>Tarif Bulanan (Rp.)</label>
												<input type="number" placeholder="Masukkan Nilai dan Tekan Enter" id="allTarif" name="allTarif" class="form-control numeric">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-7">
								<div class="card shadow mb-4">
									<div class="card-body">
										<div class="box-header with-border">
											<h3 class="box-title">Tarif Setiap Bulan Tidak Sama</h3>
										</div>
										<hr />
										<div class="box-body">
											<table class="table">
												<tbody>
													<?php foreach ($month as $row) : ?>
														<input type="hidden" name="month_id[]" value="<?php echo $row['id']; ?>">
														<tr>
															<td><strong><?php echo $row['month_name']; ?></strong></td>
															<td><input type="text" id="n<?php echo $row['id'] ?>" name="bulan_bill[]" class="form-control numeric" required="">
															</td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
										<div class="box-footer">
											<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
											<a href="<?php echo site_url('manage/jenis_pembayaran/view_bulan/' . $payment['payment_id']) ?>" class="btn btn-secondary"><i class="fa fa-angle-double-left"></i> Cancel</a>
										</div>
									</div>
								</div>
							</div>
							<?php echo form_close(); ?>
						</div>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#allTarif").keypress(function(event) {
		var allTarif = $("#allTarif").val();
		if (event.keyCode == 13) {
			event.preventDefault();
			<?php foreach ($month as $row) : ?>
				$("#n<?php echo $row['id'] ?>").val(allTarif);
			<?php endforeach ?>
		}
	});
</script>