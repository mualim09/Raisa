<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
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
                        <h4 class="card-title">Konfirmasi Lembur </h4>
                            <div class="badge badge-rose mb-2" hidden><input type="checkbox" id="check-all" name="check-all"> Check All</div>
                        </div>
                        <form class="form">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="row col-md-6">
                                    <div class="row col-md-12">
                                        <?php 
                                            $queryLembur = "SELECT COUNT(*)
                                            FROM `lembur`
                                            WHERE `lokasi` = 'WTQ' AND `tglmulai` = NOW()";
                                            $totalLembur = $this->db->query($queryLembur)->row_array();
                                            $totalAktivitas = $totalLembur['COUNT(*)']; 
                                        ?>
                                        <label class="col-ml-5 col-form-label">Total Lembur Dikantor</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $totalAktivitas; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                
                                <div class="row col-md-6">
                                        <div class="row col-md-12">
                                            <label class="col-ml-5 col-form-label">Total Lembur DiLuar Kantor</label>
                                            <div class="col-md-7">
                                                <div class="form-group has-default">
                                                    <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            </div>
                    </form>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Nama</th>
                                        <th>Tanggal/Jam Mulai</th>
                                        <th>Tanggal/Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th>Lokasi lembur</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Nama</th>
                                        <th>Tanggal/Jam Mulai</th>
                                        <th>Tanggal/Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th>Lokasi Lembur</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($lembur as $l) : ?>
                                        <?php if ($l['tglmulai'] > date('Y-m-d 24:00:00')){ ?>
                                            <tr class="text-dark bg-success">
                                        <?php } else { ?>
                                            <tr>
                                        <?php }; ?>
                                            <td><?= $l['id']; ?></td>
                                            <td><?= $l['nama']; ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglmulai'])); ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglselesai'])); ?></td>
                                            <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                                            <td><?= $l['lokasi']; ?></td>  
                                            <td>
                                                <a href="<?= base_url('lembur/setujui_ga/'). $l['id']; ?>" class="badge badge-pill badge-success">Setujui</i></a> 
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

