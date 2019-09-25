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
                        <h4 class="card-title">Data Opname Asset</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <?php
                            $queryVerifikasi1 = $this->db->query('SELECT * FROM asset_opname WHERE `status_opname` =  1');
                            $queryVerifikasi2 = $this->db->query('SELECT * FROM asset_opname WHERE `status_opname` =  2');

                            ?>
                            <a href="<?= base_url('asset/verifikasi'); ?>" class="btn btn-lg btn-danger mb-2" role="button" aria-disabled="false">BELUM DIVERIVIKASI : <?= $queryVerifikasi1->num_rows(); ?></a>
                            <a href="<?= base_url('asset/verifikasi2'); ?>" class="btn btn-lg btn-success mb-2" role="button" aria-disabled="false">SUDAH DIVERIFIKASI : <?= $queryVerifikasi2->num_rows(); ?></a>
                        </div>
                        <div class="material-datatables">
                            <table id="dtperjalanan" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="disabled-sorting text-center"></th>
                                        <th>Nomor Asset</th>
                                        <th>Asset</th>
                                        <th class="th-description">Kategori</th>
                                        <th class="th-description">NPK PIC</th>
                                        <th class="th-description">Nama PIC</th>
                                        <th class="th-description">Lokasi</th>
                                        <th class="th-description">Status</th>
                                        <th class="th-description">Catatan</th>
                                        <th class="th-description">NPK PIC Sebelumnya</th>
                                        <th class="th-description">Nama PIC Sebelumnya</th>
                                        <th class="th-description">Lokasi Sebelumnya</th>
                                        <th class="th-description">Tgl Opname</th>
                                        <th class="disabled-sorting th-description">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Nomor Asset</th>
                                        <th>Asset</th>
                                        <th class="th-description">Kategori</th>
                                        <th class="th-description">NPK PIC</th>
                                        <th class="th-description">Nama PIC</th>
                                        <th class="th-description">Lokasi</th>
                                        <th class="th-description">Status</th>
                                        <th class="th-description">Catatan</th>
                                        <th class="th-description">NPK PIC Sebelumnya</th>
                                        <th class="th-description">Nama PIC Sebelumnya</th>
                                        <th class="th-description">Lokasi Sebelumnya</th>
                                        <th class="th-description">Tgl Opname</th>
                                        <th class="th-description">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($asset as $a) :
                                        $assetlama = $this->db->where('asset_no', $a['asset_no']);
                                        $assetlama = $this->db->get_where('asset', ['asset_sub_no' =>  $a['asset_sub_no']])->row_array(); ?>
                                        <tr>
                                            <td>
                                                <div class="img-container">
                                                    <img src="<?= base_url(); ?>assets/img/asset/<?= $a['asset_foto']; ?>" alt="...">
                                                </div>
                                            </td>
                                            <td class="td-name">
                                                <a><?= $a['asset_no'] . '-' . $a['asset_sub_no']; ?></a>
                                            </td>
                                            <td><?= $a['asset_deskripsi']; ?></td>
                                            <td><?= $a['kategori']; ?></td>
                                            <?php $karyawan = $this->db->get_where('karyawan', ['npk' =>  $a['npk']])->row_array(); ?>
                                            <td><?= $a['npk']; ?></td>
                                            <td><?= $karyawan['nama']; ?></td>
                                            <td><?= $a['lokasi']; ?></td>
                                            <?php if ($a['status'] == 1) {
                                                    echo '<td>BAIK-ADA-DIGUNAKAN</td>';
                                                } else if ($a['status'] == 2) {
                                                    echo '<td>BAIK-TIDAK SESUAI</td>';
                                                } else if ($a['status'] == 3) {
                                                    echo '<td>RUSAK</td>';
                                                } else if ($a['status'] == 4) {
                                                    echo '<td>HILANG</td>';
                                                }; ?>
                                            <td><?= $a['catatan']; ?></td>
                                            <?php $karyawanlama = $this->db->get_where('karyawan', ['npk' =>  $assetlama['npk']])->row_array(); ?>
                                            <?php if ($assetlama['npk'] == $a['npk']) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } else { ?>
                                                <td><?= $assetlama['npk']; ?></td>
                                                <td><?= $karyawanlama['nama']; ?></td>
                                            <?php }; ?>
                                            <?php if ($assetlama['lokasi'] == $a['lokasi']) { ?>
                                                <td></td>
                                            <?php } else { ?>
                                                <td><?= $assetlama['lokasi']; ?></td>
                                            <?php }; ?>
                                            <td><?= $a['tglopname']; ?></td>
                                            <td class="text-right">
                                                <?php if ($a['status_opname'] == 1) { ?>
                                                    <a href="<?= base_url('asset/do_verifikasi/') . $a['asset_no'] . '/' . $a['asset_sub_no']; ?>" class="btn btn-round btn-primary">Verifikasi</a>
                                                <?php } else { ?>
                                                    Diverifikasi oleh <?= $a['tim_opname']; ?>
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