<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Laporan Perjalanan Dinas</h4>
                            <p class="card-category">Berdasarkan periode <?= date("d-m-Y", strtotime($tglawal)).' s/d '.date("d-m-Y", strtotime($tglakhir)); ?></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <form action="<?= base_url('perjalanandl/laporan_fa'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Dari Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglawal" name="tglawal" required="true" />
                                        </div>
                                    </div>
                                    <label class="col-md-2 col-form-label">Sampai Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglakhir" name="tglakhir" required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-success">Cari</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="material-datatables">
                            <table id="dt-report" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor_Perjalanan</th>
                                        <th>Jenis DL</th>
                                        <th>Waktu Keberangkatan</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>e-Wallet</th>
                                        <th>Approval</th>
                                        <th>Verifikasi GA</th>
                                        <th>Verifikasi FA</th>
                                        <th>Total Biaya</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $p) : 
                                        $reservasi = $this->db->get_where('reservasi', ['id' => $p['reservasi_id']])->row_array();
                                        $p_peserta = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' => $p['id']])->result_array();
                                        foreach ($p_peserta as $pp) : 
                                            $peserta = $this->db->get_where('karyawan', ['npk' => $pp['npk']])->row_array();
                                            ?>
                                        <tr>
                                            <td><?= $p['id']; ?></td>
                                            <td><?= $p['jenis_perjalanan']; ?></td>
                                            <td><?= date("d-m-Y", strtotime($p['tglberangkat'])).' '.date("H:i", strtotime($p['jamberangkat']));; ?></td>
                                            <td><?= $p['tujuan']; ?></td>
                                            <td><?= $pp['karyawan_nama']; ?></td>
                                            <td><?= $peserta['ewallet_1']; ?></td>
                                            <td><?= substr($reservasi['atasan1'], -3).' - '.date("d-m-Y H:i", strtotime($reservasi['tgl_atasan1'])); ?></td>
                                            <td><?= $p['penyelesaian_by'].' - '.date("d-m-Y H:i", strtotime($p['penyelesaian_at'])); ?></td>
                                            <?php if ($pp['payment_by']){
                                                echo '<td>'.$pp['payment_by'].' - '.date("d-m-Y H:i", strtotime($pp['payment_at'])).'</td>';
                                            } else {
                                                echo '<td>-</td>';
                                            }?>
                                            <td><?= $pp['bayar']; ?></td>
                                            <td><?= $pp['status_pembayaran']; ?></td>
                                        </tr>
                                    <?php endforeach; 
                                endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="9" style="text-align:right">Total:</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#dt-report').DataTable({
            "pagingType": "full_numbers",
            scrollX: true,
            scrollY: '512px',
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            order: [
                [0, 'asc']
            ],
            scrollCollapse: true,
            paging: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total over all pages
                total = api
                    .column( 9 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                // Update footer
                $( api.column( 9 ).footer() ).html(
                    'RP '+ total 
                );
            }
        });
    } );
</script>