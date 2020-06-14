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
                        <h4 class="card-title">Perjalanan - <?= $perjalanan['id']; ?></h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('perjalanandl/penyelesaian/submit'); ?>" method="post">
                            <div class="row" hidden="true">
                                <label class="col-md-2 col-form-label">Nomor Reservasi</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id" value="<?= $perjalanan['id']; ?>" />
                                    </div>
                                </div>
                            </div>
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
                                <label class="col-md-2 col-form-label">Jenis Perjalanan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="jperjalanan" value="<?= $perjalanan['jenis_perjalanan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tanggal</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="tgl" name="tgl" value="<?= date("d M Y", strtotime($perjalanan['tglberangkat'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Jam</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="jam" name="jam" value="<?= date("H:i", strtotime($perjalanan['jamberangkat'])) . ' - ' . date("H:i", strtotime($perjalanan['jamkembali'])); ?>">
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
                                <label class="col-md-2 col-form-label">Kendaraan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="kepemilikan" value="<?= $perjalanan['kepemilikan']; ?>">
                                        <input type="text" class="form-control disabled" name="nopol" value="<?= $perjalanan['nopol']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kilometer</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="kmtotal" value="<?= $perjalanan['kmtotal']; ?> Km">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden="true">
                                <label class="col-md-2 col-form-label">COPRO</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="copro" value="<?= $perjalanan['copro']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden="true">
                                <label class="col-md-2 col-form-label">Keperluan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control disabled" name="keperluan"><?= $perjalanan['keperluan']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Peserta</label>
                                <div class="col-md-8">
                                    <!-- <input type="text" class="form-control disabled" name="anggota" value="<?= $perjalanan['anggota']; ?>"> -->
                                    <div class="material-datatables">
                                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Inisial</th>
                                                    <th>Nama</th>
                                                    <th>Tunjangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $queryAnggota = "SELECT *
                                                        FROM `perjalanan_anggota`
                                                        WHERE `perjalanan_id` = '{$perjalanan['id']}'
                                                        ";
                                                $anggota = $this->db->query($queryAnggota)->result_array();
                                                foreach ($anggota as $a) : ?>
                                                    <tr>
                                                        <td><?= $a['karyawan_inisial']; ?></td>
                                                        <td><?= $a['karyawan_nama']; ?></td>
                                                        <td><?= number_format($a['total'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr class="table-info">
                                                    <td colspan="2">Biaya Perjalanan</td>
                                                    <td><?= number_format($perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'], 0, ',', '.'); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <p>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Rincian Biaya</label>
                                    <div class="col-md-8">
                                        <div class="material-datatables">
                                            <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Biaya</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="table-success">
                                                        <td>Uang Saku <small>(TAPP)</small></td>
                                                        <td><?= number_format($perjalanan['uang_saku'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-danger" data-toggle="modal" data-target="#ubahUangsaku" data-id="<?= $perjalanan['id']; ?>" data-uang_saku="<?= $perjalanan['uang_saku']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr class="table-success">
                                                        <td>Insentif Pagi</br><small>Berangkat < 05:00</small> </td> <td><?= number_format($perjalanan['insentif_pagi'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-danger" data-toggle="modal" data-target="#ubahInsentif" data-id="<?= $perjalanan['id']; ?>" data-insentif="<?= $perjalanan['insentif_pagi']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr class="table-success">
                                                        <td>Makan Pagi <small>(TAPP)</br>Berangkat < 07:00</small> </td> <td><?= number_format($perjalanan['um_pagi'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-danger" data-toggle="modal" data-target="#ubahUmpagi" data-id="<?= $perjalanan['id']; ?>" data-umpagi="<?= $perjalanan['um_pagi']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr class="table-success">
                                                        <td>Makan Siang</td>
                                                        <td><?= number_format($perjalanan['um_siang'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-danger" data-toggle="modal" data-target="#ubahUmsiang" data-id="<?= $perjalanan['id']; ?>" data-umsiang="<?= $perjalanan['um_siang']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr class="table-success">
                                                        <td>Makan Malam</br><small>Kembali > 19:30</small></td>
                                                        <td><?= number_format($perjalanan['um_malam'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-danger" data-toggle="modal" data-target="#ubahUmmalam" data-id="<?= $perjalanan['id']; ?>" data-ummalam="<?= $perjalanan['um_malam']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Taksi/Sewa</br><small>Pribadi per KM</small> </td>
                                                        <td><?= number_format($perjalanan['taksi'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-warning" data-toggle="modal" data-target="#ubahTaksi" data-id="<?= $perjalanan['id']; ?>" data-taksi="<?= $perjalanan['taksi']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>BBM</td>
                                                        <td><?= number_format($perjalanan['bbm'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-warning" data-toggle="modal" data-target="#ubahBbm" data-id="<?= $perjalanan['id']; ?>" data-bbm="<?= $perjalanan['bbm']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tol</td>
                                                        <td><?= number_format($perjalanan['tol'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-warning" data-toggle="modal" data-target="#ubahTol" data-id="<?= $perjalanan['id']; ?>" data-tol="<?= $perjalanan['tol']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Parkir & Lainnya</td>
                                                        <td><?= number_format($perjalanan['parkir'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-warning" data-toggle="modal" data-target="#ubahParkir" data-id="<?= $perjalanan['id']; ?>" data-parkir="<?= $perjalanan['parkir']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>TOTAL</strong></td>
                                                        <td><strong><?= number_format($perjalanan['total'], 0, ',', '.'); ?></strong></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <small>*Untuk Perjalanan TA masih dalam pengembangan. masih menggunakan penyelesaian manual.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Kasbon</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kasbon" value="<?= number_format($perjalanan['kasbon'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Selisih</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="selisih" value="<?= number_format($perjalanan['kasbon'] - $perjalanan['total'], 0, ',', '.'); ?>">
                                        </div>
                                        <small>*(+)Uang yang harus dikembalikan.</small></br>
                                        <small>*(-)Uang yang harus diberikan.</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Catatan</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <textarea rows="2" class="form-control" name="catatan"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <button type="submit" class="btn btn-fill btn-success">PROSES</button>
                                            <a href="<?= base_url('perjalanandl/suratjalan/' . $perjalanan['id']); ?>" class="btn btn-fill btn-info">SURAT JALAN</a>
                                            <a href="<?= base_url('perjalanandl/penyelesaian/daftar'); ?>" class="btn btn-link btn-default">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ubahUangsaku" tabindex="-1" role="dialog" aria-labelledby="ubahUangsakuLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahUangsakuLabel">Uang Saku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/ubah_uangsaku'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_uang_saku" name="e_uang_saku" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="uang_saku" name="uang_saku" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahInsentif" tabindex="-1" role="dialog" aria-labelledby="ubahInsentifLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahInsentifLabel">Insentif Pagi - <small>Berangkat sebelum Jam 05:00</small> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/ubah_insentif'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_insentif" name="e_insentif" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="insentif" name="insentif" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahUmpagi" tabindex="-1" role="dialog" aria-labelledby="ubahUmpagiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahUmpagiLabel">Makan Pagi - <small>Berangkat sebelum Jam 07:00</small> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/ubah_umpagi'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_umpagi" name="e_umpagi" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="umpagi" name="umpagi" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahUmsiang" tabindex="-1" role="dialog" aria-labelledby="ubahUmsiangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahUmsiangLabel">Makan Siang </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/ubah_umsiang'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_umsiang" name="e_umsiang" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="umsiang" name="umsiang" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahUmmalam" tabindex="-1" role="dialog" aria-labelledby="ubahUmmalamLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahUmmalamLabel">Makan Malam </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/ubah_ummalam'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_ummalam" name="e_ummalam" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="ummalam" name="ummalam" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahTaksi" tabindex="-1" role="dialog" aria-labelledby="ubahTaksiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahTaksiLabel">Taksi / Sewa / Pribadi <small>(per Kilometer)</small></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanan/penyelesaian_edit/taksi'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_taksi" name="e_taksi" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="taksi" name="taksi" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahBbm" tabindex="-1" role="dialog" aria-labelledby="ubahBbmLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahBbmLabel">Biaya Bbm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanan/penyelesaian_edit/bbm'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_bbm" name="e_bbm" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="bbm" name="bbm" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahTol" tabindex="-1" role="dialog" aria-labelledby="ubahTolLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahTolLabel">Biaya Tol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanan/penyelesaian_edit/tol'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_tol" name="e_tol" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="tol" name="tol" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahParkir" tabindex="-1" role="dialog" aria-labelledby="ubahParkirLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahParkirLabel">Biaya Parkir & Lainnya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanan/penyelesaian_edit/parkir'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_parkir" name="e_parkir" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="parkir" name="parkir" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#ubahUangsaku').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var uang_saku = button.data('uang_saku')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_uang_saku"]').val(uang_saku)
        })
        $('#ubahInsentif').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var insentif = button.data('insentif')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_insentif"]').val(insentif)
        })
        $('#ubahUmpagi').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var umpagi = button.data('umpagi')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_umpagi"]').val(umpagi)
        })
        $('#ubahUmsiang').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var umsiang = button.data('umsiang')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_umsiang"]').val(umsiang)
        })
        $('#ubahUmmalam').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var ummalam = button.data('ummalam')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_ummalam"]').val(ummalam)
        })
        $('#ubahTaksi').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var taksi = button.data('taksi')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_taksi"]').val(taksi)
        })
        $('#ubahBbm').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var bbm = button.data('bbm')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_bbm"]').val(bbm)
        })
        $('#ubahTol').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var tol = button.data('tol')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_tol"]').val(tol)
        })
        $('#ubahParkir').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var parkir = button.data('parkir')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_parkir"]').val(parkir)
        })
        $('#prosesPerjalanan').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var total = button.data('total')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="total"]').val(total)
        })
    });
</script>