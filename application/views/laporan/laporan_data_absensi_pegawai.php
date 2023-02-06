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
                <th>Nama </th>
                <th>Sekolah</th>
                <th>Divisi</th>
                <th>Hadir</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $i = 1;
            foreach ($karyawan as $d) : ?>

                <?php $pend = $this->db->get_where('data_pendidikan', ['id' => $d['id_pend']])->row_array(); ?>
                <?php $divi = $this->db->get_where('data_divisi', ['id' => $d['id_divisi']])->row_array(); ?>

                <?php
                $this->db->where('tgl >=', $tgl_awal);
                $this->db->where('tgl <=', $tgl_akhir);
                ?>
                <?php $sum_hadir = $this->db->get_where('absen_pegawai', ['status' => '1', 'id_peng' => $d['id']])->num_rows(); ?>

                <tr>
                    <td>
                        <center><?= $i ?></center>
                    </td>
                    <td>
                        <?= $d['nama'] ?>
                    </td>
                    <td>
                        <center><?= $pend['nama'] ?></center>
                    </td>
                    <td>
                        <center><?= $divi['nama'] ?></center>
                    </td>
                    <td>
                        <center><?= $sum_hadir ?></center>
                    </td>
                </tr>
            <?php $i++;
            endforeach ?>

        </tbody>
    </table>
</body>

</html>