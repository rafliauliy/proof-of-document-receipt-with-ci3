<?= $this->session->flashdata('pesan'); ?>

<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="col-auto">
            <a href="<?= base_url('barang') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                <span class="icon">
                    <i class="fa fa-arrow-left"></i>
                </span>
                <span class="text">
                    Kembali
                </span>
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if ($barang) : ?>
            <?php foreach ($barang as $b) : ?>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5 class="font-weight-bold">Detail BTTD <?= $b['id_vendor']; ?></h5>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <td><strong>Nama Vendor:</strong></td>
                                <td><?= $b['nama_vendor']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Invoice:</strong></td>
                                <td><?= $b['no_invoice']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nilai Invoice / Kuitansi:</strong></td>
                                <td><?= $b['nilai_invoice']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Invoice:</strong></td>
                                <td><?= date('d-m-Y', strtotime($b['tgl_invoice'])); ?></td>
                            </tr>

                            <tr>
                                <td><strong>Nomor SPK / PO / SPPB / Kontrak:</strong></td>
                                <td><?= $b['no_spk']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nomor LHP / LPB:</strong></td>
                                <td><?= $b['no_lhp']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Faktur Pajak:</strong></td>
                                <td><?= $b['no_faktur_pajak']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Faktur Pajak:</strong></td>
                                <td><?= date('d-m-Y', strtotime($b['tgl_faktur_pajak'])); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Keterangan Invoice:</strong></td>
                                <td><?= $b['keterangan_invoice']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Invoice:</strong></td>
                                <td style="white-space: nowrap;">
                                    <?php if ($b['pdf_invoice']) : ?>
                                        <a href="<?= base_url('uploads/' . $b['pdf_invoice']); ?>" target="_blank">Open Invoice</a>
                                    <?php else : ?>
                                        No Invoice
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Faktur Pajak:</strong></td>
                                <td style="white-space: nowrap;">
                                    <?php if ($b['pdf_faktur_pajak']) : ?>
                                        <a href="<?= base_url('uploads/' . $b['pdf_faktur_pajak']); ?>" target="_blank">Open Faktur Pajak</a>
                                    <?php else : ?>
                                        No Faktur Pajak
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Diterima:</strong></td>
                                <td>
                                    <?php if (!empty($b['tgl_diterima'])) : ?>
                                        <?= date('d-m-Y', strtotime($b['tgl_diterima'])); ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td><?= $b['status']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Catatan:</strong></td>
                                <td><?= $b['catatan']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status Pembayaran:</strong></td>
                                <td><?= $b['status_pembayaran']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Bukti Potong PPH : </strong></td>
                                <td style="white-space: nowrap;">
                                    <?php if ($b['bukti_potong']) : ?>
                                        <a href="<?= base_url('uploads/' . $b['bukti_potong']); ?>" target="_blank">Bukti Potong PPH</a>
                                    <?php else : ?>
                                        Bukti Potong PPH Belum Di Upload Oleh Finance
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if (is_admin()) : ?>
                                <tr>
                                    <td><strong>ID Pemilik</strong></td>
                                    <td><?= $b['id_user']; ?></td>
                                </tr>
                            <?php endif; ?>
                            <!-- Tambahkan detail lainnya sesuai kebutuhan -->
                        </table>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="text-center">Data Kosong</div>
        <?php endif; ?>
    </div>
</div>