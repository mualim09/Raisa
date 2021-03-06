<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-text">
              <h4 class="card-title">Presensi</h4>
              <p class="card-category">Periode <?= $fr . ' - ' . $to; ?></p>
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <form class="form" action="<?= base_url('depthead/presensi'); ?>" method="post">
                <div class="row">
                  <label class="col-md-1 col-form-label">From</label>
                  <div class="col-md-2">
                    <div class="form-group has-default">
                      <input type="text" class="form-control datepicker" id="datefr" name="datefr" value="<?= date('d-m-Y', strtotime($fr)); ?>" required="true" />
                    </div>
                  </div>
                  <label class="col-md-1 col-form-label">To</label>
                  <div class="col-md-2">
                    <div class="form-group has-default">
                      <input type="text" class="form-control datepicker" id="dateto" name="dateto" value="<?= date('d-m-Y', strtotime($to)); ?>" required="true" />
                    </div>
                  </div>
                  <div class="col-md-1">
                    <button type="submit" class="btn btn-twitter"><i class="material-icons">search</i> Search</button>
                  </div>
                  <div class="col-md-5"></div>
                </div>
              </form>

              <!-- Script Filter per Bulan -->
              <!-- <form class="form" method="post" action="<?= base_url('depthead/presensi'); ?>">
                <div class="form-group">
                  <label for="copro">Project*</label>
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
              </form> -->
            </div>
            <div class="material-datatables">
              <div class="table-responsive">
                <table id="dt-presensi" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Name</th>
                      <th>Time</th>
                      <th>State</th>
                      <th>Work State</th>
                      <th>Location</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($presensi as $p) :
                      if (date('D', strtotime($p['time'])) == 'Sat' or date('D', strtotime($p['time'])) == 'Sun') {
                        echo '<tr class="table-danger">';
                      } else {
                        echo '<tr>';
                      }
                      echo '<th>' . date('d M Y', strtotime($p['time'])) . '</th>';
                      echo '<th>' . $p['nama'] . '</th>';
                      echo '<th>' . date('H:i', strtotime($p['time'])) . '</th>';

                      if ($p['state'] == 'C/In') {
                        echo '<th><a href="#" class="badge badge-success">' . $p['state'] . '</a></th>';
                      } elseif ($p['state'] == 'C/Rest') {
                        echo '<th><a href="#" class="badge badge-warning">' . $p['state'] . '</a></th>';
                      } elseif ($p['state'] == 'C/Out') {
                        echo '<th><a href="#" class="badge badge-danger">' . $p['state'] . '</a></th>';
                      } else {
                        echo '<th></th>';
                      }

                      echo '<th>' . $p['work_state'] . '</th>';
                      if ($p['location']) {
                        echo '<th><a href="https://www.google.com/maps/search/?api=1&query=' . $p['latitude'] . ',' . $p['longitude'] . '" class="text-secondary" target="_blank"><u>' . $p['location'] . '</u></a></th>';
                      } else {
                        echo '<th></th>';
                      }
                      echo '<th>' . $p['note'] . '</th>';
                    endforeach;
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
      "columnDefs": [{
        "visible": false,
        "targets": groupColumn
      }],
      "orderFixed": [
        [groupColumn, 'asc']
      ],
      "scrollY": "867px",
      "scrollX": true,
      "scrollCollapse": true,
      "paging": false,
      // "displayLength": 25,
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