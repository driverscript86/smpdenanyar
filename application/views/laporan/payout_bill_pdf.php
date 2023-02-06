<html>

<head>
  <?php foreach ($siswa as $row) : ?>
    <title>Detail Rincian Tagihan - <?= $row['nama'] ?></title>
  <?php endforeach ?>
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
  <div class="title">RINCIAN PEMBAYARAN ADMINISTRASI</div>
  <div class="tp"> TAHUN PELAJARAN <?php foreach ($period as $row) : ?> <?= ($f['n'] == $row['id']) ? $row['period_start'] . '/' . $row['period_end'] : '' ?><?php endforeach; ?></div>

  <table width="100%" border="0">
    <tr>
      <td width="100">NISN</td>
      <td width="5">:</td>
      <?php foreach ($siswa as $row) : ?>
        <td width=""><?= $row['nis'] ?></td>
      <?php endforeach; ?>
    </tr>
    <tr>
      <td>Nama Lengkap</td>
      <td>:</td>
      <?php foreach ($siswa as $row) : ?>
        <td><?= $row['nama'] ?></td>
      <?php endforeach; ?>
    </tr>
    <tr>
      <td>Kelas</td>
      <td>:</td>
      <?php foreach ($siswa as $row) : ?>
        <td><?= $row['class_name'] ?></td>
      <?php endforeach; ?>
    </tr>
    <?php foreach ($siswa as $row) : ?>
    <?php if(!empty($row['id_majors'])) : ?>
      <tr>
        <td>Jurusan</td>
        <td>:</td>
        <td><?= $row['majors_name'] ?></td>
      </tr>
    <?php endif;
          endforeach; ?>
  </table><br>
  <?php if ($f['n'] and $f['r'] != NULL) { ?>
    <table width="100%" style="font-size: 10px;" border="1">
      <tr>
        <th style="height: 30px;">NO</th>
        <th>NAMA PEMBAYARAN</th>
        <th>TANGGAL PEMBAYARAN</th>
        <th>BIAYA</th>
        <th>KETERANGAN</th>
      </tr>
      <?php
      $i = 1;
      foreach ($bulan as $row) :
        // $namePay = $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'];
        $namePay = $row['pos_name'];
        $mont = ($row['month_month_id'] <= 6) ? $row['period_start'] : $row['period_end'];
      ?>
        <tr>
          <td style="text-align: center;"><?= $i ?></td>
          <td style="white-space: nowrap; padding:0 5px;"><?= $namePay . ' - (' . $row['month_name'] . ' ' . $mont . ')' ?></td>
          <td style="padding:0 5px; text-align: <?= ($row['bulan_status'] == 1) ? 'left' : ''; ?>;"><?= ($row['bulan_status'] == 1) ? pretty_date($row['bulan_date_pay'], 'd F Y', false) : '-' ?></td>
          <td style="padding:0 5px; white-space: nowrap;"><?= ($row['bulan_status'] == 0) ? 'Rp. ' . number_format($row['bulan_bill'], 0, ',', '.') : 'Rp. -' ?></td>
          <td style="padding:0 5px;"><?= ($row['bulan_status'] == 1) ? 'Lunas' : 'Belum Lunas' ?></td>
        </tr>
      <?php
        $i++;
      endforeach
      ?>
      <?php
      $j = $i;
      foreach ($bebas as $row) :
        // $namePayFree = $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'];
        $namePayFree = $row['pos_name'];
      ?>
        <tr>
          <td style="text-align: center;"><?= $j ?></td>
          <td style="padding:0 5px;"><?= $namePayFree ?></td>
          <td style="padding:0 5px; text-align: <?= ($row['bebas_total_pay'] > 0) ? 'left' : '' ?>"><?= ($row['bebas_total_pay'] > 0) ? pretty_date($row['bebas_last_update'], 'd F Y', false) : '-'  ?></td>
          <td style="padding:0 5px;"><?= ($row['bebas_bill'] - $row['bebas_total_pay'] != 0) ? 'Rp. ' . number_format($row['bebas_bill'] - $row['bebas_total_pay'], 0, ',', '.') : 'Rp. -' ?></td>
          <td style="word-break:break-all; word-wrap:break-word; padding:0 5px;">
            <?= ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'Lunas' : 'Belum Lunas' ?>
            <?php if ($row['bebas_desc'] == NULL) { ?>
            <?php  } else { ?>
              <br>
              <b style="font-size: 9px;"><u>RINCIAN TAGIHAN: </u><br><i><?= $row['bebas_desc'] ?></i></b>
            <?php } ?>
          </td>
        </tr>
      <?php
        $j++;
      endforeach
      ?>

    </table>
  <?php } else redirect('manage/payout?n=' . $f['n'] . '&r=' . $f['r'])  ?>
  <table style="width:100%; margin-top: 25px; font-size: 10pt; ">
    <tr>
      <td><span class="cap"><?= $web['kab'] ?></span>, <?= pretty_date(date('Y-m-d'), 'd F Y', false) ?></td>
    </tr>
    <br />
    <tr>
      <td>Petugas :</td>
    </tr>

  </table>
  <br><br><br><br>
  <table width="100%" style="font-size: 10pt;">
    <tr>
      <td><strong><u><span class="upper">( <?= $user['nama']; ?> )</span></u></strong></td>
    </tr>
  </table>


</body>

</html>