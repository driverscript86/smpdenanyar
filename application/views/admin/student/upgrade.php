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
							Jika ada siswa yang telah dibuatkan tagihan dan dipindah kelasnya melalui halaman ini, maka tagihan tetap ada di kelas sebelumnya!
						</div>
					</div>
					<!-- /.box-header -->
					<div class="row">
						<div class="col-md-9">
							
							<?= form_open(current_url(), array('method' => 'get')) ?>
								<div class="form-row">
									
									<div class="form-group col-lg-3">
										<label>Pilih Pendidikan</label>
										<select class="form-control" id="pendidikan1" name="pend">
											<option>- Pilih pendidikan -</option>
											<?php foreach ($pend as $row) : ?>
												<option <?= (isset($f['pend']) and $f['pend'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>

									<div id="jurus1" class="form-group col-lg-3">
										<label>Pilih Kejuruan</label>
										<select class="form-control" id="majors" name="majors">
											<option value="">-- Pilih Jurusan --</option>
											<?php foreach ($majors as $row) : ?>
												<option <?= (isset($f['majors']) and $f['majors'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>

									<div id="kelasan" class="form-group col-lg-3">
										<label>Pilih Kelas</label>
										<select class="form-control" id="kelas1" name="pr" onchange="this.form.submit()">
											<option value="">-- Pilih Kelas --</option>
											<?php foreach ($class as $row) : ?>
												<option <?= (isset($f['pr']) and $f['pr'] == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?= form_close() ?>

							<form action="<?= site_url('student/multiple'); ?>" method="post" id="lulus">
								<input type="hidden" name="action" value="upgrade">
								<input type="hidden" name="pend" value="<?= $this->input->get('pend'); ?>">
								<input type="hidden" name="majors" value="<?= $this->input->get('majors'); ?>">
								<input type="hidden" name="pr" value="<?= $this->input->get('pr'); ?>">
								<div style="width:100%; overflow-x:scroll">	
									<table class="table table-hover display" id="mytable" width="100%">
										<thead>
											<tr>
												<th scope="col"><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></th>
												<th scope="col">No</th>
												<th scope="col">NIS</th>
												<th scope="col">Nama</th>
												<th scope="col">Pendidikan</th>
												<th scope="col">Kelas</th>
											</tr>
										</thead>
										<tbody>
											<?php if ($this->input->get(NULL)) { ?>
												<?php
												if (!empty($student)) {
													$i = 1;
													foreach ($student as $row) :
													$pdk = $this->db->get_where('data_pendidikan', ['id' => $row['id_pend']])->row_array();
													$mjr = $this->db->get_where('data_jurusan', ['id' => $row['id_majors']])->row_array();
													$kls = $this->db->get_where('data_kelas', ['id' => $row['id_kelas']])->row_array();
												?>
														<tr style="<?= ($row['status'] == 0) ? 'color:#00E640' : '' ?>">
															<th width="70"><input type="checkbox" class="msg <?= ($row['status'] == 0) ? NULL : 'checkbox' ?>" <?= ($row['status'] == 0) ? 'disabled' : NULL ?> name="msg[]" value="<?= $row['id']; ?>"></td>
															<th width="50"><?= $i; ?></td>
															<td><?= $row['nis']; ?></td>
															<td><?= $row['nama']; ?></td>
															<td width="130"><?= $pdk['nama'] ?></td>
															<td><?= $kls['nama'] ?> - <?= $mjr['nama'] ?></td>
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
									</table>
								</div>
								
						</div>

						<div class="col-md-3">
							<div class="box box-warning">

								<div class="form-row">
									<div class="form-group col-md-12">
									<div class="alert alert-success"><b>Proses Kenaikan Kelas</b></div>
									</div>
								</div>

								<div class="box-body">
									<select class="form-control" id="pendidikan" name="pendidikan" required="">
										<option value="">- Pilih pendidikan -</option>
										<?php foreach ($pend as $row) : ?>
											<option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
										<?php endforeach; ?>
									</select>
									<div id="jurus">
										<br>
										<select class="form-control" id="jurusan" name="jurusan" required="">
											<option>- Pilih Jurusan -</option>
										</select>
									</div>
									<br>
									<select class="form-control" id="kelas" name="kelas" required="">
										<option value="">-- Pilih Kelas --</option>
									</select>
									<br>
								</form>
								<button class="btn btn-danger btn-block" onclick="$('#lulus').submit()"><i class="fa fa-chevron-right"></i> <b>Proses Naik Kelas</b></button>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
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
	$("#jurus").hide();
	<?php if(!isset($f['pend']) || empty($f['pend']) || $f['pend'] = '') : ?>
	$("#kelasan").hide();
	<?php endif ?>
	<?php if(!isset($f['pend']) || empty($pendkkn['majors'])) : ?>
	$("#jurus1").hide();
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
			}
		});
		$.ajax({
			type: 'POST',
			url: '<?= site_url('get/get_majors'); ?>',
			data: {
				pendidikan: this.value
			},
			cache: false,
			success: function(response) {
				$('#jurusan').html(response);
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
	$('#pendidikan1').change(function() {
		$.ajax({
			type: 'POST',
			url: '<?= site_url('get/get_kelas_all'); ?>',
			data: {
				pendidikan: this.value
			},
			cache: false,
			success: function(response) {
				$('#kelas1').html(response);
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
					$("#jurus1").show();
				}else if(response == 0){
					$("#jurus1").hide();
				}
			}
		});
	});
});
</script>