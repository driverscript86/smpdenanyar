<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list"></i> <?= $title ?></h1>
					<div class="col-md-12">
						<?= $this->session->flashdata('message') ?>
						<div class="alert alert-warning">
							<b>PERINGATAN!</b> &nbsp;
							Halaman ini digunakan untuk merubah status siswa menjadi lulus. Pastikan siswa yang di proses adalah siswa kelas akhir.
						</div>
					</div>
					<!-- /.box-header -->
					<div class="row">
						<div class="col-md-5">
							<div class="box box-success">
								<div class="box-body">
								<?= form_open(current_url(), array('method' => 'get')) ?>
									<div class="form-row">
										
										<div class="form-group col-lg-4">
											<label>Pilih Pendidikan</label>
											<select class="form-control" id="pendidikan" name="pend">
												<option>- Pilih pendidikan -</option>
												<?php foreach ($pend as $row) : ?>
													<option <?= (isset($f['pend']) and $f['pend'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
												<?php endforeach; ?>
											</select>
										</div>

										<div id="jurus" class="form-group col-lg-4">
											<label>Pilih Kejuruan</label>
											<select class="form-control" id="majors" name="majors">
												<option value="">-- Pilih Jurusan --</option>
												<?php foreach ($majors as $row) : ?>
													<option <?= (isset($f['majors']) and $f['majors'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
												<?php endforeach; ?>
											</select>
										</div>

										<div id="kelasan" class="form-group col-lg-4">
											<label>Pilih Kelas</label>
											<select class="form-control" id="kelas" name="pr" onchange="this.form.submit()">
												<option value="">-- Pilih Kelas --</option>
												<?php foreach ($class as $row) : ?>
													<option <?= (isset($f['pr']) and $f['pr'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								<?= form_close() ?>
									<table class="table table-hover display" id="mytable" width="100%">
										<form action="<?= site_url('student/multiple'); ?>" method="post" id="lulus">
											<input type="hidden" name="action" value="pass">
											<input type="hidden" name="pend" value="<?= $this->input->get('pend'); ?>">
											<input type="hidden" name="majors" value="<?= $this->input->get('majors'); ?>">
											<input type="hidden" name="pr" value="<?= $this->input->get('pr'); ?>">
											<tr>
												<th><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></th>
												<th>No</th>
												<th>NIS</th>
												<th>Nama</th>
												<th>Status Kelulusan</th>
											</tr>
											<tbody>
												<?php if ($this->input->get(NULL)) { ?>
													<?php
													if (!empty($notpass)) {
														$i = 1;
														foreach ($notpass as $row) :
													?>
															<tr style="<?= ($row['status'] == 0) ? 'color:#00E640' : '' ?>">
																<td><input type="checkbox" class="<?= ($row['status'] == 0) ? NULL : 'checkbox' ?>" <?= ($row['status'] == 0) ? 'disabled' : NULL ?> name="msg[]" value="<?= $row['id']; ?>"></td>
																<td><?= $i; ?></td>
																<td><?= $row['nis']; ?></td>
																<td><?= $row['nama']; ?></td>
																<td><label class="label <?= ($row['status'] == 0) ? 'label-success' : 'label-warning' ?>"><?= ($row['status'] == 0) ? 'Lulus' : 'Belum Lulus' ?></label></td>
															</tr>
														<?php
															$i++;
														endforeach;
													} else {
														?>
														<tr id="row">
															<td colspan="5" align="center">Data Kosong</td>
														</tr>
													<?php } ?>
												<?php } else {
												?>
													<tr id="row">
														<td colspan="5" align="center">Data Kosong</td>
													</tr>
												<?php } ?>
											</tbody>
										</form>
									</table>
								</div>
							</div>
						</div>

						<div class="col-md-2 pt-5">
							<div class="box box-primary">
								<div class="box-body">
									<button class="btn btn-success btn-block" type="submit" onclick="$('#lulus').submit()"><span class="fa fa-chevron-right"></span> <b>Proses Lulus</b></button>
									<br>
									<button class="btn btn-danger btn-block" onclick="$('#kembali').submit();"><span class="fa fa-chevron-left"></span> <b>Batal Lulus</b></button>
								</div>
							</div>
						</div>
						
						<div class="col-md-5 pt-5">
							<div class="box box-danger">
								<div class="box-body">
									<h4>Data Kelulusan</h4>
									<table class="table table-hover display" id="mytable" width="100%">
										<form action="<?= site_url('student/multiple'); ?>" method="post" id="kembali">
											<input type="hidden" name="action" value="notpass">
											<input type="hidden" name="pend" value="<?= $this->input->get('pend'); ?>">
											<input type="hidden" name="majors" value="<?= $this->input->get('majors'); ?>">
											<input type="hidden" name="pr" value="<?= $this->input->get('pr'); ?>">
											<tr>
												<th><input type="checkbox" id="selectall2" value="checkbox" name="checkbox"></th>
												<th>No</th>
												<th>NIS</th>
												<th>Nama</th>
												<th>Status Kelulusan</th>
											</tr>
											<tbody>
												<?php
												if (!empty($pass)) {
													$i = 1;
													foreach ($pass as $row) :
												?>
														<tr>
															<td><input type="checkbox" class="checkbox" name="msg[]" value="<?= $row['id']; ?>"></td>
															<td><?= $i; ?></td>
															<td><?= $row['nis']; ?></td>
															<td><?= $row['nama']; ?></td>
															<td style="color:#00E640"><label class="label label-success"><?= ($row['status'] == 0) ? 'Lulus' : 'Belum Lulus' ?></label></td>
														</tr>
													<?php
														$i++;
													endforeach;
												} else {
													?>
													<tr id="row">
														<td colspan="6" align="center">Data Kosong</td>
													</tr>
												<?php } ?>
											</tbody>
										</form>
									</table>
								</div>
								</form>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$("#selectall").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
	$(document).ready(function() {
		$("#selectall2").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
</script>
<script type="text/javascript">
$(document).ready(function() {
	<?php if(!isset($f['pend']) || empty($f['pend']) || $f['pend'] = '') : ?>
	$("#kelasan").hide();
	<?php endif ?>
	<?php if(!isset($f['pend']) || empty($pendkkn['majors'])) : ?>
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