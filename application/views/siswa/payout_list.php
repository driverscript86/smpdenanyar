
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row">

        <div class="col-md-12 text-center">
            <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
            <hr />
        </div>
        <div class="col-md-12">
			<?= $this->session->flashdata('message') ?>

				<?php if ($f) { ?>
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary"> Informasi Siswa

								<div class="float-right">
								<?php if ($f['n'] and $f['r'] != NULL) { ?>
									<a href="<?= site_url('siswa/printBill' . '/?' . http_build_query($f)) ?>" target="_blank" class="btn btn-primary btn-xs pull-right"><i class="fa fa-print"></i> Cetak Semua Tagihan</a>
								<?php } ?>
								</div>
							</h6>
						</div>
						<div class="card-body row">
							<div class="col-md-9">
								<table class="table table-striped">
									<tbody>
										<tr>
											<td width="200">Tahun Pelajaran</td>
											<td width="4">:</td>
											<?php foreach ($period as $row) : ?>
												<?= (isset($f['n']) and $f['n'] == $row['id']) ?
													'<td><strong>' . $row['period_start'] . '/' . $row['period_start'] . '<strong></td>' : '' ?>
											<?php endforeach; ?>
										</tr>
										<tr>
											<td>NIS</td>
											<td>:</td>
											<?php foreach ($siswa as $row) : ?>
												<?= (isset($f['n']) and $f['r'] == $row['nis']) ?
													'<td>' . $row['nis'] . '</td>' : '' ?>
											<?php endforeach; ?>
										</tr>
										<tr>
											<td>Nama Siswa</td>
											<td>:</td>
											<?php foreach ($siswa as $row) : ?>
												<?= (isset($f['n']) and $f['r'] == $row['nis']) ?
													'<td>' . $row['nama'] . '</td>' : '' ?>
											<?php endforeach; ?>
										</tr>
										<tr>
											<td>Kelas</td>
											<td>:</td>
											<?php foreach ($siswa as $row) : ?>
												<?= (isset($f['n']) and $f['r'] == $row['nis']) ?
													'<td>' . $row['class_name'] . ' ' . $row['majors_name'] . '</td>' : '' ?>
											<?php endforeach; ?>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-3">
								<?php foreach ($siswa as $row) : ?>
									<?php if (isset($f['n']) and $f['r'] == $row['nis']) { ?>
										<?php if (!empty($row['img_siswa'])) { ?>
											<img src="<?= base_url('assets/img/profile/' . $row['img_siswa']) ?>" class="img-thumbnail img-responsive text-right" width="200" height="200">
										<?php } else { ?>
											<img src="<?= base_url('assets/img/profile/default.jpg') ?>" class="img-thumbnail img-responsive" width="200" height="200">
									<?php }
									} ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8">
							<div class="card shadow mb-4">
								<div class="card-header py-3">
									<h6 class="m-0 font-weight-bold text-primary"> Transaksi Terakhir</h6>
								</div>
								<div class="card-body">
									<table class="table table-hover display" id="mytable" cellspacing="0" width="100%">
										<tr class="success">
											<th>Pembayaran</th>
											<th>Tagihan</th>
											<th>Tanggal</th>
										</tr>
										<?php
										foreach ($log as $key) :
										?>
											<tr>
												<td><?= ($key['bulan_bulan_id'] != NULL) ? $key['posmonth_name'] . ' - T.P ' . $key['period_start_month'] . '/' . $key['period_end_month'] . ' (' . $key['month_name'] . ')' : $key['posbebas_name'] . ' - T.A ' . $key['period_start_bebas'] . '/' . $key['period_end_bebas'] ?></td>
												<td><?= ($key['bulan_bulan_id'] != NULL) ? 'Rp. ' . number_format($key['bulan_bill'], 0, ',', '.') : 'Rp. ' . number_format($key['bebas_pay_bill'], 0, ',', '.') ?></td>
												<td><?= pretty_date($key['log_trx_input_date'], 'd F Y', false)  ?></td>
											</tr>
										<?php endforeach ?>

									</table>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="card shadow mb-4">
								<div class="card-header py-3">
									<h6 class="m-0 font-weight-bold text-primary">Cetak Bukti Pembayaran</h6>
								</div>
								<div class="card-body">
									<form action="<?= site_url('siswa/cetakBukti') ?>" method="GET" class="view-pdf">
										<input type="hidden" name="n" value="<?= $f['n'] ?>">
										<input type="hidden" name="r" value="<?= $f['r'] ?>">
										<div class="form-group">
											<label>Tanggal Transaksi</label>
											<div class="input-group date " data-date="<?= date('Y-m-d') ?>" data-date-format="yyyy-mm-dd">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
												<input class="form-control" readonly="" required="" type="text" name="d" value="<?= date('Y-m-d') ?>">
											</div>
										</div>
										<button class="btn btn-success btn-block" formtarget="_blank" type="submit"><i class="fa fa-print"></i> Cetak Bukti Pembayaran</button>
									</form>
								</div>
							</div>
						</div>
					</div>
						<!-- List Tagihan Bulanan -->
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">Jenis Pembayaran</h6>
							</div>
							<div class="card-body" id="accordion">
								<div class="row nav-tabs-custom">
									<div class="col-md-6">
										<div id="headingOne">
											<button id="button_tab" type="button" class="btn btn-light btn-block" data-toggle="collapse" data-target="#tab_1" aria-expanded="false" aria-controls="tab_1"><b>Bulanan</b> &nbsp;<i class="fa fa-shopping-cart"></i></button>
										</div>
									</div>
									<div class="col-md-6">
										<div id="headingTwo">
											<button type="button" class="btn btn-light btn-block" data-toggle="collapse" data-target="#tab_2" aria-expanded="false" aria-controls="tab_2"><b>Bebas</b>&nbsp; <i class="fa fa-shopping-cart"></i></button>
										</div>
									</div>
								</div>
								<hr class="mb-5" />
								<div class="collapse show" id="tab_1" aria-labelledby="headingOne" data-parent="#accordion">
									<div class="box-body table-responsive">
										<table class="table table-hover display" id="mytable" cellspacing="0" width="100%">
											<thead>
												<tr class="success">
													<th class="text-center">No.</th>
													<th>Jenis Pembayaran</th>
													<th>Tahun Pelajaran</th>
													<th class="text-center">Detail</th>
												</tr>
											</thead>
											<tbody>
												<?php $i = 1;
													foreach ($student as $row) :
													if ($f['n'] and $f['r'] == $row['nis']) { ?>
														<tr>
															<td width="5%" class="text-center"><?= $i ?></td>
															<td><?= $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'] ?></td>
															<td class="danger"><?= $row['period_start'] . '/' . $row['period_end'] ?></td>
															<td width="10%" class="text-center">
																<a data-toggle="modal" href="#RincianPayBulan<?= $row['payment_payment_id'] ?>" class="view-bulan badge badge-primary" data-toggle="tooltip" title="Deatil Pembayaran"><i class="fa fa-search"></i>&nbsp;<b>Detail</b></a>
															</td>
														</tr>

														<div class="modal fade" id="RincianPayBulan<?= $row['payment_payment_id'] ?>" role="dialog">
															<div class="modal-dialog modal-lg">
																<div class="modal-content">
																	<div class="modal-header">
																		<h4 class="modal-title">Lihat Pembayaran / Angsuran</h4>
																	</div>
																	<div class="modal-body">
																		
																		<div id="AjaxPayBulan"></div>

																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
																	</div>
																</div>
															</div>
														</div>
												<?php } $i++; endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>

								<div class="collapse" id="tab_2" aria-labelledby="headingTwo" data-parent="#accordion">
								
									<div class="box-body">
										<table class="table table-hover display" id="mytable" cellspacing="0" width="100%">
											<thead>
												<tr class="success">
													<th class="text-center">No.</th>
													<th>Jenis Pembayaran</th>
													<th>Total Tagihan</th>
													<th>Dibayar</th>
													<th class="text-center">Status</th>
													<!-- <th class="text-center">Bayar</th> -->
													<th class="text-center">Detail Tagihan</th>
												</tr>
											</thead>
											<tbody>
												<?php $i = 1;
													foreach ($bebas as $row) :
													if ($f['n'] and $f['r'] == $row['nis']) {
														$sisa = $row['bebas_bill'] - $row['bebas_total_pay']; ?>
														<tr class="<?= ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'success' : 'danger' ?>">
															<td style="background-color: #fff !important;" class="text-center" width="5%"><?= $i ?></td>
															<td style="background-color: #fff !important;"><?= $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'] ?></td>
															<td><?= 'Rp. ' . number_format($sisa, 0, ',', '.') ?></td>
															<td><?= 'Rp. ' . number_format($row['bebas_total_pay'], 0, ',', '.') ?></td>
															<td class="text-center">
																<a data-toggle="modal" href="#RincianPayBebas<?= $row['bebas_id'] ?>" class="view-cicilan badge <?= ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'badge-success' : 'badge-danger' ?>"><?= ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'Lunas' : 'Belum Lunas' ?></a>
															</td>
															<!-- <td class="text-center">
																<a data-toggle="modal" class="badge badge-success <?= ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'disabled' : '' ?>" title="Bayar" href="#addCicilan<?= $row['bebas_id'] ?>"><span class="fa fa-dollar"></span> <b>Bayar Tagihan</b></a>
															</td> -->
															<td class="text-center">
																<a data-toggle="modal" class="badge badge-info <?= ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'disabled' : '' ?>" title="Bayar" href="#addRincian<?= $row['bebas_id'] ?>"><span class="fa fa-dollar"></span> <b>Rincian</b></a>
															</td>
														</tr>

														<div class="modal fade" id="RincianPayBebas<?= $row['bebas_id'] ?>" role="dialog">
															<div class="modal-dialog modal-lg">
																<div class="modal-content">
																	<div class="modal-header">
																		<h4 class="modal-title">Lihat Pembayaran / Angsuran</h4>
																	</div>
																	<div class="modal-body">
																		
																		<div id="AjaxPayBebas"></div>

																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
																	</div>
																</div>
															</div>
														</div>

														<div class="modal fade" id="addRincian<?= $row['bebas_id'] ?>" role="dialog">
															<div class="modal-dialog modal-md">
																<div class="modal-content">
																	<div class="modal-header">
																		<h4 class="modal-title"><?= $row['nis'] ?> - Detail Tagihan</h4>
																	</div>
																	<div class="modal-body">
																		<input type="hidden" name="bebas_id" value="<?= $row['bebas_id'] ?>">
																		<input type="hidden" name="nis" value="<?= $row['nis'] ?>">
																		<input type="hidden" name="student_student_id" value="<?= $row['student_student_id'] ?>">
																		<input type="hidden" name="payment_payment_id" value="<?= $row['payment_payment_id'] ?>">
																		<div class="row">
																			<div class="col-md-12">
																				<label>Keterangan *</label>
																				<textarea rows="5" class="form-control" readonly><?= $row['bebas_desc'] ?></textarea>
																			</div>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
																	</div>
																</div>
															</div>
														</div>

														<div class="modal fade" id="addCicilan<?= $row['bebas_id'] ?>" role="dialog">
															<div class="modal-dialog modal-md">
																<div class="modal-content">
																	<div class="modal-header">
																		<h4 class="modal-title">Tambah Pembayaran / Angsuran</h4>
																	</div>
																	<?= form_open('payout/payout_bebas/', array('method' => 'post')); ?>
																	<div class="modal-body">
																		<input type="hidden" name="bebas_id" value="<?= $row['bebas_id'] ?>">
																		<input type="hidden" name="nis" value="<?= $row['nis'] ?>">
																		<input type="hidden" name="student_student_id" value="<?= $row['student_student_id'] ?>">
																		<input type="hidden" name="payment_payment_id" value="<?= $row['payment_payment_id'] ?>">
																		<div class="form-group">
																			<label>Nama Pembayaran</label>
																			<input class="form-control" readonly="" type="text" value="<?= $row['pos_name'] . ' - T.A ' . $row['period_start'] . '/' . $row['period_end'] ?>">
																		</div>
																		<div class="form-group">
																			<label>Tanggal</label>
																			<input class="form-control" readonly="" type="text" value="<?= pretty_date(date('Y-m-d'), 'd F Y', false) ?>">
																		</div>
																		<div class="row">
																			<div class="col-md-6">
																				<label>Jumlah Bayar *</label>
																				<input type="text" required="" name="bebas_pay_bill" class="form-control numeric" placeholder="Jumlah Bayar">
																			</div>
																			<div class="col-md-6">
																				<label>Keterangan *</label>
																				<input type="text" required="" name="bebas_pay_desc" class="form-control" placeholder="Keterangan">
																			</div>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="submit" class="btn btn-success">Simpan</button>
																		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
																	</div>
																	<?= form_close(); ?>
																</div>
														<?php
													}
													$i++;
												endforeach;
														?>
											</tbody>
										</table>
									</div>
								</div>

							</div>
						</div>
					<?php } ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	function startCalculate() {
		interval = setInterval("Calculate()", 10);
	}

	function Calculate() {
		var numberHarga = $('#harga').val(); // a string
		numberHarga = numberHarga.replace(/\D/g, '');
		numberHarga = parseInt(numberHarga, 10);
		var numberBayar = $('#bayar').val(); // a string
		numberBayar = numberBayar.replace(/\D/g, '');
		numberBayar = parseInt(numberBayar, 10);
		var total = numberBayar - numberHarga;
		$('#kembalian').val(total);
	}

	function stopCalc() {
		clearInterval(interval);
	}
</script>
<script>
	$('button').on('click', function(){
    $('button').removeClass('active_button');
    $(this).addClass('active_button');
	});

	$(document).ready(function() {
		$('#button_tab').addClass('active_button');

		$("#selectall").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
</script>

<script type="text/javascript">
$(document).ready(function() {
	<?php foreach ($student as $row) : ?>
		$('.view-bulan').click(function(){
			$.ajax({
				type: 'POST',
				url: '<?= site_url('siswa/payout_bulan/' . $row['payment_payment_id'] . '/' . $row['student_student_id']); ?>',
				data: {
					majors: this.value
				},
				cache: false,
				success: function(response) {
					$('#AjaxPayBulan').html(response);
				}
			});
		});
	<?php endforeach ?>
	
	<?php foreach ($bebas as $row) : ?>
		$('.view-cicilan').click(function(){
			$.ajax({
				type: 'POST',
				url: '<?= site_url('siswa/payout_bebas/' . $row['payment_payment_id'] . '/' . $row['student_student_id'] . '/' . $row['bebas_id']); ?>',
				data: {
					majors: this.value
				},
				cache: false,
				success: function(response) {
					$('#AjaxPayBebas').html(response);
				}
			});
		});
	<?php endforeach ?>
});
</script>