<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>

    <style type="text/css">
        table {
            border-left: 0.01em solid black;
            border-right: 0;
            border-top: 0.01em solid black;
            border-bottom: 0;
            border-collapse: collapse;
        }

        table td,
        table th {
            border-left: 0;
            border-right: 0.01em solid black;
            border-top: 0;
            border-bottom: 0.01em solid black;
        }
    </style>
</head>

<body>
    <br />
    <h3 align="center">Laporan Absen Pegawai
        <h5>
            Tanggal <?= mediumdate_indo(date($tgl_awal)) ?> - <?= mediumdate_indo(date($tgl_akhir)) ?>
        </h5>
    </h3>
    <br />

    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Karyawan</th>
                <th>Jumlah Hari Absen</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $i = 1;
            foreach ($karyawan as $d) : ?>
                <?php
                $this->db->where('tgl >=', $tgl_awal);
                $this->db->where('tgl <=', $tgl_akhir);
                ?>
                <?php $kar = $this->db->get_where('absen_pegawai', ['id_peng' => $d['id']])->row_array(); ?>
                <?php
                $this->db->where('tgl >=', $tgl_awal);
                $this->db->where('tgl <=', $tgl_akhir);
                ?>
                <?php $sum_absen = $this->db->get_where('absen_pegawai', ['id_peng' => $d['id']])->num_rows(); ?>
                <?php
                $this->db->where('tgl >=', $tgl_awal);
                $this->db->where('tgl <=', $tgl_akhir);
                ?>
                <?php $sum_hadir = $this->db->get_where('absen_pegawai', ['status' => '1', 'id_peng' => $d['id']])->num_rows(); ?>
                <?php
                $this->db->where('tgl >=', $tgl_awal);
                $this->db->where('tgl <=', $tgl_akhir);
                ?>
                <?php $sum_alpa = $this->db->get_where('absen_pegawai', ['status' => '2', 'id_peng' => $d['id']])->num_rows(); ?>
                <?php
                $this->db->where('tgl >=', $tgl_awal);
                $this->db->where('tgl <=', $tgl_akhir);
                ?>
                <?php $sum_sakit = $this->db->get_where('absen_pegawai', ['status' => '3', 'id_peng' => $d['id']])->num_rows(); ?>
                <?php
                $this->db->where('tgl >=', $tgl_awal);
                $this->db->where('tgl <=', $tgl_akhir);
                ?>
                <?php $sum_izin = $this->db->get_where('absen_pegawai', ['status' => '4', 'id_peng' => $d['id']])->num_rows(); ?>
                <tr>
                    <td>
                        <center><?= $i ?></center>
                    </td>
                    <td>
                        <?= $d['nama'] ?>
                    </td>
                    <td>
                        <center><?= $sum_absen ?></center>
                    </td>
                    <td>
                        <center><?= $sum_hadir ?></center>
                    </td>
                    <td>
                        <center><?= $sum_izin ?></center>
                    </td>
                    <td>
                        <center><?= $sum_sakit ?></center>
                    </td>
                    <td>
                        <center><?= $sum_alpa ?></center>
                    </td>
                </tr>
            <?php $i++;
            endforeach ?>

        </tbody>
    </table>
</body>

</html>