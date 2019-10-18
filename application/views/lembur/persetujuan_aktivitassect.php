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
                        <h4 class="card-title">Persetujuan Rencana Lembur</h4>
                    </div>
                    <form class="form" method="post" action="<?= base_url('lembur/setujui_aktivitas'); ?>">
                    <div class="card-body">
                        <div class="row" hidden>
                            <label class="col-md-1 col-form-label">Lembur ID</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id" value="<?= $lembur['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Nama</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="nama" name="nama" value="<?= $lembur['nama']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Tanggal Mulai</label>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control datetimepicker disabled" placeholder="With Material Icons" id="tglmulai" name="tglmulai" value="<?= $lembur['tglmulai']; ?>">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text">
                                            <?php
                                                $lid = $lembur['id'];
                                                $queryLembur = "SELECT COUNT(*)
                                                        FROM `aktivitas`
                                                        WHERE `link_aktivitas` = '$lid' ";
                                                        $totalLembur = $this->db->query($queryLembur)->row_array();
                                                        $totalAktivitas = $totalLembur['COUNT(*)'];
                                            ;?>
                                            <?php if($totalAktivitas >= '1') {?>
                                                <a href="#" class="btn btn-link btn-warning btn-just-icon edit disabled"><i class="material-icons" data-toggle="modal" data-target="#ubhTanggal" data-id="<?= $lembur['id']; ?>">dvr</i></a>
                                            <?php } else { ?>
                                                <a href="#" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons" data-toggle="modal" data-target="#ubhTanggal" data-id="<?= $lembur['id']; ?>">dvr</i></a>
                                            <?php } ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Tanggal Selesai</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datetimepicker disabled" id="tglselesai" name="tglselesai" value="<?= $lembur['tglselesai']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Status</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                <?php $status = $this->db->get_where('lembur_status', ['id' => $lembur['status']])->row_array(); ?>
                                    <input type="text" class="form-control disabled" id="status" name="status" value="<?= $status['nama']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Total Aktivitas</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                <?php
                                    $lid = $lembur['id'];
                                    $queryLembur = "SELECT COUNT(*)
                                            FROM `aktivitas`
                                            WHERE `link_aktivitas` = '$lid' ";
                                            $totalLembur = $this->db->query($queryLembur)->row_array();
                                            $totalAktivitas = $totalLembur['COUNT(*)'];
                                ;?>
                                    <input type="text" class="form-control disabled" id="total_aktivitas" name="total_aktivitas" value="<?= $totalAktivitas; ?>">
                                </div>
                            </div>
                        </div>
                        </form>
                        <br>
                        <div class="toolbar">
                        <?php if ($this->session->userdata['posisi_id'] == '3' and $lembur['status'] == '3'){ ?>
                                    <a href="#" id="tambah_aktivitas" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">TAMBAH AKTIVITAS</a>
                                <?php } else if ($this->session->userdata['posisi_id'] == '5' and $lembur['status'] == '2'){ ?>
                                    <a href="#" id="tambah_aktivitas" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">TAMBAH AKTIVITAS</a>
                                <?php } else if ($this->session->userdata['posisi_id'] == '3' and $lembur['status'] == '1' or $lembur['status'] == '2' or $lembur['status'] == '3') { ?>
                                    <a href="#" id="tambah_aktivitas" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">TAMBAH AKTIVITAS</a>
                                <?php  }; ?>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover"  cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Aktivitas</th>
                                        <!-- <th>jenis Aktivitas</th> -->
                                        <th>Kategori</th>
                                        <th>COPRO</th>
                                        <!-- <th>WBS</th> -->
                                        <th>Rencana Aktivitas</th>
                                        <th>Durasi/Jam</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Aktivitas</th>
                                        <!-- <th>jenis Aktivitas</th> -->
                                        <th>Kategori</th>
                                        <th>COPRO</th>
                                        <!-- <th>WBS</th> -->
                                        <th>Rencana Aktivitas</th>
                                        <th>Durasi/Jam</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($aktivitas as $a) : ?>
                                        <tr>
                                            <td><?= $a['id']; ?></td>
                                            <!-- <td><?= $a['jenis_aktivitas']; ?></td> -->
                                            <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                            <td><?= $k['nama']; ?></td>
                                            <td><?= $a['copro']; ?></td>
                                            <!-- <td><?= $a['wbs']; ?></td> -->
                                            <td><?= $a['aktivitas']; ?></td>
                                            <td><?= $a['durasi']; ?> Jam</td>
                                            <?php $status = $this->db->get_where('aktivitas_status', ['id' => $a['status']])->row_array(); ?>
                                                <td><?= $status['nama']; ?></td>
                                            <td class="text-right">
                                            <?php if ($lembur['status'] !='7'){ ?>
                                                <a href="#" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons" data-toggle="modal" data-target="#ubahAktivitas" data-id="<?= $a['id']; ?>" data-kategori="<?= $a['kategori']; ?>" data-copro="<?= $a['copro']; ?>" data-aktivitas="<?= $a['aktivitas']; ?>" data-durasi="<?= $a['durasi']; ?>">dvr</i></a>
                                                <a href="<?= base_url('lembur/hapus_sect/'). $a['id']; ?>" class="btn-bataldl"><i class="material-icons">delete</i></a> 
                                            <?php }else{ ?>
                                                <a href="#" class="btn btn-link btn-warning btn-just-icon edit disabled"><i class="material-icons" data-toggle="modal" data-target="#ubahAktivitas" data-id="<?= $a['id']; ?>">dvr</i></a>
                                                <a href="<?= base_url('lembur/hapus_sect/'). $a['id']; ?>" class="btn-bataldl disabled"><i class="material-icons">delete</i></a> 
                                            <?php }; ?>   
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php if ($this->session->userdata['posisi_id'] == '3' and $lembur['status'] == '3'){ ?>
                                    <button type="submit"  id="setujui" class="btn btn-success">SETUJUI</button>
                                    <a href="#" id="batalAktivitas" class="btn btn-rose" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                                <?php } else if ($this->session->userdata['posisi_id'] == '5' and $lembur['status'] == '2'){ ?>
                                    <button type="submit"  id="setujui" class="btn btn-success">SETUJUI</button>
                                    <a href="#" id="batalAktivitas" class="btn btn-rose" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                                <?php } else if ($this->session->userdata['posisi_id'] == '3' and $lembur['status'] == '1' or $lembur['status'] == '2') { ?>
                                    <button type="submit"  id="setujui" class="btn btn-success">SETUJUI</button>
                                <?php  }; ?>
                                     <a href="<?= base_url('lembur/persetujuan_lembur/') ?>" class="btn btn-default" role="button">Kembali</a>
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
<!-- Modal Tambah aktivitas-->
<div class="modal fade" id="tambahAktivitas" tabindex="-1" role="dialog" aria-labelledby="tambahAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">RENCANA LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/tambah_aktivitas_sect'); ?>">
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
                                    <select class="selectpicker" name="kategori" id="kategori" data-style="select-with-transition" title="Pilih" data-size="3" required>
                                        <?php foreach ($kategori as $k) : ?>
                                            <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">COPRO</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="copro" id="copro" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required >
                                        <?php
                                        $queyCopro = "SELECT *
                                                                    FROM `project`
                                                                    ORDER BY `status` ASC
                                                                    ";
                                        $copro = $this->db->query($queyCopro)->result_array();
                                        foreach ($copro as $c) : ?>
                                            <option data-subtext="<?= $c['deskripsi']; ?>"value="<?= $c['copro']; ?>"><?= $c['copro']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                            <script>
                                $(document).ready(function(){
                                    $('#kategori').change(function(){
                                    var kategori = $('#kategori').val();
                                    if(kategori==3){
                                        $('#copro').prop('disabled', true);
                                        }else{
                                        $('#copro').prop('disabled', false);
                                        }
                                    });
                                });
                            </script>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="aktivitas" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required >
                                            <option value="+30 minute">30:00 Menit</option>
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
                                            <option value="+620 minute">12:00 Jam</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                            <br>
                            <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update aktivitas-->
<div class="modal fade" id="ubahAktivitas" tabindex="-1" role="dialog" aria-labelledby="ubahAktivitas" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-warning text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title"> UBAH AKTIVITAS LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/update_aktivitas'); ?>">
                <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Ativitas ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id" value="<?= $a['id']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Ativitas ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $a['link_aktivitas']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Kategori</label>
                            <div class="col-md-7">
                                <div class="form-group has-default disabled">
                                    <select class="selectpicker" name="kategori" id="kategori" data-style="select-with-transition" title="Pilih" data-size="3" value="<?= $a['kategori']; ?>" required>
                                    <?php
                                    $kategori = $this->db->get('jamkerja_kategori')->result_array();
                                    foreach ($kategori as $k) :
                                        echo '<option value="' .$k['id']. '"';
                                        if ($k['id'] == $a['kategori']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $k['nama'] . '</option>' . "\n";
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">COPRO</label>
                            <div class="col-md-7">
                                <div class="form-group has-default disabled">
                                    <select class="selectpicker" name="copro" id="copro" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required >
                                        <?php
                                        $queyCopro = "SELECT *
                                                                    FROM `project`
                                                                    ORDER BY `status` ASC
                                                                    ";
                                        $copro = $this->db->query($queyCopro)->result_array();
                                        foreach ($copro as $c) : 
                                            echo '<option value="' .$c['copro']. '"';
                                            if ($c['copro']== $a['copro']) {
                                                echo 'selected';
                                            }
                                            echo '>' .$c['copro']. '</option>' ."\n";
                                        endforeach; ?>   
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                <input type="text" class="form-control" id="aktivitas" name="aktivitas" value="<?= $a['aktivitas']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" value="<?= $a['durasi']; ?>" required >
                                    <!-- <?php
                                        $queyDurasi = "SELECT *
                                                                    FROM `aktivitas`
                                                                    ORDER BY `durasi` ASC
                                                                    ";
                                        $durasi = $this->db->query($queyDurasi)->result_array();
                                        foreach ($durasi as $d) : 
                                            echo '<option value="' .$d['durasi']. '"';
                                            if ($d['copro']== $a['durasi']) {
                                                echo 'selected';
                                            }
                                            echo '>' .$d['copro']. '</option>' ."\n";
                                        endforeach; ?>   
                                            <option value="<?= $d['durasi']; ?>" selected><?= $d['durasi']; ?></option> -->
                                            <option value="+30 minute">30:00 Menit</option>
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
                                            <option value="+620 minute">12:00 Jam</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-warning">SIMPAN</button>
                            <br>
                            <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#kategori').change(function(){
        var kategori = $('#kategori').val();
        if(kategori==3){
            $('#copro').prop('disabled', true);
            }else{
            $('#copro').prop('disabled', false);
            }
        });
    });
</script>
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
            <button type="submit" class="btn btn-rose">BATALKAN LEMBUR INI!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Ubah tanggal-->
<div class="modal fade" id="ubhTanggal" tabindex="-1" role="dialog" aria-labelledby="ubhTanggalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-primary text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">GANTI TANGGAL LEMBUR</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('lembur/gantitgl_lembur_sect'); ?>">
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
                <label class="col-md-4 col-form-label">TGL Mulai</label>
                <div class="col-md-7">
                    <div class="form-group has-default">
                    <input type="text" class="form-control datetimepicker" id="tglmulai" name="tglmulai" value="<?= $lembur['tglmulai']; ?>">
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-rose">Ganti Tanggal!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>