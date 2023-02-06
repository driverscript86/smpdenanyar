<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        html,
        body {
            font-size: 12px;
        }

        @page {
            margin: 25px;
        }

        header {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        table {
            width: 100%;
            border: 1px solid #000000;
            border-collapse: collapse;
        }

        table tr th,
        table tr td {
            border: 1px solid #000000;
            padding: 4px 8px;
        }
    </style>
</head>
<?php $id     = $this->input->get('id');
$gaji = $this->db->get_where('penggajian', ['id' => $id])->row_array();
$cicilan = $this->db->get_where('data_cicilan', ['id_peng' => $gaji['id_peng'], 'tenor !=' => 0])->result_array();
$kar = $this->db->get_where('karyawan', ['id' => $gaji['id_peng']])->row_array();
$div = $this->db->get_where('data_divisi', ['id' => $gaji['id_divisi']])->row_array();
?>

<body>
    <div style="border: 1px dashed #333333; padding: 5px">
        <div style="border: 1px solid #333333; padding: 5px">
            <header>
                <div>SLIP GAJI KARYAWAN</div>
                <div>Periode Tanggal : <?= mediumdate_indo(date($gaji['tgl_awal'])); ?> - <?= mediumdate_indo(date($gaji['tgl_akhir'])); ?></div>
            </header>
            <hr>
            <div style="padding: 10px 0"><strong>Informasi Karyawan</strong></div>
            <table>
                <tr>
                    <td width="25.8%">Nama Karyawan</td>
                    <td><strong><?= $kar['nama'] ?></strong></td>
                    <td width="15.8%">Divisi</td>
                    <td width="15.8%"><strong><?= $div['nama'] ?></strong></td>
                </tr>
                <tr>
                    <td width="25.8%">No Telepon</td>
                    <td colspan="3"><strong><?= $kar['telp']; ?></strong></td>
                </tr>
                <tr>
                    <td width="25.8%">Departemen</td>
                    <td colspan="3"><strong><?= $kar['dept'] ?></strong></td>
                </tr>
            </table>
            <div style="padding: 10px 0"><strong>Informasi Absensi</strong></div>
            <table>
                <tr>
                    <td style="text-align: center; width: 20%">Hadir</td>
                    <td style="text-align: center; width: 20%">Sakit</td>
                    <td style="text-align: center; width: 20%">Izin</td>
                    <td style="text-align: center; width: 20%">Alpa</td>
                    <td style="text-align: center; width: 20%">Total Jam</td>
                </tr>
                <?php

                $this->db->where('tgl >=', $gaji['tgl_awal']);
                $this->db->where('tgl <=', $gaji['tgl_akhir']);
                $this->db->where('id_peng', $gaji['id_peng']);
                $this->db->where('status', 1);
                $sum_hadir = $this->db->get('absen_pegawai')->num_rows();

                $this->db->where('tgl >=', $gaji['tgl_awal']);
                $this->db->where('tgl <=', $gaji['tgl_akhir']);
                $this->db->where('id_peng', $gaji['id_peng']);
                $this->db->where('status', 2);
                $sum_alpa = $this->db->get('absen_pegawai')->num_rows();

                $this->db->where('tgl >=', $gaji['tgl_awal']);
                $this->db->where('tgl <=', $gaji['tgl_akhir']);
                $this->db->where('id_peng', $gaji['id_peng']);
                $this->db->where('status', 3);
                $sum_sakit = $this->db->get('absen_pegawai')->num_rows();

                $this->db->where('tgl >=', $gaji['tgl_awal']);
                $this->db->where('tgl <=', $gaji['tgl_akhir']);
                $this->db->where('id_peng', $gaji['id_peng']);
                $this->db->where('status', 4);
                $sum_izin = $this->db->get('absen_pegawai')->num_rows();

                //sum jam mengajar
                $this->db->select_sum('sum_jam');
                $this->db->where('tgl >=', $gaji['tgl_awal']);
                $this->db->where('tgl <=', $gaji['tgl_akhir']);
                $sum_jam = $this->db->get_where('absen_pegawai', ['id_peng' => $gaji['id_peng']])->row_array();
                ?>
                <tr>
                    <td>
                        <center><?= $sum_hadir ?></center>
                    </td>
                    <td>
                        <center><?= $sum_sakit ?></center>
                    </td>
                    <td>
                        <center><?= $sum_izin ?></center>
                    </td>
                    <td>
                        <center><?= $sum_alpa ?></center>
                    </td>
                    <td>
                        <center><?= $sum_jam['sum_jam'] ?> Jam</center>
                    </td>
                </tr>
            </table>
            <div style="padding: 10px 0"><strong>Informasi Gaji</strong></div>
            <table>
                <tr>
                    <td colspan="3"><strong>Gaji Pokok</strong></td>
                    <td><?= "Rp " . number_format($div['gaji'], 0, '', '.')  ?></td>
                </tr>
                <tr>
                    <?php $tot_jam = $kar['nominal_jam'] * $sum_jam['sum_jam']; ?>
                    <td width="25.8%"><strong>Total Jam</strong></td>
                    <td></td>
                    <td width="15.8%"><?= number_format($kar['nominal_jam'], 0, '', '.') ?> x <?= $sum_jam['sum_jam'] ?></td>
                    <td width="15.8%"><?= "Rp " . number_format($tot_jam, 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="4">*) Insentif & Tunjangan (+)</td>
                </tr>
                <tr>
                    <?php $tot_inten = $kar['intensif'] * $sum_hadir; ?>
                    <td width="25.8%">- Intensif</td>
                    <td></td>
                    <td width="15.8%"><?= number_format($kar['intensif'], 0, '', '.') ?> x <?= $sum_hadir ?></td>
                    <td width="15.8%"><?= "Rp " . number_format($kar['intensif'] * $sum_hadir, 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="3">- Tunjangan</td>
                    <td><?= "Rp " . number_format($div['tunjangan'], 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="4">*) Potongan (-)</td>
                </tr>
                <tr>
                    <td colspan="3">- Bpjs</td>
                    <td><?= "Rp " . number_format($kar['bpjs'], 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="3">- Koperasi</td>
                    <td><?= "Rp " . number_format($kar['koperasi'], 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="3">- Simpanan</td>
                    <td><?= "Rp " . number_format($kar['simpanan'], 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="3">- Tabungan</td>
                    <td><?= "Rp " . number_format($kar['tabungan'], 0, '', '.') ?></td>
                </tr>

                <?php $sum_bkst = $kar['bpjs'] + $kar['koperasi'] + $kar['simpanan'] + $kar['tabungan']; ?>

                <tr>
                    <td colspan="4">*) Potongan Cicilan (-)</td>
                </tr>
                <?php $sum = 0;
                foreach ($cicilan as $cic) : ?>
                    <?php $sum += $cic['nominal']; ?>
                    <?php $tot_tenor = $cic['nominal'] * $cic['tenor']; ?>
                    <tr>
                        <td>- <?= $cic['nama'] ?></td>
                        <td>Sisa Tenor : <?= $cic['tenor'] ?></td>
                        <td width="25.8%">Total : <?= "Rp " . number_format($tot_tenor, 0, '', '.') ?></td>
                        <td width="15.8%">
                            <st><?= "Rp " . number_format($cic['nominal'], 0, '', '.') ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                <?php
                $jumlah_gaji = $div['gaji'] + $div['tunjangan'] +  $tot_inten + $kar['nominal_jam'] * $sum_jam['sum_jam'];
                ?>
                <?php $tot_gaji = $jumlah_gaji - $sum - $sum_bkst; ?>
                <tr>
                    <td colspan="3"><strong>Gaji Total</strong></td>
                    <td style="text-align: center" width="16.8%"><strong><?= "Rp " . number_format($tot_gaji, 0, '', '.') ?></strong></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>