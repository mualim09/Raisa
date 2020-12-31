<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">emoji_transportation</i>
                        </div>
                        <h4 class="card-title">Data Reservasi</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Jenis</th>
                                        <th>Kendaraan</th>
                                        <th>Nama <small>(<i>Pemohon</i>)</small></th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Berangkat</th>
                                        <th>Kembali</th>
                                        <th class="disabled-sorting text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Jenis</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Berangkat</th>
                                        <th>Kembali</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($reservasi as $rsv) : ?>
                                        <?php if ($rsv['tglberangkat'] < date('Y-m-d')) {
                                            echo '<tr class="text-dark bg-danger">';
                                            } else {
                                            echo '<tr>';
                                            } ?>
                                            <td><?= $rsv['id']; ?></td>
                                            <td><?= $rsv['jenis_perjalanan']; ?></td>
                                            <td><?= $rsv['nopol']; ?>
                                                <?php if ($rsv['kendaraan'] == 'Taksi') { ?>
                                                    <br /><span class="badge badge-success"><?= $rsv['kendaraan']; ?></span></td>
                                                <?php } elseif ($rsv['kendaraan'] == 'Sewa') { ?>
                                                    <br /><span class="badge badge-warning"><?= $rsv['kendaraan']; ?></span></td>
                                                <?php } elseif ($rsv['kendaraan'] == 'Pribadi') { ?>
                                                    <br /><span class="badge badge-danger"><?= $rsv['kendaraan']; ?></span></td>
                                                <?php } else { ?>
                                                    <br /><span class="badge badge-info"><?= $rsv['kendaraan']; ?></span></td>
                                                <?php }; ?>
                                        <td><?= $rsv['nama']; ?></td>
                                        <td><?= $rsv['anggota']; ?></td>
                                        <td><?= $rsv['tujuan']; ?></td>
                                        <td><?= $rsv['keperluan']; ?></td>
                                        <td><?= date('d M Y', strtotime($rsv['tglberangkat'])) . '</br>' . date('H:i', strtotime($rsv['jamberangkat'])); ?></td>
                                        <td><?= date('d M Y', strtotime($rsv['tglkembali'])) . '</br>' . date('H:i', strtotime($rsv['jamkembali'])); ?></td>
                                        <td class="text-right">
                                            <a href="<?= base_url('perjalanan/ta/id/') . $rsv['id']; ?>" class="btn btn-sm btn-block btn-round btn-success">Proses</a>
                                            <a href="" class="btn btn-sm btn-block btn-round btn-danger" data-toggle="modal" data-target="#batalRsv" data-id="<?= $rsv['id']; ?>">Batalkan</a>
                                        </td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<!-- Modal -->
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalRsvTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Pembatalan Perjalanan Dinas</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('perjalanandl/batalrsv/'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-4 col-form-label">No. Reservasi</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id" id="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Alasan Pembatalan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control" name="catatan" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-danger btn-round btn-wd btn-sm">BATALKAN PERJALANAN INI!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>