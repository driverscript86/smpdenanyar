<!DOCTYPE html>
<html>

<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="<?php echo media_url('css/bootstrap.min.css') ?>">
</head>

<body>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
			<table class="table table-hover table-striped table-bordered" id="mytable">
				<thead>
					<tr>
						<th>No</th>
						<th>Bulan</th>
						<th class="text-center">Data Bayar</th>
						<th class="text-center">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; foreach ($bulan as $row) : ?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td class="text-left"><b><?= $row['month_name']; ?></b></td>
							<td style="color:aliceblue" class="<?= ($row['bulan_status'] == 1) ? 'bg-success' : 'bg-danger' ?> text-center">
								<b><?= ($row['bulan_status'] == 1) ?  mediumdate_indo(date($row['bulan_date_pay'])) : 'Rp.' .number_format($row['bulan_bill'], 0, ',', '.') ?></b>
							</td>
							<td class="text-center"><button class="btn btn-xs btn-<?= ($row['bulan_status'] == 1) ? 'success' : 'danger' ?>"><?= ($row['bulan_status'] == 1) ? 'Lunas' : 'Belum Lunas' ?></button></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
		</div>
	</section>
</body>

</html>