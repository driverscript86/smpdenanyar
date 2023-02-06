<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
</head>

<body>
    <br />
    <h3 align="center">Laporan Data Pelanggaran <?= $pendidikan ?>
        <h4>Kelas : <?= $kelas ?><?= $jurus ?> </h4>
    </h3>
    <h5> Tanggal : <?= mediumdate_indo(date($tgl_awal)) ?> - <?= mediumdate_indo(date($tgl_akhir)) ?></h5>
    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama siswa</th>
                <th>Pelanggaran</th>
                <th>Point (-)</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($laporan as $d) : ?>
                <?php $san = $this->db->get_where('siswa', ['id' => $d['id_siswa']])->row_array(); ?>
                <?php $pelang = $this->db->get_where('data_pelanggaran', ['id' => $d['id_pelang']])->row_array(); ?>

                <tr>
                    <td>
                        <center><?= $i ?></center>
                    </td>
                    <td>
                        <?= $san['nama'] ?>
                    </td>
                    <td>
                        <center><?= $pelang['nama'] ?></center>
                    </td>
                    <td>
                        <center><?= $pelang['point'] ?></center>
                    </td>
                    <td>
                        <center><?= mediumdate_indo(date($d['tgl'])) ?></center>
                    </td>
                </tr>
            <?php $i++;
            endforeach ?>

        </tbody>
    </table>
</body>

</html>