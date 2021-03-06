<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title"><?= $perjalanan['jenis_perjalanan'].' - '.$perjalanan['id']; ?></h4>
                    </div>
                    <div class="card-body ">
                        <ul class="nav nav-pills nav-pills-info" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist">
                                    Summary
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link2" role="tablist">
                                    Peserta
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link3" role="tablist">
                                    Rincian Biaya
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tab-space">
                            <div class="tab-pane active" id="link1">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Nama</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="nama" value="<?= $perjalanan['nama']; ?>" />
                                            <input type="text" class="form-control disabled" name="npk" value="<?= $perjalanan['npk']; ?>" hidden="true" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Berangkat</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="berangkat" name="berangkat" value="<?= date("d M Y", strtotime($perjalanan['tglberangkat'])).' '.date("H:i", strtotime($perjalanan['jamberangkat'])); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Kembali</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="kembali" name="kembali" value="<?= date("d M Y", strtotime($perjalanan['tglkembali'])) . ' ' . date("H:i", strtotime($perjalanan['jamkembali'])); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Kendaraan</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kepemilikan" value="<?= $perjalanan['kepemilikan']; ?>">
                                            <input type="text" class="form-control disabled" name="nopol" value="<?= $perjalanan['nopol']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Tujuan</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="tujuan" value="<?= $perjalanan['tujuan']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Jarak</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kmtotal" value="<?= $perjalanan['kmtotal']; ?> Km">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Biaya</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="total" value="<?= number_format($perjalanan['total'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php $status = $this->db->get_where('perjalanan_status', ['id' => $perjalanan['status']])->row_array(); ?>
                                    <label class="col-md-2 col-form-label">Status</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kasbon" value="<?= $status['nama']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="link2">
                                <div class="table-responsive">
                                    <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <?php if ($perjalanan['uang_saku']>0){ echo '<th>Uang Saku</th>'; } ?>
                                                <?php if ($perjalanan['insentif_pagi']>0){ echo '<th>Insentif</th>';} ?>
                                                <?php if ($perjalanan['um_pagi']>0){ echo '<th>Pagi</th>';} ?>
                                                <?php if ($perjalanan['um_siang']>0){ echo '<th>Siang</th>';} ?>
                                                <?php if ($perjalanan['um_malam']>0){ echo '<th>Malam</th>';} ?>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $queryAnggota = "SELECT *
                                                    FROM `perjalanan_anggota`
                                                    WHERE `perjalanan_id` = '{$perjalanan['id']}'
                                                    ";
                                            $anggota = $this->db->query($queryAnggota)->result_array();
                                            foreach ($anggota as $a) : 
                                            $peserta = $this->db->get_where('karyawan', ['npk' => $a['npk']])->row_array();
                                            ?>
                                                <tr>
                                                    <?php if ($perjalanan['pic_perjalanan'] == $a['karyawan_inisial']){ ?>
                                                        <td><?= $a['karyawan_nama'].' <a href="#" class="btn btn-link btn-success btn-just-icon" data-toggle="tooltip" data-placement="top" title="PIC Perjalanan"><i class="material-icons">military_tech</i></a>'; ?></td>
                                                    <?php }else{ ?>
                                                        <td><?= $a['karyawan_nama']; ?></td>
                                                    <?php } ?>
                                                    <?php if ($perjalanan['uang_saku']>0){ echo '<td>'.number_format($a['uang_saku'], 0, ',', '.').'</td>'; } ?>
                                                    <?php if ($perjalanan['insentif_pagi']>0){ echo '<td>'.number_format($a['insentif_pagi'], 0, ',', '.').'</td>';} ?>
                                                    <?php if ($perjalanan['um_pagi']>0){ echo '<td>'.number_format($a['um_pagi'], 0, ',', '.').'</td>';} ?>
                                                    <?php if ($perjalanan['um_siang']>0){ echo '<td>'.number_format($a['um_siang'], 0, ',', '.').'</td>';} ?>
                                                    <?php if ($perjalanan['um_malam']>0){ echo '<td>'.number_format($a['um_malam'], 0, ',', '.').'</td>';} ?>
                                                    <?php if ($perjalanan['pic_perjalanan'] == $a['karyawan_inisial']){ ?>
                                                        <td>
                                                        <?= number_format($a['total'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'] - $perjalanan['kasbon'], 0, ',', '.'); ?><br>
                                                        <small>Rincian :</small><br>
                                                        <small>+ <?= number_format($a['total'], 0, ',', '.'); ?> (Tunjangan)</small><br>
                                                        <small>+ <?= number_format($perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'], 0, ',', '.'); ?> (Perjalanan)</small><br>
                                                        <small>- <?= number_format($perjalanan['kasbon'], 0, ',', '.'); ?> (Kasbon)</small>
                                                        </td>
                                                    <?php }else{ ?>
                                                        <td><?= number_format($a['total'], 0, ',', '.'); ?></td>
                                                    <?php } ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="link3">
                                <div class="table-responsive">
                                    <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Tunjangan</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Uang Saku <small>(TAPP)</small></td>
                                                <td><?= number_format($perjalanan['uang_saku'], 0, ',', '.'); ?></td>
                                                    <!-- <td><a href="#" class="btn btn-fill btn-sm btn-danger disabled" data-toggle="modal" data-target="#ubahUangsaku" data-id="<?= $perjalanan['id']; ?>" data-uang_saku="<?= $perjalanan['uang_saku']; ?>">UBAH</a></td> -->
                                            </tr>
                                            <tr>
                                                <td>Insentif Pagi</br><small>Berangkat < 05:00</small> </td> <td><?= number_format($perjalanan['insentif_pagi'], 0, ',', '.'); ?></td>
                                                <!-- <td><a href="#" class="btn btn-fill btn-sm btn-danger disabled" data-toggle="modal" data-target="#ubahInsentif" data-id="<?= $perjalanan['id']; ?>" data-insentif="<?= $perjalanan['insentif_pagi']; ?>">UBAH</a></td> -->
                                            </tr>
                                            <tr>
                                                <td>Makan Pagi <small>(TAPP)</br>Berangkat < 07:00</small> </td> <td><?= number_format($perjalanan['um_pagi'], 0, ',', '.'); ?></td>
                                                <!-- <td><a href="#" class="btn btn-fill btn-sm btn-danger disabled" data-toggle="modal" data-target="#ubahUmpagi" data-id="<?= $perjalanan['id']; ?>" data-umpagi="<?= $perjalanan['um_pagi']; ?>">UBAH</a></td> -->
                                            </tr>
                                            <tr>
                                                <td>Makan Siang</td>
                                                <td><?= number_format($perjalanan['um_siang'], 0, ',', '.'); ?></td>
                                                <!-- <td><a href="#" class="btn btn-fill btn-sm btn-danger disabled" data-toggle="modal" data-target="#ubahUmsiang" data-id="<?= $perjalanan['id']; ?>" data-umsiang="<?= $perjalanan['um_siang']; ?>">UBAH</a></td> -->
                                            </tr>
                                            <tr>
                                                <td>Makan Malam</br><small>Kembali > 19:30</small></td>
                                                <td><?= number_format($perjalanan['um_malam'], 0, ',', '.'); ?></td>
                                                <!-- <td><a href="#" class="btn btn-fill btn-sm btn-danger disabled" data-toggle="modal" data-target="#ubahUmmalam" data-id="<?= $perjalanan['id']; ?>" data-ummalam="<?= $perjalanan['um_malam']; ?>">UBAH</a></td> -->
                                            </tr>
                                            <tr>
                                                <td><strong>SUB TOTAL</strong></td>
                                                <td><strong><?= number_format($perjalanan['uang_saku']+$perjalanan['insentif_pagi']+$perjalanan['um_pagi']+$perjalanan['um_siang']+$perjalanan['um_malam'], 0, ',', '.'); ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p>
                                <div class="material-datatables">
                                    <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Biaya</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Taksi/Sewa</br><small>Pribadi per KM</small> </td>
                                                <td><?= number_format($perjalanan['taksi'], 0, ',', '.'); ?></td>
                                            </tr>
                                            <tr>
                                                <td>BBM</td>
                                                <td><?= number_format($perjalanan['bbm'], 0, ',', '.'); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tol</td>
                                                <td><?= number_format($perjalanan['tol'], 0, ',', '.'); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Parkir & Lainnya</td>
                                                <td><?= number_format($perjalanan['parkir'], 0, ',', '.'); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>SUB TOTAL</strong></td>
                                                <td><strong><?= number_format($perjalanan['taksi']+$perjalanan['bbm']+$perjalanan['tol']+$perjalanan['parkir'], 0, ',', '.'); ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>