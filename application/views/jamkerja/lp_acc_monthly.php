<div class="content">
    <div class="container-fluid">
    <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assessment</i>
                        </div>
                        <h4 class="card-title">Laporan Man Hour</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('jamkerja/lp_acc_monthly'); ?>" method="post">
                        <div class="row">
                                <label class="col-md-2 col-form-label">Tahun</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="tahun" id="tahun" data-style="select-with-transition" title="Pilih Tahun" data-size="7" required>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Bulan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="bulan" id="bulan" data-style="select-with-transition" title="Pilih Bulan" data-size="7" required>
                                            <option value="01">Januari</option>
                                            <option value="02">Febuari</option>
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <button type="submit" class="btn btn-fill btn-success">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Laporan Jam Kerja</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dtperjalanan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>NPK</th>
                                            <th>Kategori</th>
                                            <th>COPRO</th>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi Hasil</th>
                                            <th>Durasi</th>
                                            <th>Progres Hasil</th>
                                            <th>Dept</th>
                                            <th>Cell / Section</th>
                                            <th>Posisi</th>
                                            <th>Jenis</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>NPK</th>
                                            <th>Kategori</th>
                                            <th>COPRO</th>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi Hasil</th>
                                            <th>Durasi</th>
                                            <th>Progres Hasil</th>
                                            <th>Dept</th>
                                            <th>Cell / Section</th>
                                            <th>Posisi</th>
                                            <th>Jenis</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($aktivitas as $a) :
                                            $kry = $this->db->get_where('karyawan', ['npk' => $a['npk']])->row_array(); ?>
                                            <tr>
                                                <td><?= date('m-d-Y', strtotime($a['tgl_aktivitas'])); ?></td>
                                                <td><?= $kry['nama']; ?></td>
                                                <td><?= $a['npk']; ?></td>
                                                <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                                <td><?= $k['nama']; ?> </td>
                                                <?php if ($a['copro']){
                                                    echo '<td>'.$a['copro'].'</td>';
                                                }else{
                                                    echo '<td>'. $a['aktivitas'].'</td>';
                                                } ?>
                                                <td><?= $a['aktivitas']; ?></td>
                                                <td><?= $a['deskripsi_hasil']; ?></td>
                                                <td><?= $a['durasi']; ?></td>
                                                <td><?= $a['progres_hasil']; ?>%</td>
                                                <?php $dept = $this->db->get_where('karyawan_dept', ['id' => $kry['dept_id']])->row_array(); ?>
                                                <td><?= $dept['inisial']; ?></td>
                                                <?php $sect = $this->db->get_where('karyawan_sect', ['id' => $kry['sect_id']])->row_array(); ?>
                                                <td><?= $sect['nama']; ?></td>
                                                <?php $posisi = $this->db->get_where('karyawan_posisi', ['id' => $kry['posisi_id']])->row_array(); ?>
                                                <td><?= $posisi['nama']; ?></td>
                                                <td><?= $a['jenis_aktivitas']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
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