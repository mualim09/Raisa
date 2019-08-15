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
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Nama <small>(<i>Pemohon</i>)</small></th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tanggal Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Jam Kembali</th>
                                        <th>Nomor Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>Tgl Kembali</th>
                                        <th>Jam Kembali</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $perjalanan = $this->db->get_where('perjalanan_anggota', ['npk' => $this->session->userdata('npk')])->result_array();
                                    foreach ($perjalanan as $pdl) :
                                        $rsvid = $pdl['perjalanan_id'];
                                        if ($rsvid != null) {
                                            $pdetail = $this->db->get_where('perjalanan', ['id' => $rsvid])->row_array(); ?>
                                    <tr>
                                        <td><?= $pdetail['id']; ?></td>
                                        <td><?= $pdetail['nama']; ?></td>
                                        <td><?= $pdetail['tujuan']; ?></td>
                                        <td><?= $pdetail['keperluan']; ?></td>
                                        <td><?= $pdetail['anggota']; ?></td>
                                        <td><?= $pdetail['tglberangkat']; ?></td>
                                        <td><?= $pdetail['jamberangkat']; ?></td>
                                        <td><?= $pdetail['tglkembali']; ?></td>
                                        <td><?= $pdetail['jamkembali']; ?></td>
                                        <td><?= $pdetail['nopol']; ?></td>
                                        <td><?= $pdetail['kepemilikan']; ?></td>
                                        <?php $status = $this->db->get_where('perjalanan_status', ['id' => $pdetail['status']])->row_array(); ?>
                                        <td><?= $status['nama']; ?></td>
                                        <td class="text-right">
                                            <a href="#" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">dvr</i></a>
                                            <?php if ($pdetail['status'] == 1) { ?>
                                            <a href="#" class="btn btn-link btn-danger btn-just-icon remove" data-toggle="modal" data-target="#batalDl" data-id="<?= $pdetail['id']; ?>"><i class="material-icons">close</i></a>
                                            <?php } else { ?>
                                            <a href="#" class="btn btn-link btn-danger btn-just-icon remove disabled"><i class="material-icons">close</i></a>
                                            <?php }; ?>
                                        </td>
                                    </tr>
                                    <?php }; ?>
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