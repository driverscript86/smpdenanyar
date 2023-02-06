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
    <section>
        <br />
        <h3 align="center">Laporan data Konseling <?= $siswa['nama'] ?>
        </h3>
        <h5> Topik : <?= $konseling['topik'] ?><br /> Solusi : <?= $konseling['solusi'] ?></h5>
        <table border="1" cellspacing="0" cellpadding="5" width="100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pengirim</th>
                    <th>Balasan</th>
                    <th>Tanggal</th>
                    <th>waktu</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 1;
                foreach ($laporan as $d) : ?>
                    <?php $peng = $this->db->get_where('karyawan', ['id' => $d['id_peng']])->row_array(); ?>
                    <tr>
                        <td>
                            <center><?= $i ?></center>
                        </td>
                        <td>
                            <?php if ($d['pengirim'] == 'Karyawan') : ?>
                                <?= $peng['nama'] ?>
                            <?php elseif ($d['pengirim'] == 'siswa') : ?>
                                <?= $siswa['nama'] ?>
                            <?php endif ?>
                        </td>
                        <td>
                            <?= $d['balasan'] ?>
                        </td>
                        <td>
                            <center><?= $d['tgl'] ?></center>
                        </td>
                        <td>
                            <center><?= $d['waktu'] ?></center>
                        </td>
                    </tr>
                <?php $i++;
                endforeach ?>

            </tbody>
        </table>
        <br />
        <br />
        <h5>Tanggal Pengajuan : <?= mediumdate_indo(date($konseling['tgl_pengajuan'])) ?><br />
            Tanggal Tutup : <?= mediumdate_indo(date($konseling['tgl_tutup'])) ?><br />
            Penutup : <?= $konseling['penutup'] ?>
        </h5>
    </section>
</body>

</html>