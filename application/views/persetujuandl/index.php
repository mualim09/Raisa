    <div class="content">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">assignment</i>
                            </div>
                            <h4 class="card-title">Data Reservasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="material-datatables">
                                <table id="dtatasan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No. Reservasi</th>
                                            <th>Nama</th>
                                            <th>Tujuan</th>
                                            <th>Keperluan</th>
                                            <th>Peserta</th>
                                            <th>Nomor Polisi</th>
                                            <th>Jenis Kendaraan</th>
                                            <th>Tgl Keberangkatan</th>
                                            <th>Jam Keberangkatan</th>
                                            <th>Tgl Kembali</th>
                                            <th>Jam Kembali</th>
                                            <th>Estimasi Biaya</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No. Reservasi</th>
                                            <th>Nama</th>
                                            <th>Tujuan</th>
                                            <th>Keperluan</th>
                                            <th>Peserta</th>
                                            <th>Nomor Polisi</th>
                                            <th>Jenis Kendaraan</th>
                                            <th>Tgl Keberangkatan</th>
                                            <th>Jam Keberangkatan</th>
                                            <th>Tgl Kembali</th>
                                            <th>Jam Kembali</th>
                                            <th>Estimasi Biaya</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        if ($this->session->userdata('inisial') == 'ABU') {
                                            $queryRsv = "SELECT *
                                            FROM `reservasi`
                                            WHERE `status` = 1 or `status` = 2
                                            ";
                                        } else {
                                            $queryRsv = "SELECT *
                                            FROM `reservasi`
                                            WHERE (`atasan1` = '{$karyawan['inisial']}' and `status` = 1) or (`atasan2` = '{$karyawan['inisial']}' and `status` = 2)
                                            ";
                                        }

                                        $reservasi = $this->db->query($queryRsv)->result_array();
                                        foreach ($reservasi as $rsv) : ?>
                                            <tr>
                                                <td><?= $rsv['id']; ?></td>
                                                <td><?= $rsv['nama']; ?></td>
                                                <td><?= $rsv['tujuan']; ?></td>
                                                <td><?= $rsv['keperluan']; ?></td>
                                                <td><?= $rsv['anggota']; ?></td>
                                                <td><?= $rsv['nopol']; ?></td>
                                                <td><?= $rsv['kepemilikan']; ?></td>
                                                <td><?= $rsv['tglberangkat']; ?></td>
                                                <td><?= $rsv['jamberangkat']; ?></td>
                                                <td><?= $rsv['tglkembali']; ?></td>
                                                <td><?= $rsv['jamkembali']; ?></td>
                                                <td><?= number_format($rsv['total'], 0, ',', '.'); ?></td>
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