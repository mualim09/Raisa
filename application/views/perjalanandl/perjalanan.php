<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <?php if($sidemenu=='GA'){ ?>
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
                            <form action="<?= base_url('perjalanandl/cariperjalanan'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Dari Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglawal" name="tglawal">
                                        </div>
                                    </div>
                                    <label class="col-md-2 col-form-label">Sampai Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglakhir" name="tglakhir">
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-rose">Cari</a>
                                    </div>
                                </div>
                            </form>
                            <table id="dtperjalanan-desc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor_Perjalanan</th>
                                        <th>Jenis DL</th>
                                        <th>Kendaraan</th>
                                        <th>Nopol</th>
                                        <th>Nama</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Waktu Keberangkatan</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor_Perjalanan</th>
                                        <th>Jenis DL</th>
                                        <th>Kendaraan</th>
                                        <th>Nopol</th>
                                        <th>Nama</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Waktu Keberangkatan</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $pdl) : ?>
                                        <!-- <tr onclick="window.location='<?= base_url('perjalanandl/perjalanan/' . $pdl['id']); ?>'"> -->
                                        <tr>
                                            <td>
                                            <?= $pdl['id']; ?>
                                            <?php if ($pdl['status'] > '4') { ?>
                                                <a href="<?= base_url('perjalanandl/suratjalan/') . $pdl['id']; ?>" class="btn btn-link btn-info btn-just-icon" target="_blank"><i class="material-icons">print</i></a>
                                            <?php }; ?> 
                                            </td>
                                            <td><?= $pdl['jenis_perjalanan']; ?></td>
                                            <td><?= $pdl['kepemilikan']; ?></td>
                                            <td><?= $pdl['nopol']; ?></td>
                                            <td><?= $pdl['nama']; ?></td>
                                            <td><?= $pdl['anggota']; ?></td>
                                            <td><?= $pdl['tujuan']; ?></td>
                                            <td><?= $pdl['keperluan']; ?></td>
                                            <td><?= date('d M', strtotime($pdl['tglberangkat'])) . ' - ' . date('H:i', strtotime($pdl['jamberangkat'])); ?></td>
                                            <?php $status = $this->db->get_where('perjalanan_status', ['id' => $pdl['status']])->row_array(); ?>
                                            <td><?= $status['nama']; ?></td>
                                            <td class="text-right">
                                                <?php if ($pdl['status'] == '0' and $pdl['tglberangkat']== date('Y-m-d')) { ?>
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
        <?php }else{ ?>
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
                            <form action="<?= base_url('perjalanandl/cariperjalanan_ta'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Dari Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglawal" name="tglawal">
                                        </div>
                                    </div>
                                    <label class="col-md-2 col-form-label">Sampai Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglakhir" name="tglakhir">
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-rose">Cari</a>
                                    </div>
                                </div>
                            </form>
                            <table id="dtdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Nama</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Berangkat</th>
                                        <th>Kembali</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Nama</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Berangkat</th>
                                        <th>Kembali</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $pdl) : ?>
                                        <tr>
                                            <td><?= $pdl['id']; ?></td>
                                            <td><?= $pdl['nama']; ?></td>
                                            <td><?= $pdl['anggota']; ?></td>
                                            <td><?= $pdl['tujuan']; ?></td>
                                            <td><?= $pdl['keperluan']; ?></td>
                                            <td><?= date('d/m/Y', strtotime($pdl['tglberangkat'])) . ' ' . date('H:i', strtotime($pdl['jamberangkat'])); ?></td>
                                            <td><?= date('d/m/Y', strtotime($pdl['tglkembali'])) . ' ' . date('H:i', strtotime($pdl['jamkembali'])); ?></td>
                                            <td><?= $pdl['catatan']; ?></td>
                                            <?php $status = $this->db->get_where('perjalanan_status', ['id' => $pdl['status']])->row_array(); ?>
                                            <td><?= $status['nama']; ?></td>
                                            <td class="text-right">
                                                    <a href="<?= base_url('perjalanandl/surattugas/') . $pdl['id']; ?>" class="btn btn-link btn-info btn-just-icon" target="_blank"><i class="material-icons">print</i></a>
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
        <?php } ?>
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->