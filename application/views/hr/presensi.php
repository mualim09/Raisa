<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-text">
              <h4 class="card-title">Presensi</h4>
              <p class="card-category">Periode <?= date('F Y', strtotime("$tahun-$bulan-01")); ?></p>
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <form class="form" method="post" action="<?= base_url('hr/presensi/bulan'); ?>">
                <div class="form-group">
                  <!-- <label for="month" class="bmd-label-floating">Select Month *</label> -->
                  <select class="selectpicker" data-style="btn btn-link" id="month" name="month" title="Pilih Bulan" onchange='this.form.submit()' data-size="7" data-live-search="true" required>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                  </select>
                </div>
              </form>
              <a href="<?= base_url('hr/presensi/tanggal'); ?>" class="btn btn-facebook">
                <span class="btn-label">
                  <i class="material-icons">today</i>
                </span>
                PRESENSI PER HARI
              </a>
              <a href="<?= base_url('hr/download/presensi'); ?>" class="btn btn-linkedin" target="_blank">
                <span class="btn-label">
                  <i class="material-icons">cloud_download</i>
                </span>
                RAW DATA FOR DOWNLOAD
              </a>
            </div>
            <div class="material-datatables">
              <div class="table-responsive">
                <table id="dt-presensi" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th rowspan="2">Nama</th>
                      <th rowspan="2">Tanggal</th>
                      <th colspan="3" style="text-align: center;">MASUK</th>
                      <th colspan="3" style="text-align: center;">KELUAR</th>
                    </tr>
                    <tr>
                      <th>Waktu</th>
                      <th>Status</th>
                      <th>Lokasi</th>
                      <th>Waktu</th>
                      <th>Status</th>
                      <th>Lokasi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $this->db->where('is_active', '1');
                    $this->db->where('status', '1');
                    $users_wtq = $this->db->get('karyawan')->result_array();
                    foreach ($users_wtq as $k) {
                      $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                      for ($i = 1; $i < $tanggal + 1; $i++) {

                        //clock in
                        $this->db->where('npk', $k['npk']);
                        $this->db->where('year(time)', $tahun);
                        $this->db->where('month(time)', $bulan);
                        $this->db->where('day(time)', $i);
                        $this->db->where('state', 'C/In');
                        $in = $this->db->get('presensi')->row_array();

                        //clock Rest
                        $this->db->where('npk', $k['npk']);
                        $this->db->where('year(time)', $tahun);
                        $this->db->where('month(time)', $bulan);
                        $this->db->where('day(time)', $i);
                        $this->db->where('state', 'C/Rest');
                        $rest = $this->db->get('presensi')->row_array();

                        //clock out
                        $this->db->where('npk', $k['npk']);
                        $this->db->where('year(time)', $tahun);
                        $this->db->where('month(time)', $bulan);
                        $this->db->where('day(time)', $i);
                        $this->db->where('state', 'C/Out');
                        $out = $this->db->get('presensi')->row_array();
                        echo '<tr>';
                        echo '<th>' . $k['nama'] . '</th>';
                        if (date('D', strtotime($tahun . '-' . $bulan . '-' . $i)) == 'Sat' or date('D', strtotime($tahun . '-' . $bulan . '-' . $i)) == 'Sun') {
                          echo '<th class="table-warning">' . date('m-d-Y', strtotime($tahun . '-' . $bulan . '-' . $i)) . '</th>';
                        } else {
                          echo '<th>' . date('m-d-Y', strtotime($tahun . '-' . $bulan . '-' . $i)) . '</th>';
                        }
                        if (!empty($in)) {
                          echo '<th>' . date('H:i', strtotime($in['time'])) . '</th>';
                          echo '<th>' . $in['work_state'] . '</th>';
                          echo '<th><a href="https://www.google.com/maps/search/?api=1&query=' . $in['latitude'] . ',' . $in['longitude'] . '" class="text-secondary" target="_blank"><u>' . $in['location'] . '</u></a></th>';
                        } else {
                          echo '<th class="bg-danger"></th>';
                          echo '<th class="bg-danger"></th>';
                          echo '<th class="bg-danger"></th>';
                        }
                        if (!empty($out)) {
                          echo '<th>' . date('H:i', strtotime($out['time'])) . '</th>';
                          echo '<th>' . $out['work_state'] . '</th>';
                          echo '<th><a href="https://www.google.com/maps/search/?api=1&query=' . $out['latitude'] . ',' . $out['longitude'] . '" class="text-secondary" target="_blank"><u>' . $out['location'] . '</u></a></th>';
                        } else {
                          echo '<th class="bg-danger"></th>';
                          echo '<th class="bg-danger"></th>';
                          echo '<th class="bg-danger"></th>';
                        }
                        echo '</tr>';
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card-footer">
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

<script>
  $(document).ready(function() {
    var groupColumn = 0;
    var table = $('#dt-presensi').DataTable({
      // "columnDefs": [{
      //   "visible": false,
      //   "targets": groupColumn
      // }],
      // "orderFixed": [
      //   [groupColumn, 'asc']
      // ],
      // "scrollY": "867px",
      // "scrollX": true,
      // "scrollCollapse": true,
      // "paging": false,
      // "displayLength": 25,

      "pagingType": "full_numbers",
      scrollX: true,
      dom: 'Bfrtip',
      buttons: [
        'csv', 'print'
      ],
      "lengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, "All"]
      ],
      "displayLength": <?= $tanggal; ?>,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search records",
      },
      "drawCallback": function(settings) {
        var api = this.api();
        var rows = api.rows({
          page: 'current'
        }).nodes();
        var last = null;

        api.column(groupColumn, {
          page: 'current'
        }).data().each(function(group, i) {
          if (last !== group) {
            $(rows).eq(i).before(
              '<tr class="group"><td colspan="9">' + group + '</td></tr>'
            );

            last = group;
          }
        });
      }

      // $('#').DataTable({
      //     order: [[0, 'asc']],
      //     rowGroup: {
      //         dataSrc: 0
      //     },
      //   "scrollY": "512px",
      //   "scrollX": true,
      //   "scrollCollapse": true,
      //   "ordering": true,
      //   "paging": false
    });
  });
</script>