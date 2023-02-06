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
    <h3 align="center">Laporan Data Perizinan <?= $pendidikan ?>
        <h4>Kelas : <?= $kelas ?><?= $jurus ?></h4>
    </h3>
    <h5> Tanggal : <?= mediumdate_indo(date($tgl_awal)) ?> - <?= mediumdate_indo(date($tgl_akhir)) ?></h5>
    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama siswa</th>
                <th>Izin</th>
                <th>Keterangan</th>
                <th>Taggal</th>
                <th>Satus</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $i = 1;
            foreach ($laporan as $d) : ?>
                <?php $san = $this->db->get_where('siswa', ['id' => $d['id_siswa']])->row_array(); ?>
                <?php $izin = $this->db->get_where('data_perizinan', ['id' => $d['id_izin']])->row_array(); ?>
                <tr>
                    <td>
                        <center><?= $i ?></center>
                    </td>
                    <td>
                        <center><?= $san['nama'] ?></center>
                    </td>
                    <td>
                        <center><?= $izin['nama'] ?></center>
                    </td>
                    <td>
                        <center><?= $d['keterangan'] ?></center>
                    </td>
                    <td>
                        <center><?= mediumdate_indo(date($d['tgl'])) ?></center>
                    </td>
                    <td>
                        <center><?= $d['status'] ?></center>
                    </td>
                </tr>
            <?php $i++;
            endforeach ?>

        </tbody>
    </table>
</body>

</html>