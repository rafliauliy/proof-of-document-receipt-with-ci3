<?php if (is_admin()) : ?>
    <?php
    // Mengambil data barang dari database (disesuaikan dengan metode yang Anda gunakan)
    $totalDataBelumDiterima = 0;
    // Ganti $barang dengan variabel yang sesuai dengan data barang Anda
    foreach ($barang as $b) {
        if (empty($b['tgl_diterima'])) {
            $totalDataBelumDiterima++;
        }
    }
    ?>
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <a class="nav-link" href="<?= base_url('user'); ?>">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total User</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $user; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <a class="nav-link" href="<?= base_url('barang'); ?>">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">BTTD Belum Diproses</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalDataBelumDiterima; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-bell fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    <?php endif; ?>
    <?= $this->session->flashdata('pesan'); ?>
    <div class="card shadow-sm border-bottom-primary">
        <div class="card-header bg-white py-3">
            <div class="row">
                <div class="col-auto">
                    <a href="<?= base_url('barang/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                        <span class="icon">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">
                            Tambah BTTD
                        </span>
                    </a>
                    <?php if (is_admin()) : ?>
                        <a href="<?= base_url('barang/print_all') ?>" class="btn btn-sm btn-danger btn-icon-split" target="_blank">
                            <span class="icon">
                                <i class="fa fa-print"></i>
                            </span>
                            <span class="text">
                                Print All Data
                            </span>
                        </a>
                        <a href="<?= base_url('barang/excel') ?>" class="btn btn-sm btn-success btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-file-excel"></i>
                            </span>
                            <span class="text">
                                Export Excel
                            </span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive w-100">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No. </th>
                            <th style="width: 15%;">No BTTD</th>
                            <th style="width: 20%;">Nama Vendor</th>
                            <th style="width: 10%;">Nomor Invoice</th>
                            <th style="width: 10%;">Tanggal Invoice</th>
                            <th style="width: 10%;">Tanggal Diterima</th>
                            <th style="width: 5%;">Status</th>
                            <th style="width: 5%;">Status Pembayaran</th>
                            <th style="width: 5%;">Bukti Potong PPH</th>
                            <th style="width: 5%;">View Detail</th>
                            <th style="width: 5%;">Edit</th>
                            <th style="width: 5%;">Print</th>
                            <th style="width: 5%;">Hapus</th>
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
                                    <td><?= date('d-m-Y', strtotime($b['tgl_invoice'])); ?></td>
                                    <td>
                                        <?php if (!empty($b['tgl_diterima'])) : ?>
                                            <?= date('d-m-Y', strtotime($b['tgl_diterima'])); ?>
                                        <?php else : ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $b['status']; ?></td>
                                    <td><?= $b['status_pembayaran']; ?></td>
                                    <td style="white-space: nowrap;">
                                        <?php if ($b['bukti_potong']) : ?>
                                            <a href="<?= base_url('uploads/' . $b['bukti_potong']); ?>" target="_blank">Bukti Potong PPH</a>
                                        <?php else : ?>
                                            Bukti Potong PPH Belum Di Upload
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('barang/data_detail/') . $b['id_vendor'] ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('barang/edit/') . $b['id_vendor'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('barang/printData/' . $b['id_vendor']) ?>" target="_blank" class="btn btn-info btn-sm" onclick="window.open(this.href,'_blank');return false;"><i class="fa fa-print"></i></a>
                                    </td>
                                    <td>
                                        <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barang/delete/') . $b['id_vendor'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else : ?>
                            <tr>
                                <td colspan="15" class="text-center">
                                    Data Kosong
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>