
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
												<label for="" class="col-sm-4 control-label">Tipe Pembayaran</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo ($payment['payment_type'] == 'BULAN' ? 'Bulanan' : 'Bebas') ?>" readonly="">
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 control-label">NIM</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" readonly="" value="<?php echo $student['nis'] ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 control-label">Nama</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" readonly="" value="<?php echo $student['nama'] ?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 control-label">Kelas</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" readonly="" value="<?php echo $student['class_name'] ?>">
												</div>
											</div>
											
											<?php if(!empty($student['id_majors'])) : ?>
												<div class="form-group row">
													<label for="" class="col-sm-4 control-label">Kejuruan</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" readonly="" value="<?php echo $student['majors_name'] ?>">
													</div>
												</div>
											<?php endif ?>

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
												<input type="text" placeholder="Masukkan Nilai dan Tekan Enter" id="allTarif" name="allTarif" class="form-control numeric">
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
													<?php foreach ($bulan as $row) : ?>
														<tr>
															<td><?php echo $row['month_name']; ?></td>
															<input type="hidden" name="bulan_id[]" value="<?php echo $row['bulan_id'] ?>">
															<td><input type="text" id="n<?php echo $row['month_month_id'] ?>" name="bulan_bill[]" value="<?php echo $row['bulan_bill'] ?>" class="form-control numeric">
															</td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
										<div class="box-footer">
											<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
											<button class="kembali btn btn-secondary"><i class="fa fa-angle-double-left"></i> Cancel</button>
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
			<?php foreach ($bulan as $row) : ?>
				$("#n<?php echo $row['month_month_id'] ?>").val(allTarif);
			<?php endforeach ?>
		}
	});

	$('.kembali').click(function() { 
        if(history.length != 0)
        {
            if(confirm("Yakin kembali ke halaman sebelumnya?")) 
            { 
                history.go(-1);
            }
         return false;
        }
        alert("No history found");
        return false;
	});
</script>