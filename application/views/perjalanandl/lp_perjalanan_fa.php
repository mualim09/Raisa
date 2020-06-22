<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Laporan Perjalanan Dinas</h4>
                            <p class="card-category">Berdasarkan periode <?= date("d-m-Y", strtotime($tglawal)).' s/d '.date("d-m-Y", strtotime($tglakhir)); ?></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <form action="<?= base_url('perjalanandl/laporan_fa'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Dari Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglawal" name="tglawal" required="true" />
                                        </div>
                                    </div>
                                    <label class="col-md-2 col-form-label">Sampai Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglakhir" name="tglakhir" required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-success">Cari</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="material-datatables">
                            <table id="dtperjalanan-desc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor_Perjalanan</th>
                                        <th>Jenis DL</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>KM Keberangkatan</th>
                                        <th>Security Keberangkatan</th>
                                        <th>Tgl Kembali</th>
                                        <th>Jam Kembali</th>
                                        <th>KM Kembali</th>
                                        <th>Security Kembali</th>
                                        <th>KM Total</th>
                                        <th>Catatan GA</th>
                                        <th>Catatan Security</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>KM Keberangkatan</th>
                                        <th>Security Keberangkatan</th>
                                        <th>Tgl Kembali</th>
                                        <th>Jam Kembali</th>
                                        <th>KM Kembali</th>
                                        <th>Security Kembali</th>
                                        <th>KM Total</th>
                                        <th>Catatan GA</th>
                                        <th>Catatan Security</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $pdl) : ?>
                                        <tr>
                                            <td>
                                            <?= $pdl['id']; ?>
                                            <?php if ($pdl['status'] > '4') { ?>
                                                <a href="<?= base_url('perjalanandl/suratjalan/') . $pdl['id']; ?>" class="btn btn-link btn-info btn-just-icon" target="_blank"><i class="material-icons">print</i></a>
                                            <?php }; ?> 
                                            </td>
                                            <td><?= $pdl['jenis_perjalanan']; ?></td>
                                            <td><?= $pdl['nopol']; ?></td>
                                            <td><?= $pdl['kepemilikan']; ?></td>
                                            <td><?= $pdl['nama']; ?></td>
                                            <td><?= $pdl['tujuan']; ?></td>
                                            <td><?= $pdl['keperluan']; ?></td>
                                            <td><?= $pdl['anggota']; ?></td>
                                            <td><?= $pdl['tglberangkat']; ?></td>
                                            <td><?= $pdl['jamberangkat']; ?></td>
                                            <td><?= $pdl['kmberangkat']; ?></td>
                                            <td><?= $pdl['cekberangkat']; ?></td>
                                            <td><?= $pdl['tglkembali']; ?></td>
                                            <td><?= $pdl['jamkembali']; ?></td>
                                            <td><?= $pdl['kmkembali']; ?></td>
                                            <td><?= $pdl['cekkembali']; ?></td>
                                            <td><?= $pdl['kmtotal']; ?></td>
                                            <td><?= $pdl['catatan']; ?></td>
                                            <td><?= $pdl['catatan_security']; ?></td>
                                            <?php $status = $this->db->get_where('perjalanan_status', ['id' => $pdl['status']])->row_array(); ?>
                                            <td><?= $status['nama']; ?></td>
                                            <td class="text-right">
                                                <?php if ($pdl['status'] == '0') { ?>
                                                    <a href="<?= base_url('perjalanandl/aktifkan/') . $pdl['id']; ?>" class="badge badge-success">Aktifkan</a>
                                                <?php } elseif ($pdl['status'] == '9') { ?>
                                                    <a href="<?= base_url('perjalanandl/suratjalan/') . $pdl['id']; ?>" class="btn btn-link btn-info btn-just-icon" target="_blank"><i class="material-icons">print</i></a>
                                                <?php }; ?>
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