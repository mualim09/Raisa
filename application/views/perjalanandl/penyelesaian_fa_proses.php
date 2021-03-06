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
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('perjalanandl/payment/submit'); ?>" method="post">
                            <div class="row" hidden="true">
                                <label class="col-md-2 col-form-label">Nomor Perjalanan</label>
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
                                <label class="col-md-2 col-form-label">Tanggal (Jam)</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                    <?php if ($perjalanan['tglberangkat'] == $perjalanan['tglkembali']){ ?>
                                        <input type="text" class="form-control disabled" id="tgl" name="tgl" value="<?= date("d M Y", strtotime($perjalanan['tglberangkat'])) .' ('.date("H:i", strtotime($perjalanan['jamberangkat'])) . ' - ' . date("H:i", strtotime($perjalanan['jamkembali'])).') '; ?>">
                                    <?php }else{ ?>
                                        <input type="text" class="form-control disabled" id="tgl" name="tgl" value="<?= date("d M Y", strtotime($perjalanan['tglberangkat'])) . ' - ' .date("d M Y", strtotime($perjalanan['tglkembali'])); ?>">
                                    <?php }?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tujuan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tujuan" value="<?= $perjalanan['tujuan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Total Jarak</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="kmtotal" value="<?= $perjalanan['kmtotal']; ?> Km">
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
                                <label class="col-md-2 col-form-label">Tunjangan </br><small>Peserta</small></label>
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <?php if ($perjalanan['uang_saku']>0){ echo '<th><small>Uang Saku</small></th>'; } ?>
                                                    <?php if ($perjalanan['insentif_pagi']>0){ echo '<th><small>Insentif</small></th>';} ?>
                                                    <?php if ($perjalanan['um_pagi']>0){ echo '<th><small>Pagi</small></th>';} ?>
                                                    <?php if ($perjalanan['um_siang']>0){ echo '<th><small>Siang</small></th>';} ?>
                                                    <?php if ($perjalanan['um_malam']>0){ echo '<th><small>Malam</small></th>';} ?>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $queryAnggota = "SELECT *
                                                        FROM `perjalanan_anggota`
                                                        WHERE `perjalanan_id` = '{$perjalanan['id']}'
                                                        ";
                                                $anggota = $this->db->query($queryAnggota)->result_array();
                                                $totalTunj = 0;
                                                foreach ($anggota as $a) : 
                                                $peserta = $this->db->get_where('karyawan', ['npk' => $a['npk']])->row_array(); ?>
                                                    <tr>
                                                        <td><?= $a['karyawan_inisial']; ?></td>
                                                        <?php if ($a['karyawan_inisial']==$perjalanan['pic_perjalanan']){ ?>
                                                            <td><?= '<a href="#" class="btn btn-link btn-success btn-just-icon" data-toggle="tooltip" data-placement="top" title="PIC Perjalanan"><i class="material-icons">military_tech</i></a>'.$a['karyawan_nama']; ?></td>
                                                        <?php }else{ ?>
                                                            <td><?= '<a href="#" class="btn btn-link btn-default btn-just-icon" data-toggle="tooltip" data-placement="top" title="Peserta"><i class="material-icons">military_tech</i></a>'.$a['karyawan_nama']; ?></td>
                                                        <?php } ?>
                                                        <?php if ($perjalanan['uang_saku']>0){ echo '<td><small>'.number_format($a['uang_saku'], 0, ',', '.').'</small></td>'; } ?>
                                                        <?php if ($perjalanan['insentif_pagi']>0){ echo '<td><small>'.number_format($a['insentif_pagi'], 0, ',', '.').'</small></td>';} ?>
                                                        <?php if ($perjalanan['um_pagi']>0){ echo '<td><small>'.number_format($a['um_pagi'], 0, ',', '.').'</small></td>';} ?>
                                                        <?php if ($perjalanan['um_siang']>0){ echo '<td><small>'.number_format($a['um_siang'], 0, ',', '.').'</small></td>';} ?>
                                                        <?php if ($perjalanan['um_malam']>0){ echo '<td><small>'.number_format($a['um_malam'], 0, ',', '.').'</small></td>';} ?>
                                                        <?php if ($perjalanan['pic_perjalanan'] == $a['karyawan_inisial']){ 
                                                            $tunjPeserta = number_format($a['total'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'] - $perjalanan['kasbon'], 0, ',', '.');
                                                            $sisa = number_format(($a['total'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir']) - ($perjalanan['kasbon'] + $a['bayar']), 0, ',', '.'); ?>
                                                            <td>
                                                            <?= $tunjPeserta; ?><br>
                                                            <small>Rincian :</small><br>
                                                            <small>+ <?= number_format($a['total'], 0, ',', '.'); ?> (Tunjangan)</small><br>
                                                            <small>+ <?= number_format($perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'], 0, ',', '.'); ?> (Perjalanan)</small><br>
                                                            <small>- <?= number_format($perjalanan['kasbon'], 0, ',', '.'); ?> (Kasbon)</small>
                                                            </td>
                                                        <?php }else{ 
                                                            $tunjPeserta = number_format($a['total'], 0, ',', '.');
                                                            $sisa = number_format($a['total'] - $a['bayar'], 0, ',', '.'); ?>
                                                            <td><?= $tunjPeserta; ?></td>
                                                        <?php } ?>
                                                        <?php if ($a['status_pembayaran'] == 'BELUM DIBAYAR' AND $tunjPeserta > 0){
                                                            
                                                            if ($peserta['ewallet_utama']=='GOPAY'){ 
                                                                $ewallet = 'GOPAY - '.$peserta['ewallet_1'];
                                                            } elseif ($peserta['ewallet_utama']=='DANA'){ 
                                                                $ewallet = 'DANA - '.$peserta['ewallet_2'];
                                                            } elseif ($peserta['ewallet_utama']=='ASTRAPAY'){ 
                                                                $ewallet = 'ASTRAPAY - '.$peserta['ewallet_3'];
                                                            } 
                                                            
                                                                $astrapay = 'ASTRAPAY - '.$peserta['ewallet_3'];
                                                                $gopay = 'GOPAY - '.$peserta['ewallet_1'];
                                                                $dana = 'DANA - '.$peserta['ewallet_2'];
                                                                
                                                            ?>
                                                            <td><a href="<?= base_url('perjalanandl/bayar/'.$perjalanan['id'].'/'.$a['npk']); ?>" class="btn btn-sm btn-fill btn-danger" data-toggle="modal" data-target="#payment" data-id="<?= $perjalanan['id']; ?>" data-npk="<?= $a['npk']; ?>" data-tunj="<?= $tunjPeserta; ?>" data-bayar="<?= $a['bayar']; ?>" data-sisa="<?= $sisa; ?>" data-ewallet="<?= $ewallet; ?>" data-astrapay="<?= $astrapay; ?>" data-gopay="<?= $gopay; ?>" data-dana="<?= $dana; ?>">BAYAR SEKARANG!</a></td>
                                                        <?php 
                                                        }elseif ($a['status_pembayaran'] == 'BELUM DIBAYAR' AND $tunjPeserta == 0){ 
                                                            echo '<td><a href="#" class="btn btn-sm btn-fill btn-default disabled">LUNAS*</a></td>';
                                                        }else{
                                                            echo '<td><a href="#" class="btn btn-sm btn-fill btn-success disabled">LUNAS</a></td>';
                                                         } ?>
                                                    </tr>
                                                <?php 
                                                $totalTunj = $totalTunj + $a['total']; 
                                                endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php if ($perjalanan['kasbon_out'] > 0){ ?>
                                <div class="row">
                                <label class="col-md-2 col-form-label">Kasbon</label>
                                <div class="col-md-8">
                                    <div class="material-datatables">
                                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Out</th>
                                                    <th>In</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?= number_format($perjalanan['kasbon_out'], 0, ',', '.'); ?></td>
                                                    <td><?= number_format($perjalanan['kasbon_in'], 0, ',', '.'); ?></td>
                                                    <td><?= number_format($perjalanan['kasbon'], 0, ',', '.'); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Rincian Biaya </br><small>Perjalanan</small></label>
                                <div class="col-md-8">
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
                                                    <td>Tunjangan</td>
                                                    <td><?= number_format($totalTunj, 0, ',', '.'); ?></td>
                                                </tr>
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Pembayaran</label>
                                <div class="col-md-8">
                                    <div class="material-datatables">
                                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <td><strong>TOTAL</strong></td>
                                                    <td><strong><?= number_format($perjalanan['total'], 0, ',', '.'); ?></strong></td>
                                                </tr>
                                                <!-- <tr>
                                                    <td><strong>KASBON</strong></td>
                                                    <td><strong>(<?= number_format($perjalanan['kasbon'], 0, ',', '.'); ?>)</strong></td>
                                                </tr> -->
                                                <tr>
                                                    <td><strong>DIBAYAR</strong></td>
                                                    <td><strong><?= number_format($perjalanan['bayar'], 0, ',', '.'); ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>SELISIH</strong></td>
                                                    <td><strong><?= number_format($perjalanan['selisih'], 0, ',', '.'); ?></strong></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <div class="form-group has-default">
                                    <?php 
                                    $this->db->where('perjalanan_id', $perjalanan['id']);
                                    $this->db->where('status_pembayaran', 'BELUM DIBAYAR');
                                    $unpayment = $this->db->get('perjalanan_anggota')->row_array();
                                    
                                    if ($perjalanan['selisih']==0){
                                        echo '<button type="submit" class="btn btn-fill btn-success">SELESAI</button>';
                                    }else{
                                        // echo '<button type="submit" class="btn btn-fill btn-default disabled">SILAHKAN BAYAR DULU</button>';
                                        echo '<small>Masih ada peserta yang belum dibayar</small></br>';
                                        echo '<a href="#" class="btn btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#selesaiPenyelesaian" data-id="'. $perjalanan['id'] .'">SILAHKAN BAYAR/SELESAIKAN</a>';
                                    }?>
                                        <a href="#" class="btn btn-warning" role="button" aria-disabled="false" data-toggle="modal" data-target="#revisiPenyelesaian" data-id="<?= $perjalanan['id']; ?>">REVISI</a>
                                        <a href="<?= base_url('perjalanandl/payment/daftar'); ?>" class="btn btn-link btn-default">Kembali</a>
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
<div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="paymentLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentLabel">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/bayar'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <input type="hidden" class="form-control" id="npk" name="npk">
                    <div class="row">
                        <label class="col-md-4 col-form-label">Tunjangan</label>
                        <div class="col-md-6">
                            <div class="form-group has-default">
                                <input type="text" class="form-control bg-white ml-4" id="tunj" name="tunj" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-4 col-form-label">Sudah Dibayar</label>
                        <div class="col-md-6">
                            <div class="form-group has-default">
                                <input type="text" class="form-control bg-white ml-4" id="bayar" name="bayar" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-4 col-form-label">Belum Dibayar</label>
                        <div class="col-md-6">
                            <div class="form-group has-default">
                                <input type="text" class="form-control bg-white ml-4" id="sisa" name="sisa" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-4 col-form-label">Dompet</label>
                        <div class="col-md-6">
                            <div class="form-group has-default">
                                <input class="form-check-input d-inline-block ml-1" type="radio" name="ewallet" value="utama" checked required/>
                                <input type="text" class="form-control bg-white ml-4" id="no_ewallet" name="no_ewallet" readonly/>
                            </div>
                        </div>
                    </div>
                    <p>
                    <div class="progress" style="width: 100%">
                        <div class="progress-bar progress-bar-info" role="progressbar" style="width: 100%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="1"></div>
                    </div>
                    <h6>
                    <div class="row">
                        <label class="col-md-2 col-form-label">ASTRAPAY</label>
                        <div class="col-md-8">
                            <div class="form-group has-default">
                                <input class="form-check-input d-inline-block ml-1" type="radio" name="ewallet" value="astrapay" required/>
                                <input type="text" class="form-control bg-white ml-4" id="astrapay" name="astrapay" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 col-form-label">GOPAY </br><small>(GOL1-3)</small></label>
                        <div class="col-md-8">
                            <div class="form-group has-default">
                                <input class="form-check-input d-inline-block ml-1" type="radio" name="ewallet" value="gopay" required/>
                                <input type="text" class="form-control bg-white ml-4" id="gopay" name="gopay" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 col-form-label">DANA</label>
                        <div class="col-md-8">
                            <div class="form-group has-default">
                                <input class="form-check-input d-inline-block ml-1" type="radio" name="ewallet" value="dana" required/>
                                <input type="text" class="form-control bg-white ml-4" id="dana" name="dana" readonly/>
                            </div>
                        </div>
                    </div>
                                </h6>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <!-- <label class="col-md-5 col-form-label"></label> -->
                        <div class="col-md-12 mr-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                            <button type="submit" class="btn btn-success">TRANSFER</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <small>Tranfernya pake aplikasi e-Wallet di HP ya!</small>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="revisiPenyelesaian" tabindex="-1" role="dialog" aria-labelledby="revisiPenyelesaianTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <!-- <div class="modal-header">
          <div class="card-header card-header-info text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">REVISI PENYELESAIAN</h4>
          </div>
        </div> -->
        <form class="form" method="post" action="<?= base_url('perjalanandl/penyelesaian/revisi'); ?>">
          <div class="modal-body">
            <input type="hidden" class="form-control disabled" name="id">
            <textarea rows="3" class="form-control" name="catatan" id="catatan" placeholder="Berikan penjelasan untuk revisi" required></textarea>
          </div>
          <div class="modal-footer justify-content-right">
            <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
            <button type="submit" class="btn btn-success">SUBMIT</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="selesaiPenyelesaian" tabindex="-1" role="dialog" aria-labelledby="selesaiPenyelesaianTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-info text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">SELESAIKAN PERJALANAN INI?</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('perjalanandl/payment/submit'); ?>">
          <div class="modal-body">
            <input type="hidden" class="form-control" name="id">
          </div>
          <div class="modal-footer justify-content-right">
            <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
            <button type="submit" class="btn btn-success">SUBMIT</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#payment').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var npk = button.data('npk')
            var tunj = button.data('tunj')
            var bayar = button.data('bayar')
            var sisa = button.data('sisa')
            var ewallet = button.data('ewallet')
            var astrapay = button.data('astrapay')
            var gopay = button.data('gopay')
            var dana = button.data('dana')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="npk"]').val(npk)
            modal.find('.modal-body input[name="tunj"]').val(tunj)
            modal.find('.modal-body input[name="bayar"]').val(bayar)
            modal.find('.modal-body input[name="sisa"]').val(sisa)
            modal.find('.modal-body input[name="no_ewallet"]').val(ewallet)
            modal.find('.modal-body input[name="astrapay"]').val(astrapay)
            modal.find('.modal-body input[name="gopay"]').val(gopay)
            modal.find('.modal-body input[name="dana"]').val(dana)
        })

        $('#revisiPenyelesaian').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-body input[name="id"]').val(id)
        })

        $('#selesaiPenyelesaian').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-body input[name="id"]').val(id)
        })
    });  
</script>