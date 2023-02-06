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
									<?php echo form_open(current_url(), array('method' => 'get')) ?> <br>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
													<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
													<input class="form-control" type="date" name="ds" <?php echo (isset($q['ds'])) ? 'value="' . $q['ds'] . '"' : '' ?> placeholder="Tanggal Awal">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
													<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
													<input class="form-control" type="date" name="de" <?php echo (isset($q['de'])) ? 'value="' . $q['de'] . '"' : '' ?> placeholder="Tanggal Akhir">

												</div>
											</div>
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter Data</button>
											<?php if ($q) { ?>
												<a class="btn btn-success" href="<?php echo site_url('report_set/report' . '/?' . http_build_query($q)) ?>"><i class="fa fa-file-excel"></i> Export Excel</a>
												<a target="_blank" class="btn btn-info" href="<?php echo site_url('report_set/report_print' . '/?' . http_build_query($q)) ?>"><i class="fa fa-print"></i> Print</a>
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

		<?php if ($q) { ?>
			<div class="col-lg-12">
				<div class="card shadow mb-4">
					<div class="card-body">
						<div class="box box-success">
							<div class="box-body table-responsive">
							<table class="table table-hover display" id="mytable" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Pembayaran</th>
										<th>Nama Siswa</th>
										<th>Pendidikan</th>
										<th>Kelas</th>
										<th>Tanggal</th>
										<th>Penerimaan</th>
										<th>Pengeluaran</th>
										<th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; foreach ($bulan as $row) : ?>
									<?php if(!empty($row['majors_name'])){
											$majors = ' - ' . $row['majors_name'];
										}else{
											$majors = '';
										} ?>
										<tr>
											<td><?= $i; ?></td>
											<td><?= $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'] . ' - ' . '(' . $row['month_name'] . ')' ?></td>
											<td><?= $row['nama'] ?></td>
											<td><?= $row['pend_name'] ?></td>
											<td><?= $row['class_name'] ?><?= $majors ?></td>
											<td><?= mediumdate_indo(date($row['bulan_date_pay'])) ?></td>
											<td><?= 'Rp. ' . number_format($row['bulan_bill'], 0, ',', '.') ?></td>
											<td> - </td>
											<td><?= $row['bulan_pay_desc'] ?></td>
										</tr>
									<?php $i++; endforeach; ?>
									<?php foreach ($free as $row) : ?>
									<?php if(!empty($row['majors_name'])){
										$majors = ' - ' . $row['majors_name'];
									}else{
										$majors = '';
									} ?>
										<tr>
											<td><?= $i; ?></td>
											<td><?= $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'] ?></td>
											<td><?= $row['nama'] ?></td>
											<td><?= $row['pend_name'] ?></td>
											<td><?= $row['class_name'] ?><?= $majors ?></td>
											<td><?= mediumdate_indo(date($row['bebas_pay_input_date'])) ?></td>
											<td><?= 'Rp. ' . number_format($row['bebas_pay_bill'], 0, ',', '.') ?></td>
											<td> - </td>
											<td><?= $row['bebas_pay_desc'] ?></td>
										</tr>
									<?php $i++; endforeach; ?>
									<?php foreach ($kredit as $row) : ?>
										<tr>
											<td><?= $i; ?></td>
											<td> Pengeluaran </td>
											<td> - </td>
											<td> - </td>
											<td> - </td>
											<td><?= mediumdate_indo(date($row['kredit_date'])) ?></td>
											<td> - </td>
											<td><?= 'Rp. ' . number_format($row['kredit_value'], 0, ',', '.') ?></td>
											<td><?= $row['kredit_desc'] ?></td>
										</tr>
									<?php $i++; endforeach; ?>
									<?php foreach ($debit as $row) : ?>
										<tr>
											<td><?= $i; ?></td>
											<td> Pemasukan </td>
											<td> - </td>
											<td> - </td>
											<td> - </td>
											<td><?= mediumdate_indo(date($row['debit_date'])) ?></td>
											<td><?= 'Rp. ' . number_format($row['debit_value'], 0, ',', '.') ?></td>
											<td> - </td>
											<td><?= $row['debit_desc'] ?></td>
										</tr>
									<?php $i++; endforeach; ?>
								</tbody>

							</table>
							</div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>
			</div>
		<?php  } ?>

	</div>
</div>