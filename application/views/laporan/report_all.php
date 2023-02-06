<html>

<head>
    <title>Detail Laporan Total Keuangan</title>
  <style type="text/css">
    .upper {
      text-transform: uppercase;
    }

    .lower {
      text-transform: lowercase;
    }

    .cap {
      text-transform: capitalize;
    }

    .small {
      font-variant: small-caps;
    }
  </style>
  <style type="text/css">
    .style12 {
      font-size: 9px
    }

    .style13 {
      font-size: 14pt;
      font-weight: bold;
    }

    .title {
      font-size: 14pt;
      text-align: center;
      font-weight: bold;
      padding-bottom: -20px;
    }

    .tp {
      font-size: 14pt;
      text-align: center;
      font-weight: bold;
      padding-bottom: 30px;
    }

    body {
      font-family: sans-serif;
    }

    table {
      padding-top: 10px;
      border-collapse: collapse;
      font-size: 9pt;
      width: 100%;
      padding-left: 5px;
    }

    .ket {
      word-wrap: break-word
    }
  </style>
</head>

<body>
  <div class="title">LAPORAN TOTAL KEUANGAN</div>
  <div class="tp"> <?= $web['nama'] ?></div>

  <table width="100%" border="0">
    <tr>
      <td width="100">Tanggal Laporan</td>
      <td width="5">:</td>
        <?php if(!empty($q['ds']) || !empty($q['de'])) :?>
          <td width=""><?= mediumdate_indo($q['ds']) . ' s/d ' . mediumdate_indo($q['de']) ?></td>
        <?php else : ?>
          <td width="">Semua</td>
        <?php endif ?>
    </tr>
    <tr>
      <td>Tanggal Unduh</td>
      <td>:</td>
        <td><?= mediumdate_indo(date('Y-m-d')) ?> - <?= date('h:i a') ?></td>
    </tr>
    <tr>
      <td>Pengunduhan</td>
      <td>:</td>
        <td><?= $user['nama'] ?></td>
    </tr>

  </table><br>
  <?php if ($q) { ?>
    <table width="100%" style="font-size: 10px;" border="1">
      <tr>
        <th style="height: 30px;">No.</th>
      	<th>Pembayaran</th>
        <th>Nama Siswa</th>
        <th>Pendidikan</th>
        <th>Kelas</th>
        <th>Tanggal</th>
        <th>Penerimaan</th>
        <th>Pengeluaran</th>
        <th>Keterangan</th>
      </tr>
      <tbody>
        <?php $i = 1; $sum_bulan = 0; foreach ($bulan as $row) : ?>
        <?php if(!empty($row['majors_name'])){
            $majors = ' - ' . $row['majors_name'];
          }else{
            $majors = '';
          } 
          $sum_bulan += $row['bulan_bill']; ?>
          <tr>
            <td style="text-align: center;"><?= $i; ?></td>
            <td style="white-space: nowrap; padding:0 5px;"><?= $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'] . ' - ' . '(' . $row['month_name'] . ')' ?></td>
            <td style="padding:0 5px;"><?= $row['nama'] ?></td>
            <td style="padding:0 5px;"><?= $row['pend_name'] ?></td>
            <td style="padding:0 5px;"><?= $row['class_name'] ?><?= $majors ?></td>
            <td style="padding:0 5px;"><?= mediumdate_indo(date($row['bulan_date_pay'])) ?></td>
            <td style="padding:0 5px;"><?= 'Rp. ' . number_format($row['bulan_bill'], 0, ',', '.') ?></td>
            <td style="padding:0 5px;"> - </td>
            <td style="padding:0 5px;"><?= $row['bulan_pay_desc'] ?></td>
          </tr>
        <?php $i++; endforeach; ?>

        <?php $sum_free = 0; foreach ($free as $row) : ?>
        <?php if(!empty($row['majors_name'])){
          $majors = ' - ' . $row['majors_name'];
        }else{
          $majors = '';
        } 
        $sum_free += $row['bebas_pay_bill'];?>
          <tr>
            <td style="text-align: center;"><?= $i; ?></td>
            <td style="white-space: nowrap; padding:0 5px;"><?= $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'] ?></td>
            <td style="padding:0 5px;"><?= $row['nama'] ?></td>
            <td style="padding:0 5px;"><?= $row['pend_name'] ?></td>
            <td style="padding:0 5px;"><?= $row['class_name'] ?><?= $majors ?></td>
            <td style="padding:0 5px;"><?= mediumdate_indo(date($row['bebas_pay_input_date'])) ?></td>
            <td style="padding:0 5px;"><?= 'Rp. ' . number_format($row['bebas_pay_bill'], 0, ',', '.') ?></td>
            <td style="padding:0 5px;"> - </td>
            <td style="padding:0 5px;"><?= $row['bebas_pay_desc'] ?></td>
          </tr>
        <?php $i++; endforeach; ?>

        <?php $sum_kredit = 0; foreach ($kredit as $row) : $sum_kredit += $row['kredit_value']; ?>
          <tr>
            <td style="text-align: center;"><?= $i; ?></td>
            <td style="white-space: nowrap; padding:0 5px;"> Pengeluaran </td>
            <td style="padding:0 5px;"> - </td>
            <td style="padding:0 5px;"> - </td>
            <td style="padding:0 5px;"> - </td>
            <td style="padding:0 5px;"><?= mediumdate_indo(date($row['kredit_date'])) ?></td>
            <td style="padding:0 5px;"> - </td>
            <td style="padding:0 5px;"><?= 'Rp. ' . number_format($row['kredit_value'], 0, ',', '.') ?></td>
            <td style="padding:0 5px;"><?= $row['kredit_desc'] ?></td>
          </tr>
        <?php $i++; endforeach; ?>

        <?php $sum_debit = 0; foreach ($debit as $row) : $sum_debit += $row['debit_value']; ?>
          <tr>
            <td style="text-align: center;"><?= $i; ?></td>
            <td style="white-space: nowrap; padding:0 5px;"> Pemasukan </td>
            <td style="padding:0 5px;"> - </td>
            <td style="padding:0 5px;"> - </td>
            <td style="padding:0 5px;"> - </td>
            <td style="padding:0 5px;"><?= mediumdate_indo(date($row['debit_date'])) ?></td>
            <td style="padding:0 5px;"><?= 'Rp. ' . number_format($row['debit_value'], 0, ',', '.') ?></td>
            <td style="padding:0 5px;"> - </td>
            <td style="padding:0 5px;"><?= $row['debit_desc'] ?></td>
          </tr>
        <?php $i++; endforeach; ?>
      </tbody>
    </table>
    
    <table width="100%" border="0">
        <tr>
          <td width="100">Total Pemasukan</td>
          <td width="5">:</td>
            <td width=""><?= 'Rp. ' . number_format($sum_bulan + $sum_free + $sum_debit, 0, ',', '.') ?>,-</td>
        </tr>
        <tr>
          <td>Total Pengeluaran</td>
          <td>:</td>
            <td><?= 'Rp. ' . number_format($sum_kredit, 0, ',', '.') ?>,-</td>
        </tr>
    </table>
  <?php } else { echo 'Data Kosong'; }  ?>

</body>

</html>