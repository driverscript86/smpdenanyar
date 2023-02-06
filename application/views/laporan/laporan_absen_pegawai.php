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
            Tanggal <?= mediumdate_indo(date($daftar_absen['tgl'])) ?>
        </h5>
    </h3>
    <br />

    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Karyawan</th>
                <th>Jam Masuk</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $i = 1;
            foreach ($laporan as $d) : ?>
                <?php $san = $this->db->get_where('karyawan', ['id' => $d['id_peng']])->row_array(); ?>
                <tr>
                    <td>
                        <center><?= $i ?></center>
                    </td>
                    <td>
                        <?= $san['nama'] ?>
                    </td>
                    <td>
                        <center><?= $d['jam_masuk'] ?></center>
                    </td>
                    <td>
                        <center>
                            <?php if ($d['status'] == 1) {
                                echo 'Hadir';
                            } elseif ($d['status'] == 2) {
                                echo 'Alpha';
                            } elseif ($d['status'] == 3) {
                                echo 'Sakit';
                            } elseif ($d['status'] == 4) {
                                echo 'Izin';
                            } else {
                                echo '-';
                            }
                            ?>
                        </center>
                    </td>
                </tr>
            <?php $i++;
            endforeach ?>

        </tbody>
    </table>
</body>

</html>