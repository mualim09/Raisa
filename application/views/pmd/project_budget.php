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
                        <h4 class="card-title">Daftar Project</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="#" id="tambah_copro" class="btn btn-info" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahCopro">Tambah Project Budget</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Copro</th> 
                                        <th rowspan="2">Part</th>
                                        <th rowspan="2">Budget</th>
                                        <th colspan="6" style="text-align: center;">Estimasi Cost</th>
                                        <th colspan="6"style="text-align: center;">Actual Cost</th>
                                        <th rowspan="2" style="text-align: center;">Action</th>
                                    </tr> 
                                    <tr>
                                        <td>PP</td>
                                        <td>Exprod</td> 
                                        <td>Total</td>
                                        <td>%</td>
                                        <td>Selisih</td>
                                        <td>%</td>
                                        <td>PP</td>
                                        <td>Exprod</td>
                                        <td>Total</td>
                                        <td>%</td>
                                        <td>Selisih</td>
                                        <td>%</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($project as $p) : ?>
                                    <tr>
                                        <td><?= $p['copro']; ?></td>
                                        <td><?= $p['part']; ?></td>
                                        <td><?= $p['budget']; ?></td>
                                        <td><?= $p['est_cost']; ?></td>
                                        <td><?= $p['est_exprod']; ?></td>
                                        <td><?= $p['est_total']; ?></td>
                                        <td><?= $p['est_persen']; ?>%</td>
                                        <td><?= $p['est_selisih']; ?></td>
                                        <td><?= $p['est_selisihpersen']; ?>%</td>
                                        <td><?= $p['act_cost']; ?></td>
                                        <td><?= $p['act_exprod']; ?></td>
                                        <td><?= $p['act_total']; ?></td>
                                        <td><?= $p['act_persen']; ?>%</td>
                                        <td><?= $p['act_selisih']; ?></td>
                                        <td><?= $p['act_selisihpersen']; ?>%</td>
                                        <td>
                                            <a href="javascript:;" 
                                                    data-id="<?php echo $p['id'] ?>"
                                                    data-budget="<?php echo $p['budget'] ?>"
                                                    data-cost="<?php echo $p['est_cost'] ?>"
                                                    data-exprod="<?php echo $p['est_exprod'] ?>"
                                                    data-total="<?php echo $p['est_total'] ?>"
                                                    data-persen="<?php echo $p['est_persen'] ?>"
                                                    data-selisih="<?php echo $p['est_selisih'] ?>"
                                                    data-selisihpersen="<?php echo $p['est_selisihpersen'] ?>"
                                            class="btn btn-sm btn-info" data-toggle="modal" data-target="#projectModal" >Estimasi Cost</a>
                                            <a href="javascript:;" 
                                                    data-id="<?php echo $p['id'] ?>"
                                                    data-cost="<?php echo $p['est_cost'] ?>"
                                                    data-exprod="<?php echo $p['est_exprod'] ?>"
                                                    data-total="<?php echo $p['est_total'] ?>"
                                                    data-persen="<?php echo $p['est_persen'] ?>"
                                                    data-selisih="<?php echo $p['est_selisih'] ?>"
                                                    data-selisihpersen="<?php echo $p['est_selisihpersen'] ?>"
                                            class="btn btn-sm btn-success" data-toggle="modal" data-target="#projectModal" >Actual Cost</a>
                                            
                                            <a href="<?= base_url('pmd/hapus_project/') . $p['copro']; ?>" class="btn btn-sm btn-danger btn-sm btn-bataldl">HAPUS</a>
                                        </td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th rowspan="2">Copro <br></th> 
                                        <th rowspan="2">Part</th>
                                        <th rowspan="2">Budget</th>
                                        <th colspan="6" style="text-align: center;">Estimasi Cost</th>
                                        <th colspan="6"style="text-align: center;">Actual Cost</th>
                                        <th rowspan="2" style="text-align: center;">Action <br>
                                        </th>
                                    </tr> 
                                    <tr>
                                        <td>PP</td>
                                        <td>Exprod</td> 
                                        <td>Total</td>
                                        <td>%</td>
                                        <td>Selisih</td>
                                        <td>%</td>
                                        <td>PP</td>
                                        <td>Exprod</td>
                                        <td>Total</td>
                                        <td>%</td>
                                        <td>Selisih</td>
                                        <td>%</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- end card-body-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end content -->
<!-- Modal Tambah Karyawan -->
<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-success text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Project Budget Estimasi</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('pmd/ubahProjectbudget'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Budget</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control disabled" id="budget" name="budget" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">PP</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control " id="cost" name="cost" required>
                                        <input type="hidden" class="form-control disabled" id="id" name="id" required>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Exprod</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" id="exprod" name="exprod">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Total</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control " id="total" name="total" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">%</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" id="persen" name="persen">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Selisih</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control " id="selisih" name="selisih" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">%</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" id="selisihpersen" name="selisihpersen">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success btn-round">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahCopro" tabindex="-1" role="dialog" aria-labelledby="tambahCoproTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-success text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Project Budget</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('pmd/tmbhbudget'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <!-- <div class="row">
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="copro" required>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-4">
                                    <div class="form-group has-default">
                                       <select class="selectpicker" id="copro" name="copro" data-style="select-with-transition" data-size="7"required>
                                            <?php
                                            $status = $this->db->get_where('project',['status' =>  'OPEN'])->result_array();
                                            foreach ($status as $s) :
                                                echo '<option value="' . $s['copro'] . '"';
                                                // if ($s['copro'] == $p['deskripsi']) {
                                                //     echo 'selected';
                                                // }
                                                echo '>' . $s['deskripsi'] . '</option>' . "\n";
                                            endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Part</label>
                                <div class="col-md-4">
                                    <div class="form-group has-default">
                                       <select class="selectpicker" id="part" name="part" data-style="select-with-transition" data-size="7"required>
                                            <?php
                                            $status = $this->db->get('part_project')->result_array();
                                            foreach ($status as $s) :
                                                echo '<option value="' . $s['nama'] . '"';
                                                // if ($s['copro'] == $p['deskripsi']) {
                                                //     echo 'selected';
                                                // }
                                                echo '>' . $s['nama'] . '</option>' . "\n";
                                            endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Budget</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" rows="3" class="form-control" id="budget" name="budget" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success btn-round">SIMPAN</button>
                                <br>
                                <button type="button" class="btn btn-default btn-round" data-dismiss="modal">TUTUP</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
 $(document).ready(function() {
    $('#projectModal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal          = $(this)

            modal.find('#id').attr("value",div.data('id'));
            modal.find('#budget').attr("value",div.data('budget'));
            modal.find('#cost').attr("value",div.data('cost'));
            modal.find('#exprod').attr("value",div.data('exprod'));
            modal.find('#total').attr("value",div.data('total'));
            modal.find('#persen').attr("value",div.data('persen'));
            modal.find('#selisih').attr("value",div.data('selisih'));
            modal.find('#selisihpersen').attr("value",div.data('selisihpersen'));
        });
 $(document).ready(function(){
    $("#cost").on("change", function(){
    total = parseInt($("#cost").val()) + parseInt($("#exprod").val()); 
    $("#total").val(total);
    selisih = parseInt($("#budget").val()) - parseInt($("#total").val());
    $("#selisih").val(selisih);
    persen = parseInt($("#total").val()) / (parseInt($("#budget").val())/100);
    $("#persen").val(persen); 
    selisihpersen = parseInt($("#selisih").val()) / (parseInt($("#budget").val())/100);
    $("#selisihpersen").val(selisihpersen);
        });
    });
});
</script>