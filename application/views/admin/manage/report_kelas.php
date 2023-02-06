<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?></h1>
                    <?= $this->session->flashdata('message') ?>

					<div class="row">
						<div class="col-md-12">
							<div class="box box-success">
								<div class="box-header">
									<?= form_open(current_url(), array('method' => 'get')) ?>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label>Tahun Pelajaran</label>
												<select class="form-control" name="p">
													<?php foreach ($period as $row) : ?>
														<option <?= (isset($q['p']) and $q['p'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['period_start'] . '/' . $row['period_end'] ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
								
										<div class="form-group col-lg-3">
											<label>Pilih Pendidikan</label>
											<select class="form-control" id="pendidikan" name="pd">
												<option>- Pilih pendidikan -</option>
												<?php foreach ($pend as $row) : ?>
													<option <?= (isset($q['pd']) and $q['pd'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
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
											<select class="form-control" id="kelas" name="c">
												<option value="">-- Pilih Kelas --</option>
												<?php foreach ($class as $row) : ?>
													<option <?= (isset($q['c']) and $q['c'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
												<?php endforeach; ?>
											</select>
										</div>

										<div class="col-md-3">
											<div style="margin-top:25px;">
												<button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter Data</button>
												<?php if ($q and !empty($py)) { ?>
													<a class="btn btn-success" href="<?= site_url('report_set/report_bill_detail' . '/?' . http_build_query($q)) ?>"><i class="fa fa-file-excel-o"></i> Export Excel</a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php if ($q and !empty($py)) { ?>
				<div class="card shadow mb-4">
					<div class="card-body">
						<div class="box box-success">
							<div class="box-body table-responsive">
							<table class="table table-hover display" id="mytable" cellspacing="0" width="100%">
									<tr>
										<th rowspan="2">Kelas</th>
										<th rowspan="2">Nama</th>
										<?php foreach ($py as $row) : ?>
											<th colspan="<?= count($month) ?>">
												<center><?= $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end']; ?></center>
											</th>
										<?php endforeach ?>
										<?php foreach ($bebas as $key) : ?>
											<th rowspan="2">
												<center><?= $key['pos_name'] . ' - T.P ' . $key['period_start'] . '/' . $key['period_end']; ?></center>
											</th>
										<?php endforeach ?>
									</tr>
									<tr>
										<?php foreach ($month as $key) : ?>
											<th><?= $key['month_name'] ?></th>
										<?php endforeach ?>
									</tr>

									<?php foreach ($student as $row) : ?>
										<tr>
											<td><?= $row['class_name'] ?>
											<?php if(!empty($pendkkn['majors'])) : ?>
												 - <?= $row['majors_name'] ?>
											<?php endif ?>
											</td>
											<td width="200"><?= $row['nama'] ?></td>
											<?php foreach ($bulan as $key) : ?>
												<?php if ($key['student_student_id'] == $row['student_student_id']) { ?>
													<td style="color:<?= ($key['bulan_status'] == 1) ? '#00E640' : 'red' ?>"><?= ($key['bulan_status'] == 1) ? 'Lunas' : number_format($key['bulan_bill'], 0, ',', '.') ?></td>
												<?php } ?>
											<?php endforeach ?>
											<?php foreach ($free as $key) : ?>
												<?php if ($key['student_student_id'] == $row['student_student_id']) { ?>
													<td style="text-align:center;color:<?= ($key['bebas_bill'] == $key['bebas_total_pay']) ? '#00E640' : 'red' ?> "><?= ($key['bebas_bill'] == $key['bebas_total_pay']) ? 'Lunas' : number_format($key['bebas_bill'] - $key['bebas_total_pay'], 0, ',', '.') ?></td>
												<?php } ?>
											<?php endforeach ?>
										</tr>
									<?php endforeach ?>
								</table>
							</div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>
			<?php  } ?>
	<!-- /.content -->
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	<?php if(!isset($q['pd']) || empty($q['pd']) || $q['pd'] = '') : ?>
	$("#kelasan").hide();
	<?php endif ?>
	<?php if(!isset($q['pd']) || empty($pendkkn['majors'])) : ?>
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