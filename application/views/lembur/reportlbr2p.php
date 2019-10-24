<?php

      $pdf = new FPDF('L','mm','A5');
      $pdf->SetMargins(5,10);
      $pdf->AddFont('arial-monospaced','','arial-monospaced.php');

      $pdf->AddPage();

      $pdf->Image('assets/img/WINTEQ1.jpg',10,5,30,0);
      $pdf->Image('assets/img/WINTEQ8.jpg',170,5,30,0);
      
      $pdf->Ln(-3);
      
      $user = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(185,15,'RENCANA / LAPORAN LEMBUR',0,1,'C');
      $pdf->line(75,16, 135-15, 16);

      $pdf->Ln(-5);

      $pdf->setTextColor(0,0,0);
      $pdf->setFillColor(255,255,255);

      $dep = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
      $d = $this->db->get_where('karyawan_dept', ['id' =>  $dep['dept_id']])->row_array();

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(10, 5, 'NO : ' . $lembur['id'], 0, 1);
      
      $pdf->Cell(56,5,'HARI / TGL              :   '. date('d-m-Y', strtotime($lembur['tglmulai'])),1,0,1);
      $pdf->SetFont('Arial','',5);

      $pdf->Cell(69,10,'RENCANA LEMBUR',1,0,'C',1);
      $pdf->Cell(75,10,'LAPORAN LEMBUR',1,0,'C',1);
      $pdf->Cell(0,5,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(56,5,'DEPARTEMENT     :   ' . $d['inisial'],1,0,1);
      $pdf->SetFont('Arial','',5);
      $pdf->Cell(64,7,'',0,0,0);
      $pdf->Cell(75,7,'',0,0,0);
      $pdf->Cell(70,5,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(56,7,'NAMA                      :   ' . $lembur['nama'],1,0,1);
      $pdf->SetFont('Arial','',5);

      $pdf->Cell(28,7,'MULAI',1,0,'C',1);
      $pdf->Cell(28,7,'SELESAI',1,0,'C',1);
      $pdf->Cell(13,7,'JML.JAM',1,0,'C',1);
      $pdf->Cell(27,7,'MULAI',1,0,'C',1);
      $pdf->Cell(28,7,'SELESAI',1,0,'C',1);
      $pdf->Cell(20,7,'JML.JAM',1,0,'C',1);
      $pdf->Cell(70,7,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(56,5,'NPK                         :   ' . $user['npk'],1,0,1);
      $pdf->Cell(28,5, date('H:i', strtotime($lembur['tglmulai'])),1,0,'C',1);
      $pdf->Cell(28,5, date('H:i', strtotime($lembur['tglselesai'])),1,0,'C',1);
      $pdf->Cell(13,5, date('H:i', strtotime($lembur['durasi'])),1,0,'C',1);
      $pdf->Cell(27,5, date('H:i', strtotime($lembur['tglmulai_aktual'])),1,0,'C',1);
      $pdf->Cell(28,5, date('H:i', strtotime($lembur['tglselesai_aktual'])),1,0,'C',1);
      $pdf->Cell(20,5, date('H:i', strtotime($lembur['durasi_aktual'])),1,1,'C',0);
      $pdf->Cell(56,5,'',0,1,0);

      $pdf->SetFont('Arial','',5);
      $no = 1;

      $pdf->Cell(6,5,'NO',1,0,'C',1);
      $pdf->Cell(26,5,' KATEGORI',1,0,'C',1);
      $pdf->Cell(24,5,'COPRO',1,0,'C',1);
      $pdf->Cell(69,5,' AKTIVITAS LEMBUR',1,0,'C',1);
      $pdf->Cell(75,5,'REALISASI HASIL AKTIVITAS LEMBUR',1,1,'C',1);

      $pdf->SetFont('Arial','B',6);

      foreach ($aktivitas as $a) :
            $k = $this->db->get_where('jamkerja_kategori', ['id' =>  $a['kategori']])->row_array();


      $pdf->Cell(6,5,$no++,1,0,'C',1);
      $pdf->Cell(26,5, $k['nama'],1,0,1);
      $pdf->Cell(24,5, $a['copro'],1,0,'C',1);
      $pdf->Cell(69,5, $a['aktivitas'],1,0,'C',1);
      $pdf->Cell(75,5, $a['deskripsi_hasil'].', ' .$a['progres_hasil'] .'%',1,1,'C',1);

      endforeach;
      
      $nama1 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan1_rencana']])->row_array();
      $n1 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama1['posisi_id']])->row_array();
      $nama1['nama']; 

      $nama2 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2_rencana']])->row_array();
      $n2 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama2['posisi_id']])->row_array();
      $nama2['nama'];

      $nama3 = $this->db->get_where('karyawan', ['inisial' => $lembur['admin_ga']])->row_array();
      $n3 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama3['posisi_id']])->row_array();
      $nama3['nama']; 

      $nama4 = $this->db->get_where('karyawan', ['inisial' => $lembur['admin_hr']])->row_array();
      $n4 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama4['posisi_id']])->row_array();
      $nama4['nama']; 

      $pdf->Cell(56,5,'',0,0,'C',1);
      $pdf->Cell(144,5,'',1,1,'C',1);
      // $pdf->Cell(75,5,'',1,1,'C',1);
      $pdf->SetFont('Arial','',5);


      $pdf->Cell(56,5,'',0,0,'C',1);
      $pdf->Cell(47,5,'DISETUJUI',1,0,'C',1);
      $pdf->Cell(22,5,'DITERIMA',1,0,'C',1);
      
      $pdf->Cell(49,5,'DISETUJUI',1,0,'C',1);
      $pdf->Cell(26,5,'DITERIMA',1,1,'C',1);
      
      $pdf->Cell(56,5,'',0,0,'C',1);
      $pdf->Cell(23,5, $n1['nama'],1,0,'C',1);
      $pdf->Cell(24,5, $n2['nama'],1,0,'C',1);
      $pdf->Cell(22,5, 'GA',1,0,'C',1);
      $pdf->Cell(25,5, $n1['nama'],1,0,'C',1);
      $pdf->Cell(24,5, $n2['nama'],1,0,'C',1);
      $pdf->Cell(26,5, 'HR',1,1,'C',1);
      
      $pdf->SetFont('Arial','B',7);
      
      $pdf->Cell(56,5,'',0,0,'C',1);
      $pdf->Cell(23,25, $nama1['nama'],1,0,'C',1);
      $pdf->Cell(24,25, $nama2['nama'],1,0,'C',1);
      $pdf->Cell(22,25, $nama3['nama'],1,0,'C',1);
      $pdf->Cell(25,25, $nama1['nama'],1,0,'C',1);
      $pdf->Cell(24,25, $nama2['nama'],1,0,'C',1);
      $pdf->Cell(26,25, $nama4['nama'],1,0,'C',1);

      $pdf->Ln(15);
      $pdf->SetFont('Arial', 'B', 5);
      $pdf->Cell(56, 5, '', 0, 0);
      $pdf->Cell(23, 5, 'Disetujui',0, 0, 'C');
      $pdf->Cell(-23, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_rencana'])),0, 0, 'C');
      $pdf->Cell(70, 5, 'Disetujui',0, 0, 'C');
      $pdf->Cell(-70, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_rencana'])), 0, 0, 'C');
      $pdf->Cell(115, 5, 'Disetujui',0, 0, 'C');
      $pdf->Cell(-115, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])), 110, 0, 'C');
      $pdf->Cell(162, 5, 'Disetujui',0, 0, 'C');
      $pdf->Cell(-160, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
      $pdf->Cell(207, 5, 'Disetujui',0, 0, 'C');
      $pdf->Cell(-205, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_realisasi'])), 110, 0, 'C');
      $pdf->Cell(255, 5, 'Disetujui',0, 0, 'C');
      $pdf->Cell(-255, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 110, 0, 'C');
      $pdf->SetFont('Arial', '', 5);

      $pdf->Ln(7);

      $pdf->Ln(-22);
      $pdf->SetFont('arial-monospaced', '', 5);
      $pdf->Cell(74, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      $pdf->Cell(20, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      $pdf->Cell(19, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      $pdf->Cell(19, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      $pdf->Cell(20, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);


      $pdf->Output('I','SURAT RENCANA / LAPORAN LEMBUR'.RAND().'.pdf');