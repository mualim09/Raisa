<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
    <!-- Start - Card summary kendaraan -->
    <div class="row">
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Laporan Lembur berdasarkan COPRO periode <?= $bulan.'-'.$tahun; ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="dtreportlb3" class="table table-striped table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        
                                        <th>Copro</th>
                                        <th>Nama Projek</th>
                                        <th>Man Hour <small>(JAM)</small></th>
                                        <th>MH JAMKERJA <small>(JAM)</small></th>
                                        <th>MH LEMBUR <small>(JAM)</small></th>
                                        <th>Aktivitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $this->db->distinct();
                                $this->db->select('copro');
                                $this->db->where('year(tgl_aktivitas)',$tahun);
                                $this->db->where('month(tgl_aktivitas)',$bulan);
                                $this->db->where('month(tgl_aktivitas)',$bulan);
                                $this->db->where('status >', '1');
                                $aktivitas_copro = $this->db->get('aktivitas')->result_array();
                                foreach ($aktivitas_copro as $k) : 
                                
                                    $this->db->where('copro', $k['copro']);
                                    $this->db->where('year(tgl_aktivitas)',$tahun);
                                    $this->db->where('month(tgl_aktivitas)',$bulan);
                                    $this->db->where('status >', '1');
                                    $total_copro = $this->db->get('aktivitas');

                                    $this->db->select_sum('durasi');
                                    $this->db->where('copro', $k['copro']);
                                    $this->db->where('year(tgl_aktivitas)',$tahun);
                                    $this->db->where('month(tgl_aktivitas)',$bulan);
                                    $this->db->where('jenis_aktivitas', 'LEMBUR'); 
                                    $this->db->where('status >', '1'); 
                                    $durasi_lembur = $this->db->get('aktivitas');
                                    $total_durasi_lembur = $durasi_lembur->row()->durasi;

                                    $this->db->select_sum('durasi');
                                    $this->db->where('copro', $k['copro']);
                                    $this->db->where('year(tgl_aktivitas)',$tahun);
                                    $this->db->where('month(tgl_aktivitas)',$bulan);
                                    $this->db->where('jenis_aktivitas', 'JAM KERJA'); 
                                    $this->db->where('status >', '1'); 
                                    $durasi_jamkerja = $this->db->get('aktivitas');
                                    $total_durasi_jamkerja = $durasi_jamkerja->row()->durasi;

                                    $total_durasi = $total_durasi_jamkerja + $total_durasi_lembur;

                                    if ($k['copro']){ 
                                        $projek = $this->db->get_where('project', ['copro' => $k['copro']])->row_array();?>
                                    <tr>
                                     <td class="td-name"><?= $k['copro']; ?></td>
                                        <td><?= $projek['deskripsi']; ?></td>
                                        <td class="td-name"><?= $total_durasi; ?></td>
                                        <td><?= $total_durasi_jamkerja; ?></td>
                                        <td><?= $total_durasi_lembur; ?></td>
                                        <td><?= $total_copro->num_rows(); ?></td>
                                    </tr>
                                <?php 
                                };
                                endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
       <!-- End - Card summary Peserta -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<script type="text/javascript">
    $(document).ready(function () {
    $('#dtreportlb3').DataTable({
        "pagingType": "full_numbers",
        order: [
            [2, 'desc']
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

});
</script>