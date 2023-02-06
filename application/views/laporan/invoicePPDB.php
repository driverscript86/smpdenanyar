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
<body>
    <div style="border: 1px dashed #333333; padding: 5px">
        <div style="border: 1px solid #333333; padding: 5px">
            <header>
                <div>INVOICE DAFTAR ULANG PPDB</div>
                <div><strong>"<?= $web['nama'] ?>"</strong></div>
                <div style="font-size:12px"><?= $web['alamat'] ?></div>
                <div style="font-size:11px">No Telp : <?= $web['telp'] ?> Email : <?= $web['email'] ?></div>
            </header>
            <hr>
            <div style="padding: 10px 0"><strong>Informasi Siswa</strong></div>
            <table>
                <tr>
                    <td width="25.8%">Nama Siswa</td>
                    <td><strong><?= $user['nama'] ?></strong></td>
                    <td colspan="2">Tanggal : <?= mediumdate_indo(date($user['date_inv'])) ?></td>
                </tr>
                <tr>
                    <td width="25.8%">Email</td>
                    <td><strong><?= $user['email']; ?></strong></td>
                    <td width="15.8%">Status Pembayaran</td>
                    <?php if($user['inv'] == 1) : ?>
                        <td width="15.8%"><strong>LUNAS</strong></td>
                    <?php else : ?>
                        <td width="15.8%"><strong>BELUM LUNAS</strong></td>
                    <?php endif ?>
                </tr>
                <tr>
                    <td width="25.8%">No Hp</td>
                    <td colspan="3"><strong><?= $user['no_hp'] ?></strong></td>
                </tr>
            </table>
            <div style="padding: 10px 0"><strong>Informasi Pembayaran</strong></div>
            <table>
                <?php $sum = 0;
                foreach ($pay as $p) : ?>
                    <?php $sum += $p['jumlah']; ?>
                    <tr>
                        <td colspan="3"><?= $p['nama'] ?></td>
                        <td><?= "Rp " . number_format($p['jumlah'], 0, '', '.') ?></td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td colspan="3"><strong>Total Pembayaran</strong></td>
                    <td width="16.8%"><strong><?= "Rp " . number_format($sum, 0, '', '.') ?></strong></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>