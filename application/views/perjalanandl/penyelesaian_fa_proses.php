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
                                <label class="col-md-2 col-form-label">Peserta</label>
                                <div class="col-md-8">
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
                                                    <th>Status</th>
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
                                                        <?php if ($a['status_pembayaran'] == 'BELUM DIBAYAR'){ ?>
                                                            <td><a href="<?= base_url('perjalanandl/bayar/'.$perjalanan['id'].'/'.$a['npk']); ?>" class="btn btn-sm btn-fill btn-danger" data-toggle="modal" data-target="#payment" data-id="<?= $perjalanan['id']; ?>" data-npk="<?= $a['npk']; ?>" data-ewallet1="<?= $peserta['ewallet_1']; ?>" data-ewallet2="<?= $peserta['ewallet_2']; ?>">BAYAR SEKARANG!</a></td>
                                                        <?php }else{ ?>
                                                            <td><a href="#" class="btn btn-sm btn-fill btn-success disabled">SUDAH DIBAYAR</a></td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <p>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Tunjangan </br><small>Peserta</small></label>
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Biaya</th>
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($perjalanan['kepemilikan']!='Operasional'){?>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Kilometer</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kmtotal" value="<?= $perjalanan['kmtotal']; ?> Km">
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
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Total</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="total" value="<?= number_format($perjalanan['total'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Kasbon/</br><small>Transfer</small></label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kasbon" value="<?= number_format($perjalanan['kasbon_out'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Kasbon/</br><small>Dikembalikan</small></label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kasbon" value="<?= number_format($perjalanan['kasbon_in'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Sudah Dibayar<br><small>+Kasbon</small></label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kasbon" value="<?= number_format($perjalanan['bayar'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Selisih</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="selisih" value="<?= number_format($perjalanan['selisih'], 0, ',', '.'); ?>">
                                        </div>
                                        <small>*(+)Uang yang harus berikan ke peserta.</small></br>
                                        <small>*(--)Uang yang harus kembalikan.</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                        <?php if ($perjalanan['selisih']==0){
                                            echo '<button type="submit" class="btn btn-fill btn-success">SUDAH DIBAYAR SEMUA</button>';
                                        }else{
                                            echo '<button type="submit" class="btn btn-fill btn-default disabled">BELUM DIBAYAR SEMUA</button>';
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
                        <label class="col-md-5 col-form-label">GO-PAY</label>
                        <div class="col-md-6">
                            <div class="form-group has-default">
                                <input class="form-check-input d-inline-block ml-1" type="radio" name="ewallet" value="gopay" checked requierd/>
                                <input type="text" class="form-control bg-white ml-4" id="ewallet1" name="ewallet1" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">DANA</label>
                        <div class="col-md-6">
                            <div class="form-group has-default">
                                <input class="form-check-input d-inline-block ml-1" type="radio" name="ewallet" value="dana" requierd/>
                                <input type="text" class="form-control bg-white ml-4" id="ewallet2" name="ewallet2" readonly/>
                            </div>
                        </div>
                    </div>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#payment').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var npk = button.data('npk')
            var ewallet1 = button.data('ewallet1')
            var ewallet2 = button.data('ewallet2')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="npk"]').val(npk)
            modal.find('.modal-body input[name="ewallet1"]').val(ewallet1)
            modal.find('.modal-body input[name="ewallet2"]').val(ewallet2)
        })

        $('#revisiPenyelesaian').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-body input[name="id"]').val(id)
        })
    });  
</script>