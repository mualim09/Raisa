<?php
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetMargins(14, 10, 10, 14);

$pdf->AddFont('arial-monospaced','','arial-monospaced.php');
$pdf->AddPage();
$pdf->line(10, 8, 208 - 8, 8);
$pdf->line(200, 288, 210 - 10, 8);
$pdf->line(10, 288, 20 - 10, 8);
$pdf->line(10, 288, 210 - 10, 288);

$pdf->Image('assets/img/WINTEQ8.jpg', 20, 15, 40, 0);

$pdf->Ln(20);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(40, 5, '', 0, 0);
$pdf->Cell(9, 4.5, '' , 1, 0);
$pdf->Cell(15, 5, 'CO' , 0, 0);
$pdf->Cell(9, 4.5, '' , 1, 0);
$pdf->Cell(15, 5, 'AN' , 0, 0);
$pdf->Cell(9, 4.5, '' , 1, 0);
$pdf->Cell(15, 5, 'NM' , 0, 0);
$pdf->Cell(9, 4.5, '' , 1, 0);
$pdf->Cell(15, 5, 'AWP ' , 0, 0);
$pdf->Cell(9, 4.5, 'X' , 1, 0,'C');
$pdf->Cell(10, 5, 'WI ' , 0, 0);
$pdf->Cell(9, 5, '' , 0, 1);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(170, 0, 'SURAT TUGAS', 0, 1, 'C');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(170, 5, 'NO PERJALANAN : ' . $perjalanan['id'], 0, 1, 'C');

$pdf->Ln(1);
$pdf->setTextColor(0, 0, 0);
$pdf->setFillColor(255, 255, 255);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(8, 6, 'NO', 1, 0, 'C', 1);
$pdf->Cell(45, 6, 'Nama', 1, 0, 'C', 1);
$pdf->Cell(14, 6, 'NRP', 1, 0, 'C', 1);
$pdf->Cell(40, 6, 'Divisi / Departemen', 1, 0, 'C', 1);
$pdf->Cell(30, 6, 'Jabatan', 1, 0, 'C', 1);
$pdf->Cell(45, 6, 'Travel Dokumen', 1, 0, 'C', 1);
$pdf->Cell(0, 6, '', 0, 1, 0);

$pdf->Cell(8, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(45, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(14, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(40, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(30, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(45, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(0, 0.5, '', 0, 1, 0);

$peserta = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' => $perjalanan['id']])->result_array();
$no = 1;
foreach ($peserta as $p) :

    $pdf->Cell(8, 5, $no, 1, 0, 'C', 1);
    $pdf->Cell(45, 5, $p['karyawan_nama'], 1, 0, 'C', 1);
    $pdf->Cell(14, 5, $p['npk'], 1, 0, 'C', 1);
    $user = $this->db->get_where('karyawan', ['npk' => $p['npk']])->row_array();
    $dept = $this->db->get_where('karyawan_dept', ['id' => $user['dept_id']])->row_array();
    $posisi = $this->db->get_where('karyawan_posisi', ['id' => $user['posisi_id']])->row_array();
    $pdf->Cell(40, 5, $dept['nama'], 1, 0, 'C', 1);
    $pdf->Cell(30, 5, $posisi['nama'], 1, 0, 'C', 1);
    $pdf->Cell(45, 5, '', 1, 0, 'C', 1);
    $pdf->Cell(0, 5, '', 0, 1, 0);

    $no = $no + 1;

endforeach;

$pdf->Ln(2);
$pdf->SetFont('Arial', '', 6);
// $pdf->Cell(170, 5, 'Permintaan Pengurus Travel Document', 0, 1);

$pdf->Ln(4);
$pdf->Cell(37, 5, 'Tujuan                                            : ', 0, 0);
$pdf->Cell(170, 5, $perjalanan['tujuan'], 0, 1);
$pdf->Cell(37, 5, 'Keperluan                                      : ', 0, 0);
$pdf->Cell(170, 5, $perjalanan['keperluan'], 0, 1);
$pdf->Cell(37, 5, 'Berangkat                                      : ', 0, 0);
$pdf->Cell(170, 5, ''. date('d M Y', strtotime($perjalanan['tglberangkat'])).' - '.date('H:i', strtotime($perjalanan['jamberangkat'])), 0, 1);
$pdf->Cell(37, 5, 'Kembali                                        : ', 0, 0);
$pdf->Cell(170, 5, ''. date('d M Y', strtotime($perjalanan['tglkembali'])).' - '.date('H:i', strtotime($perjalanan['jamkembali'])), 0, 1);

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(170, 5, 'Jadwal Perjalanan  :', 0, 1);
$pdf->Cell(20, 6, 'Tgl', 1, 0, 'C', 1);
$pdf->Cell(15, 6, 'Waktu', 1, 0, 'C', 1);
$pdf->Cell(36, 6, 'Berangkat Dari', 1, 0, 'C', 1);
$pdf->Cell(36, 6, 'Tempat Tujuan', 1, 0, 'C', 1);
$pdf->Cell(20, 6, 'Transportasi', 1, 0, 'C', 1);
$pdf->Cell(18, 6, 'Kelas', 1, 0, 'C', 1);
$pdf->Cell(36, 6, 'Keterangan', 1, 0, 'C', 1);
$pdf->Cell(0, 6, '', 0, 1, 0);

$pdf->Cell(20, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(15, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(36, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(36, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(20, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(18, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(36, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(0, 0.5, '', 0, 1, 0);

$jadwal = $this->db->get_where('perjalanan_jadwal', ['perjalanan_id' => $perjalanan['id']])->result_array();
$nomor = 1;
foreach ($jadwal as $j) :
    $pdf->Cell(20, 6, date("d M Y", strtotime($j['waktu'])), 1, 0, 'C', 1);
    $pdf->Cell(15, 6, date("H:i", strtotime($j['waktu'])), 1, 0, 'C', 1);
    $pdf->Cell(36, 6, $j['berangkat'], 1, 0, 'C', 1);
    $pdf->Cell(36, 6, $j['tujuan'], 1, 0, 'C', 1);
    $pdf->Cell(20, 6, $j['transportasi'], 1, 0, 'C', 1);
    $pdf->Cell(18, 6, '', 1, 0, 'C', 1);
    $pdf->Cell(36, 6, $j['keterangan'], 1, 0, 'C', 1);
    $pdf->Cell(0, 6, '', 0, 1, 0);

$nomor = $nomor + 1;

endforeach;

$pdf->Cell(20, 6, '', 1, 0, 'C', 1);
$pdf->Cell(15, 6, '', 1, 0, 'C', 1);
$pdf->Cell(36, 6, '', 1, 0, 'C', 1);
$pdf->Cell(36, 6, '', 1, 0, 'C', 1);
$pdf->Cell(20, 6, '', 1, 0, 'C', 1);
$pdf->Cell(18, 6, '', 1, 0, 'C', 1);
$pdf->Cell(36, 6, '', 1, 0, 'C', 1);
$pdf->Cell(0, 6, '', 0, 1, 0);

$pdf->Ln(6);
$pdf->Cell(37, 5, 'Akomodasi                                  :', 0, 0);
$pdf->Cell(63, 5, $perjalanan['akomodasi'] , 0, 0);
$pdf->Cell(9, 5, '' , 0, 1);

$pdf->Ln(2);
$pdf->Cell(38, 5, 'Penginapan                                 :', 0, 0);
if ($perjalanan['penginapan'])
{
    $pdf->Cell(5, 4.5, ' X' , 1, 0);
    $pdf->Cell(63, 5, $perjalanan['penginapan'].', ' .$perjalanan['lama_menginap'].' Malam / Kelas.................................', 0, 0);
    $pdf->Cell(9, 5, '' , 0, 1);
}else{
    $pdf->Cell(5, 4.5, '' , 1, 0);
    $pdf->Cell(63, 5, 'Hotel, Kelas.................................' , 0, 0);
    $pdf->Cell(9, 5, '' , 0, 1);
}

$pdf->Ln(2);
$pdf->Cell(38, 5, 'Alokasi Pembebanan                 :', 0, 0);
$pdf->Cell(9, 4.5, '' , 1, 0);
$pdf->Cell(15, 5, 'CO' , 0, 0);
$pdf->Cell(9, 4.5, '' , 1, 0);
$pdf->Cell(15, 5, 'AN' , 0, 0);
$pdf->Cell(9, 4.5, '' , 1, 0);
$pdf->Cell(15, 5, 'NM' , 0, 0);
$pdf->Cell(9, 4.5, '' , 1, 0);
$pdf->Cell(15, 5, 'AWP ' , 0, 0);
$pdf->Cell(9, 4.5, 'X' , 1, 0,'C');
$pdf->Cell(10, 5, 'WI ' , 0, 0);
$pdf->Cell(9, 5, '' , 0, 1);

$pdf->Ln(2);
$pdf->Cell(37, 5, 'Catatan                                        :', 0, 0);
$pdf->Cell(170, 5, $perjalanan['catatan'] , 0, 1);

$reservasi = $this->db->get_where('reservasi', ['id' => $perjalanan['reservasi_id']])->row_array();
$pdf->Ln(4);
$pdf->Cell(137, 4, 'Disetujui Oleh ,', 1, 0, 'C', 1);
$pdf->Cell(45, 4, 'Dibuat Oleh ,', 1, 1, 'C', 1);
$pdf->Cell(47, 30, '', 1, 0, 1);
$pdf->Cell(45, 30, '', 1, 0, 1);
$pdf->Cell(45, 30, '', 1, 0, 1);
$pdf->Cell(45, 30, '', 1, 0, 1);
$pdf->Cell(0, 30, '', 0, 1, 0);

$pdf->Ln(-22);
$pdf->SetFont('arial-monospaced', '', 5.5);
$pdf->Cell(129.5, 3, 'Ini adalah form digital', 0,'C', 0);
$pdf->Cell(6.5, 8, 'Tidak memerlukan tanda tangan basah', 0,'C', 0);
$pdf->Cell(-11, 13, 'Disetujui Pada', 0,'C', 0);
$pdf->Cell(1, 18, date("d M Y H:i", strtotime($reservasi['tgl_div'])), 0,'C', 0);

$pdf->Cell(48.5, 3, 'Ini adalah form digital', 0,'C', 0);
$pdf->Cell(6.5, 8, 'Tidak memerlukan tanda tangan basah', 0,'C', 0);
$pdf->Cell(-14, 13, 'Dibuat Pada', 0,'C', 0);
$pdf->Cell(3, 18, date("d M Y H:i", strtotime($reservasi['tglreservasi'])), 0,'C', 0);

$pdf->Ln(19);
$pdf->Cell(47, 4, 'President Director', 1,0,'C',1);
$pdf->Cell(45, 4, 'Chief Operator Officer',1,0,'C',1);
$pdf->Cell(45, 4, 'Supporting & Adm. Division', 1,0,'C',1);
$pdf->Cell(45, 4, 'Pemohon / Dept.Head', 1,0,'C',1);
$pdf->Cell(5, 4, '', 0, 1, 0);

$pdf->Ln(-8);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(45, 4, '(                             )', 0,0,'C',0);
$pdf->Cell(45, 4, '( Donny Novanda )',0,0,'C',0);
$pdf->Cell(50, 4, '( Eko Juwono )', 0,0,'C',0);
$pdf->Cell(42, 4, '( '.$reservasi['nama'].' )', 0,0,'C',0);
$pdf->Cell(5, 4, '', 0, 1, 0);


$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(35, 5, 'Pengembalian Prepaid               :', 0, 0);
$pdf->Cell(105, 5, '1.       Rp.           :', 0, 1);
$pdf->Cell(35, 4, '',0,0);
$pdf->Cell(105, 5, '2.       USD.        :', 0, 1);
$pdf->Cell(35, 4, '',0,0);
$pdf->Cell(105, 5, '3.       ........        :', 0, 1);
$pdf->Cell(35, 4, '',0,0);
$pdf->Cell(105, 5, '4.       ........        :', 0, 0);

$pdf->Ln(-12);
$pdf->Cell(137, 5, '', 0, 0);
$pdf->Cell(45, 4, '   Disetujui ,', 1,1,'C',1);
$pdf->Cell(137, 5, '', 0, 0);
$pdf->Cell(45, 25, '', 1,1,'C',1);
$pdf->Cell(137, 5, '', 0, 0);
$pdf->Cell(45, 4, '   Dept.Head', 1,1,'C',1);

$pdf->Ln(-22);
$pdf->SetFont('arial-monospaced', '', 5.5);
$pdf->Cell(175, 3, 'Ini adalah form digital', 0,'C', 0);
$pdf->Cell(6.5, 8, 'Tidak memerlukan tanda tangan basah', 0,'C', 0);
$pdf->Cell(-11, 13, 'Disetujui Pada', 0,'C', 0);
$pdf->Cell(1, 18, date("d M Y H:i", strtotime($reservasi['tgl_atasan2'])), 0,'C', 0);

$pdf->Ln(14);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(140, 5, '', 0, 0);
$pdf->Cell(42, 4, '( '.$perjalanan['ka_dept'].'  )', 0,0,'C',0);

// $pdf->Ln(-12);
// $pdf->Cell(137, 5, '', 0, 0);
// $pdf->Cell(45, 4, '   Diketahui / Dibuat Oleh ,', 1,1,'C',1);
// $pdf->Cell(137, 5, '', 0, 0);
// $pdf->Cell(45, 25, '', 1,1,'C',1);
// $pdf->Cell(137, 5, '', 0, 0);
// $pdf->Cell(45, 4, '   HRDGA / Adm.Dept.Head', 1,1,'C',1);

// $pdf->Ln(-22);
// $pdf->SetFont('arial-monospaced', '', 5.5);
// $pdf->Cell(175, 3, 'Ini adalah form digital', 0,'C', 0);
// $pdf->Cell(6.5, 8, 'Tidak memerlukan tanda tangan basah', 0,'C', 0);
// $pdf->Cell(-11, 13, 'Disetujui Pada', 0,'C', 0);
// $pdf->Cell(1, 18, date("d M Y H:i", strtotime($reservasi['tgl_fin'])), 0,'C', 0);

// $pdf->Ln(14);
// $pdf->SetFont('Arial', 'B', 6);
// $pdf->Cell(140, 5, '', 0, 0);
// $pdf->Cell(42, 4, '(  Eko Juwono  )', 0,0,'C',0);

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(140, 4, 'Terlampir  : Rencana Biaya Perjalanan Dinas', 0, 1);
$pdf->Cell(140, 4, 'Cc.  :  1.  Accounting / Finance & Accounting', 0, 1);
$pdf->Cell(140, 5, '           2. HRDGA / Administration', 0, 1);


$pdf->Output('I', 'SURAT TUGAS TA' . RAND() . '.pdf');
