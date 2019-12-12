<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 align-content-start">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">update</i>
                        </div>
                        <h4 class="card-title">Realisasi Aktivitas Lembur</h4>
                    </div>
                    <form class="form" method="post" action="<?= base_url('lembur/ajukan_realisasi'); ?>">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="row col-md-6">
                                    <div class="row" hidden>
                                        <label class="col-md-5 col-form-label">Lembur ID</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control disabled" id="id" name="id" value="<?= $lembur['id']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                    <label class="col-ml-5 col-form-label">Tanggal Mulai</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control datetimepicker disabled" placeholder="With Material Icons" id="tglmulai" name="tglmulai" value="<?= $lembur['tglmulai_aktual']; ?>">
                                                    <a href="#" class="badge badge-pill badge-warning" data-toggle="modal" data-target="#ubhTanggal" data-id="<?= $lembur['id']; ?>">UBAH JAM</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <label class="col-ml-5 col-form-label">Tanggal Selesai</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control datetimepicker disabled" id="tglselesai_aktual" name="tglselesai_aktual" value="<?= $lembur['tglselesai_aktual']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <label class="col-ml-5 col-form-label">Durasi Lembur</label>
                                            <div class="col-md-7">
                                                <div class="form-group has-default">
                                                    <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= date('H:i', strtotime($lembur['durasi_aktual'])).' Jam / '. $lembur['aktivitas']; ?> Aktivitas">
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                            <div class="row col-md-6">
                                <div class="row col-md-12">
                                    <label class="col-ml-5 col-form-label">Lokasi Lembur</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lembur['lokasi']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                    <label class="col-ml-5 col-form-label">Status</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <?php $status = $this->db->get_where('lembur_status', ['id' => $lembur['status']])->row_array(); ?>
                                                <input type="text" class="form-control disabled" id="status" name="status" value="<?= $status['nama']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <br>
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                                <?php if ($lembur['status'] == '4') { ?>
                                    <a href="#" class="btn btn-rose mb" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">Tambah Aktivitas</a>
                                    <!-- <a href="#" class="btn btn-info mb" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahIstirahat">Tambah Istirahat</a> -->
                                <?php }; ?>
                            </div>
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Kategori</th>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi Hasil</th>
                                            <th>Progres Hasil</th>
                                            <th>Durasi/Jam</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Kategori</th>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi Hasil</th>
                                            <th>Progres Hasil</th>
                                            <th>Durasi/Jam</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($aktivitas as $a) : ?>
                                            <tr>
                                                <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                                <td><?= $k['nama']; ?> <small>(<?= $a['copro']; ?>)</small></td>
                                                <td><?= $a['aktivitas']; ?></td>
                                                <td><?= $a['deskripsi_hasil']; ?></td>
                                                <?php $s = $this->db->get_where('aktivitas_status', ['id' => $a['status']])->row_array(); ?>
                                                <td><?= $s['nama'] .', '. $a['progres_hasil']; ?>%</td>
                                                <td><?= $a['durasi']; ?> jam</td>
                                                <td class="text-right">
                                                    <?php if ($lembur['status'] == '4' and $a['status']== '1') { ?>
                                                        <a href="#" data-toggle="modal" data-target="#realisasiAktivitas" data-id="<?= $a['id']; ?>" data-aktivitas="<?= $a['aktivitas']; ?>" class="badge badge-pill badge-success">Realisasi</a>
                                                    <?php } else if($lembur['status'] == '4' and $a['status']!= '1'){ ?>
                                                        <a href="#" data-toggle="modal" data-target="#realisasiAktivitas" data-id="<?= $a['id']; ?>" data-aktivitas="<?= $a['aktivitas']; ?>" data-deskripsi_hasil="<?= $a['deskripsi_hasil']; ?>" class="badge badge-pill badge-info">Revisi</a>
                                                    <?php }; ?>
                                                        <a href="<?= base_url('lembur/hapus_aktivitas_realisasi/') . $a['id']; ?>" class="badge badge-pill badge-danger btn-sm btn-bataldl">Batalkan</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                </p>
                                        <p class="mb-0">Perhatikan hal-hal berikut:</p>
                                        <p class="mb-0">1. LEMBUR ini sudah termasuk aktivitas <mark>ISTIRAHAT</mark>.</p>
                                        <p class="mb-0">2. LEMBUR ini sudah termasuk <mark>PERJALANAN</mark> (jika dinas luar).</p>
                                        <p class="mb-0">3. Durasi <mark>REALISASI LEMBUR</mark> sudah sesuai dengan durasi lembur aktual yang akan diproses oleh HR.</p>
                                    </p>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="c" name="c" value="1" required>
                                            Ya, Saya setuju dengan ketentuan di atas.
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </p>
                                <!-- Button SUBMIT -->
                                <?php 
                                $this->db->where('link_aktivitas', $lembur['id']);
                                $ada_aktivitas = $this->db->get('aktivitas')->row_array();
                                if ($ada_aktivitas) {
                                    $this->db->where('link_aktivitas', $lembur['id']);
                                    $belum_dikerjakan = $this->db->get_where('aktivitas', ['status' => '1'])->row_array();
                                    if ($belum_dikerjakan) { ?>
                                        <button type="submit" id="ajukan" class="btn btn-sm btn-success disabled">SUBMIT</button>
                                    <?php } else { ?>
                                        <button type="submit" id="ajukan" class="btn btn-sm btn-success">SUBMIT</button>
                                    <?php }; ?>
                                <?php } else { ?>
                                    <button type="submit" id="ajukan" class="btn btn-sm btn-success disabled">SUBMIT</button>
                                <?php }; ?>
                                 <!-- Button BATALKAN & KEMBALI -->
                                <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                                <a href="<?= base_url('lembur/realisasi/') ?>" class="btn btn-sm btn-default" role="button">Kembali</a>
                            </div>
                        </div>
                        <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>
</form>
<!-- Modal -->

<!-- Realisasi Aktivitas -->
<div class="modal fade" id="realisasiAktivitas" tabindex="-1" role="dialog" aria-labelledby="realisasiAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">REALISASI AKTIVITAS</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/update_aktivitas_realisasi'); ?>">
                    <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $lembur['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">No Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Rencana aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="aktivitas" name="aktivitas">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Deskripsi Hasil</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" id="deskripsi_hasil" name="deskripsi_hasil" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                    <option value="+30 minute">00:30 Jam</option>
                                        <option value="+60 minute">01:00 Jam</option>
                                        <option value="+90 minute">01:30 Jam</option>
                                        <option value="+120 minute">02:00 Jam</option>
                                        <option value="+150 minute">02:30 Jam</option>
                                        <option value="+180 minute">03:00 Jam</option>
                                        <option value="+210 minute">03:30 Jam</option>
                                        <option value="+240 minute">04:00 Jam</option>
                                        <option value="+270 minute">04:30 Jam</option>
                                        <option value="+300 minute">05:00 Jam</option>
                                        <option value="+330 minute">05:30 Jam</option>
                                        <option value="+360 minute">06:00 Jam</option>
                                        <option value="+390 minute">06:30 Jam</option>
                                        <option value="+420 minute">07:00 Jam</option>
                                        <option value="+450 minute">07:30 Jam</option>
                                        <option value="+480 minute">08:00 Jam</option>
                                        <option value="+510 minute">08:30 Jam</option>
                                        <option value="+540 minute">09:00 Jam</option>
                                        <option value="+570 minute">09:30 Jam</option>
                                        <option value="+600 minute">10:00 Jam</option>
                                        <option value="+630 minute">10:30 Jam</option>
                                        <option value="+660 minute">11:00 Jam</option>
                                        <option value="+690 minute">11:30 Jam</option>
                                        <option value="+720 minute">12:00 Jam</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Progres</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="progres_hasil" id="progres_hasil" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <option value="10">10 %</option>
                                        <option value="15">15 %</option>
                                        <option value="20">20 %</option>
                                        <option value="25">25 %</option>
                                        <option value="30">30 %</option>
                                        <option value="35">35 %</option>
                                        <option value="40">40 %</option>
                                        <option value="45">45 %</option>
                                        <option value="50">50 %</option>
                                        <option value="55">55 %</option>
                                        <option value="60">60 %</option>
                                        <option value="65">65 %</option>
                                        <option value="70">70 %</option>
                                        <option value="75">75 %</option>
                                        <option value="80">80 %</option>
                                        <option value="85">85 %</option>
                                        <option value="90">90 %</option>
                                        <option value="100">100 %</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Status</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control disabled" id="status1" name="status1">
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#progres_hasil').change(function() {
                                    var progres_hasil = $('#progres_hasil').val();
                                    if (progres_hasil == 100) {
                                        $('#status1').val('9');
                                    } else {
                                        $('#status1').val('3');
                                    }
                                });
                            });
                        </script>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-success">SIMPAN</button>
                            <br>
                            <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Aktivitas -->
<div class="modal fade" id="tambahAktivitas" tabindex="-1" role="dialog" aria-labelledby="tambahAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">AKTIVITAS LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/tambah_aktivitas_realisasi'); ?>">
                    <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $lembur['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Kategori</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="kategori" id="kategori" title="Pilih" data-style="select-with-transition" data-size="5" data-width="fit" data-live-search="false" onchange="kategoriSelect(this);" required>
                                        <?php foreach ($kategori as $k) : ?>
                                            <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <label class="col-md-4 col-form-label">Copro</label>
                            <div class="col-md-7" id="admCopro">
                                <div class="form-group has-default" >
                                    <select class="selectpicker" name="copro" id="copro" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                    <?php
                                        $queyCopro = "SELECT * FROM project where status='open' or status='teco' ";
                                        $copro = $this->db->query($queyCopro)->result_array();
                                        foreach ($copro as $c) : ?>
                                            <option data-subtext="<?= $c['deskripsi']; ?>" value="<?= $c['copro']; ?>"><?= $c['copro']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7" id="admWbs">
                                <div class="form-group has-default">
                                    <select class="form-control" name="akt_wbs" id="akt_wbs" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" required></select>
                                </div>
                            </div>
                            <div class="col-md-7" id="admAkt" style="display:none;">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" id="akt" name="akt" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Deskripsi Hasil</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="deskripsi_hasil" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <option value="+30 minute">00:30 Jam</option>
                                        <option value="+60 minute">01:00 Jam</option>
                                        <option value="+90 minute">01:30 Jam</option>
                                        <option value="+120 minute">02:00 Jam</option>
                                        <option value="+150 minute">02:30 Jam</option>
                                        <option value="+180 minute">03:00 Jam</option>
                                        <option value="+210 minute">03:30 Jam</option>
                                        <option value="+240 minute">04:00 Jam</option>
                                        <option value="+270 minute">04:30 Jam</option>
                                        <option value="+300 minute">05:00 Jam</option>
                                        <option value="+330 minute">05:30 Jam</option>
                                        <option value="+360 minute">06:00 Jam</option>
                                        <option value="+390 minute">06:30 Jam</option>
                                        <option value="+420 minute">07:00 Jam</option>
                                        <option value="+450 minute">07:30 Jam</option>
                                        <option value="+480 minute">08:00 Jam</option>
                                        <option value="+510 minute">08:30 Jam</option>
                                        <option value="+540 minute">09:00 Jam</option>
                                        <option value="+570 minute">09:30 Jam</option>
                                        <option value="+600 minute">10:00 Jam</option>
                                        <option value="+630 minute">10:30 Jam</option>
                                        <option value="+660 minute">11:00 Jam</option>
                                        <option value="+690 minute">11:30 Jam</option>
                                        <option value="+720 minute">12:00 Jam</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Progres</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="progres_hasil" id="progres_hasil" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <option value="10">10 %</option>
                                        <option value="25">25 %</option>
                                        <option value="50">50 %</option>
                                        <option value="55">55 %</option>
                                        <option value="60">60 %</option>
                                        <option value="65">65 %</option>
                                        <option value="70">70 %</option>
                                        <option value="75">75 %</option>
                                        <option value="80">80 %</option>
                                        <option value="85">85 %</option>
                                        <option value="90">90 %</option>
                                        <option value="95">95 %</option>
                                        <option value="100">100 %</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-success">SIMPAN</button>
                            <br>
                            <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah Jam-->
<div class="modal fade" id="ubhTanggal" tabindex="-1" role="dialog" aria-labelledby="ubhTanggalTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">UBAH JAM LEMBUR</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('lembur/gtJamRelalisai'); ?>">
                        <div class="modal-body">
                        <div class="card-body">
                            <div class="row" hidden>
                                <label class="col-md-5 col-form-label">Lembur ID</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="id" name="id" value="<?= $lembur['id']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-5 col-form-label">Jam Mulai</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default" id="jammulai">
                                        <input type="text" class="form-control timepicker" id="jammulai" name="jammulai" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-success">UBAH JAM</button>
                        </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Batal Aktivitas-->
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalAktivitasTitle" aria-hidden="true">
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
                <form class="form" method="post" action="<?= base_url('lembur/batal_lembur'); ?>">
                    <div class="modal-body">
                        <input type="text" class="form-control disabled" name="id">
                        <textarea rows="2" class="form-control" name="catatan" id="catatan" placeholder="Keterangan Pembatalan Lembur" required></textarea>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-danger">BATALKAN LEMBUR INI!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>