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
												<td><strong>Nama Siswa</strong></td>
												<td><input type="text" class="form-control" value="<?php echo $student['nama'] ?>" readonly>
												</td>
											</tr>
											<tr>
												<td><strong>Kelas</strong></td>
												<td><input type="text" class="form-control" value="<?php echo $student['class_name'] ?>" readonly>
												</td>
											</tr>
											<?php if(!empty($student['id_majors'])) : ?>
											<tr>
												<td><strong>Jurusan</strong></td>
												<td><input type="text" class="form-control" value="<?php echo $student['majors_name'] ?>" readonly>
												</td>
											</tr>
											<?php endif ?>
											<tr>
												<td><strong>Tarif (Rp.)</strong></td>
												<?php foreach ($bebas as $row) { ?>
													<td>
														<input autofocus="" type="text" id="" name="bebas_bill" placeholder="Masukan Tarif" value="<?php echo $row['bebas_bill'] ?>" class="form-control numeric">
													</td>
													
												<?php } ?>
											</tr>
											<tr>
												<td><strong>Keterangan (Rincian)</strong></td>
												<?php foreach ($bebas as $row) { ?>
													<td>
														<textarea name="bebas_desc" id="" class="form-control"><?php echo $row['bebas_desc'] ?></textarea>
													</td>
												<?php } ?>
											</tr>

										</tbody>
									</table>
								</div>
								<div class="box-footer">
									<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
									<button type="button" class="kembali btn btn-secondary"><i class="fa fa-angle-double-left"></i> Kembali</button>
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