<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Data Perjalanan Dinas Luar</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dtperjalanan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
                                        <th>Kendaraan</th>
                                        <th>Nama <small>(<i>Pemohon</i>)</small></th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Waktu Keberangkatan</th>
                                        <th>Catatan Security</th>
                                        <th class="disabled-sorting"></th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Waktu Keberangkatan</th>
                                        <th>Catatan Security</th>
                                        <th></th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $pdl) : ?>
                                        <tr>
                                            <td><?= $pdl['id']; ?></td>
                                            <td><?= $pdl['jenis_perjalanan']; ?></td>
                                            <td><?= $pdl['nopol']; ?>
                                                <?php if ($pdl['kepemilikan'] == 'Operasional') { ?>
                                                    <br /><span class="badge badge-success"><?= $pdl['kepemilikan']; ?></span></td>
                                        <?php } elseif ($pdl['kepemilikan'] == 'Taksi') { ?>
                                            <br /><span class="badge badge-warning"><?= $pdl['kepemilikan']; ?></span></td>
                                        <?php } elseif ($pdl['kepemilikan'] == 'Sewa') { ?>
                                            <br /><span class="badge badge-danger"><?= $pdl['kepemilikan']; ?></span></td>
                                        <?php } else { ?>
                                            <br /><span class="badge badge-info"><?= $pdl['kepemilikan']; ?></span></td>
                                        <?php }; ?>
                                        <td><?= $pdl['nama']; ?></td>
                                        <td><?= $pdl['tujuan']; ?></td>
                                        <td><?= $pdl['keperluan']; ?></td>
                                        <td><?= $pdl['anggota']; ?></td>
                                        <td><?= $pdl['tglberangkat'] . ' ' . $pdl['jamberangkat']; ?></td>
                                        <td><?= $pdl['catatan_security']; ?></td>
                                        <td class="text-right">
                                            <a href="<?= base_url('perjalanandl/do_revisi/') . $pdl['id']; ?>" class="btn btn-sm btn-success">REVISI</a>
                                        </td>
                                        <td class="text-right">
                                            <a href="<?= base_url('perjalanandl/bataldl/') . $pdl['id']; ?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#batalDl" data-id="<?= $pdl['id']; ?>">Batalkan</a>
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
<div class="modal fade" id="batalDl" tabindex="-1" role="dialog" aria-labelledby="batalDlTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">ALASAN PEMBATALAN</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('perjalanandl/bataldl'); ?>">
                    <div class="modal-body">
                        <input type="text" class="form-control disabled" name="id">
                        <textarea rows="2" class="form-control" name="catatan" required></textarea>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-danger">BATALKAN PERJALANAN INI!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>