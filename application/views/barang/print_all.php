<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data BTTD KAL</title>
    <style>
        /* CSS untuk atur tabel */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div style="display: flex;">
        <!-- Gambar/Logo -->
        <div style="position: relative;">
            <img src="<?= base_url('assets/img/kal.png') ?>" style="width: 150px; height: 60px;">
        </div>
        <h2>Data BTTD PT. Krakatau Argo Logistics</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 15%;">No BTTD</th>
                    <th style="width: 20%;">Nama Vendor</th>
                    <th style="width: 10%;">Nomor Invoice</th>
                    <th style="width: 10%;">Nilai Invoice</th>
                    <th style="width: 10%;">Tanggal Invoice</th>
                    <th style="width: 10%;">Nomor SPK</th>
                    <th style="width: 10%;">Nomor LHP</th>
                    <th style="width: 10%;">Nomor Faktur Pajak</th>
                    <th style="width: 10%;">Tanggal Faktur Pajak</th>
                    <th style="width: 10%;">Keterangan Invoice</th>
                    <th style="width: 10%;">Tanggal Diterima</th>
                    <th style="width: 5%;">Status</th>
                    <th style="width: 5%;">Catatan</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($barang) :
                    $no = 1;
                    foreach ($barang as $b) :
                ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $b['id_vendor']; ?></td>
                            <td><?= $b['nama_vendor']; ?></td>
                            <td><?= $b['no_invoice']; ?></td>
                            <td><?= $b['nilai_invoice']; ?></td>
                            <td><?= date('d-m-Y', strtotime($b['tgl_invoice'])); ?></td>
                            <td><?= $b['no_spk']; ?></td>
                            <td><?= $b['no_lhp']; ?></td>
                            <td><?= $b['no_faktur_pajak']; ?></td>
                            <td><?= date('d-m-Y', strtotime($b['tgl_faktur_pajak'])); ?></td>
                            <td><?= $b['keterangan_invoice']; ?></td>
                            <td>
                                <?php if (!empty($b['tgl_diterima'])) : ?>
                                    <?= date('d-m-Y', strtotime($b['tgl_diterima'])); ?>
                                <?php else : ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?= $b['status']; ?></td>
                            <td><?= $b['catatan']; ?></td>
                        </tr>
                    <?php endforeach;
                else : ?>
                    <tr>
                        <td colspan="14" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
</body>

</html>