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
            <h4 class="card-title">Data Lembur</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Tgl Mengajukan</th>
                    <th>Tanggal & Jam Mulai</th>
                    <th>Durasi</th>
                    <th>Admin GA</th>
                    <th>Admin HR</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="disabled-sorting text-right">Actions</th>
                    <th class="disabled-sorting"></th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Tgl Mengajukan</th>
                    <th>Tanggal & Jam Mulai</th>
                    <th>Durasi</th>
                    <th>Admin GA</th>
                    <th>Admin HR</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($lembur as $l) : ?>
                    <tr>
                      <td><?= $l['id']; ?></td>
                      <td><?= $l['tglpengajuan']; ?></td>
                      <td><?= date('d-M H:i', strtotime($l['tglmulai'])); ?></td>
                          <?php if($l['status']== '1' or $l['status']== '2' or $l['status']== '3' or $l['status']== '4' or $l['status']== '10' or $l['status']== '11') {?>
                      <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                          <?php } else { ?>
                      <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                          <?php }; ?>
                      <td><?= $l['admin_ga']; ?></td>
                      <td><?= $l['admin_hr']; ?></td>
                      <td><?= $l['catatan']; ?></td>
                      <?php $status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array(); ?>
                      <td><?= $status['nama']; ?></td>
                      <td>
                          <?php if ($l['status'] == '4' or $l['status'] == '5' or $l['status'] == '6' or $l['status'] == '12' or $l['status'] == '13') { ?>
                              <a href="<?= base_url('lembur/realisasi_aktivitas/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php }else if ($l['status'] == '0' or $l['status'] == '7' or $l['status'] == '8' or $l['status'] == '9') { ?>
                            <a href="<?= base_url('lembur/lemburku/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php } else { ?>
                              <a href="<?= base_url('lembur/rencana_aktivitas/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php }; ?>
                      </td>
                      <td class="text-right">
                          <?php if ($l['status'] == '9' ) { ?>
                            <a href="<?= base_url('lembur/laporan_lembur/') . $l['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit" target="_blank"><i class="material-icons">dvr</i></a>
                          <?php } else { ?>
                            <a href="<?= base_url('lembur/laporan_lembur/') . $l['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit disabled"><i class="material-icons">dvr</i></a>
                          <?php }; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
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
<!-- Modal -->

