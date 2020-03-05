<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("dashboard_model");
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        $notifikasi = $this->db->get_where('layanan_notifikasi', ['id' => '1'])->row_array();
        //Auto batalkan perjalanan
        $queryPerjalanan = "SELECT *
        FROM `perjalanan`
        WHERE `tglberangkat` <= CURDATE() AND (`status` = 1 OR `status` = 8)
        ";
        $perjalanan = $this->db->query($queryPerjalanan)->result_array();
        foreach ($perjalanan as $p) :
            // cari selisih
            $mulai = strtotime($p['jamberangkat']);
            $selesai = time();
            $durasi = $selesai - $mulai;
            $jam   = floor($durasi / (60 * 60));
            $user = $this->db->get_where('karyawan', ['npk' => $p['npk']])->row_array();

            if ($jam >= 2) {
                $this->db->set('status', '0');
                $this->db->set('last_status', $p['status']);
                $this->db->set('catatan_ga', "Waktu keberangkatan perjalanan kamu telah selesai. - Dibatalkan oleh SYSTEM pada " . date('d-m-Y H:i'));
                $this->db->where('id', $p['id']);
                $this->db->update('perjalanan');

                $this->db->set('status', '9');
                $this->db->where('id', $p['reservasi_id']);
                $this->db->update('reservasi');

                //Notifikasi ke USER
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $user['phone'],
                    'message' => "*PERJALANAN DINAS DIBATALKAN*\r\n \r\n No. PERJALANAN : *" . $p['id'] . "*" .
                    "\r\nNama : *" . $p['nama'] . "*" .
                    "\r\nTujuan : *" . $p['tujuan'] . "*" .
                    "\r\nKeperluan : *" . $p['keperluan'] . "*" .
                    "\r\nPeserta : *" . $p['anggota'] . "*" .
                    "\r\nBerangkat : *" . date('d-M', strtotime($p['tglberangkat'])) . "* *" . date('H:i', strtotime($p['jamberangkat'])) . "* _estimasi_" .
                    "\r\nKembali : *" . date('d-M', strtotime($p['tglkembali'])) . "* *" . date('H:i', strtotime($p['jamkembali'])) . "* _estimasi_" .
                    "\r\nKendaraan : *" . $p['nopol'] . "* ( *" . $p['kepemilikan'] . "* )" .
                    "\r\nCatatan : *" . $p['catatan_ga'] .  "*" .
                    "\r\n \r\nWaktu keberangkatan perjalanan kamu melebihi 2 Jam / batas waktu keberangkatan". 
                    "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com".
                    "\r\n \r\n" . $notifikasi['pesan']
                );

                $ch = curl_init();
            
                curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                $result = curl_exec($ch);
            }
        endforeach;

        //Auto LEMBUR
        // $this->db->where('status', '4');
        $lembur = $this->db->get('lembur')->result_array();

        foreach ($lembur as $l) :
            // cari selisih
            $sekarang = strtotime(date('Y-m-d H:i:s'));
            $tempo = strtotime(date('Y-m-d H:i:s', strtotime('+3 days', strtotime($l['tglselesai_rencana']))));
            $kirim_notif = strtotime(date('Y-m-d H:i:s', strtotime('+64 hours', strtotime($l['tglselesai_rencana']))));
            $expired = strtotime($l['expired_at']);
            $user = $this->db->get_where('karyawan', ['npk' => $l['npk']])->row_array();
            $last_status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array();

            if ($l['status']==4){
                // Notifikasi REALISASI tinggal 8 JAM
                if ($kirim_notif < $sekarang and $l['life']==0) { 
                    $notifikasi = $this->db->get_where('notifikasi', ['id' =>  $l['id']])->row_array();
                    if (!isset($notifikasi['id'])){
                        $data = array(
                            'id' => $l['id'],
                            'notifikasi' => 1,
                            'tanggal' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('notifikasi', $data);
        
                        //Notifikasi ke USER
                        $postData = array(
                            'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                            'number' => $user['phone'],
                            'message' => "*WAKTU REALISASI KAMU KURANG DARI 8 JAM*" .
                            "\r\n \r\n*LEMBUR* kamu dengan detil berikut :". 
                            "\r\n \r\nNo LEMBUR : *" . $l['id'] ."*". 
                            "\r\nNama : *" . $l['nama'] ."*". 
                            "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai_rencana'])) ."*".
                            "\r\nDurasi : *" . $l['durasi_rencana'] ." Jam*" .
                            "\r\n \r\nWaktu *REALISASI LEMBUR* kurang dari *8 JAM*, Ayo segera selesaikan REALISASI kamu." .
                            "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com".
                            "\r\n \r\n" . $notifikasi['pesan']
                        );

                        $ch = curl_init();
                    
                        curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        
                        $headers = array();
                        $headers[] = 'Accept: application/json';
                        $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        
                        $result = curl_exec($ch);
                    }
                }

                // Batalkan LEMBUR REALISASI
                if ($tempo < $sekarang and $l['life']==0) {
                    $this->db->set('catatan', "Waktu REALISASI LEMBUR kamu telah HABIS - Dibatalkan oleh : RAISA Pada " . date('d-m-Y H:i'));
                    $this->db->set('status', '0');
                    $this->db->set('last_status', $l['status']);
                    $this->db->where('id', $l['id']);
                    $this->db->update('lembur');

                    //Notifikasi ke USER
                    $postData = array(
                        'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                        'number' => $user['phone'],
                        'message' => "*WAKTU REALISASI KAMU TELAH HABIS*". 
                        "\r\n \r\n*LEMBUR* kamu dengan detil berikut :". 
                        "\r\n \r\nNo LEMBUR : *" . $l['id'] ."*". 
                        "\r\nNama : *" . $l['nama'] ."*". 
                        "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai'])) ."*". 
                        "\r\nDurasi : *" . $l['durasi'] ." Jam*" .
                        "\r\n \r\nLEMBUR kamu Telah *DIBATALKAN* otomatis oleh SISTEM" .
                        "\r\nWaktu *REALISASI LEMBUR* kamu melebihi 3x24 Jam dari batas waktu *RENCANA SELESAI LEMBUR*." . 
                        "\r\n1. Untuk hangus karena karyawan telat membuat realisasi dalam 3x24 jam, maka karyawan harus buat memo menjelaskan kenapa telat membuat realisasi yang ditandatangani atasan 1, atasan 2, kadivnya, dan bu dwi".
                        "\r\n2. untuk hangus karena atasan 1 atau atasan 2 telat approve dalam 7x24 jam, maka atasan yang jadi penyebab hangus harus buat memo menjelaskan kenapa telat approve yang ditandatangani kadep, kadivnya, dan bu dwi".
                        "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com".
                        "\r\n \r\n" . $notifikasi['pesan']
                    );

                    $ch = curl_init();
                
                    curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    
                    $headers = array();
                    $headers[] = 'Accept: application/json';
                    $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    
                    $result = curl_exec($ch);
                }
            }elseif ($l['status']>1 and $l['status']<7){
                 // Batalkan LEMBUR LEWAT 7 HARI
                if ($expired < $sekarang) {
                    $this->db->set('catatan', "Waktu LEMBUR kamu telah HABIS - Dibatalkan oleh : RAISA Pada " . date('d-m-Y H:i', strtotime($l['expired_at'])));
                    $this->db->set('status', '0');
                    $this->db->set('last_status', $l['status']);
                    $this->db->where('id', $l['id']);
                    $this->db->update('lembur');

                    //Notifikasi ke USER
                    $postData = array(
                        'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                        'number' => $user['phone'],
                        'message' => "*WAKTU LEMBUR KAMU TELAH HABIS LEMBUR KAMU DIBATALKAN*".
                        "\r\n \r\n*LEMBUR* kamu dengan detil berikut :". 
                        "\r\n \r\nNo LEMBUR : *" . $l['id'] ."*". 
                        "\r\nNama : *" . $l['nama'] ."*". 
                        "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai'])) ."*".  
                        "\r\nDurasi : *" . $l['durasi'] ." Jam*".
                        "\r\nStatus Terakhir : *" . $last_status['nama'] ."*".
                        "\r\n \r\nTelah *DIBATALKAN* otomatis oleh SISTEM".
                        "\r\nWaktu *LEMBUR* kamu melebihi 7x24 Jam dari batas waktu *RENCANA MULAI LEMBUR*.". 
                        "\r\n1. Untuk hangus karena karyawan telat membuat realisasi dalam 3x24 jam, maka karyawan harus buat memo menjelaskan kenapa telat membuat realisasi yang ditandatangani atasan 1, atasan 2, kadivnya, dan bu dwi".
                        "\r\n2. untuk hangus karena atasan 1 atau atasan 2 telat approve dalam 7x24 jam, maka atasan yang jadi penyebab hangus harus buat memo menjelaskan kenapa telat approve yang ditandatangani kadep, kadivnya, dan bu dwi".
                        "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com".
                        "\r\n \r\n" . $notifikasi['pesan']
                    );

                    $ch = curl_init();
                
                    curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    
                    $headers = array();
                    $headers[] = 'Accept: application/json';
                    $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    
                    $result = curl_exec($ch);
                }
            }
        endforeach;

        $this->db->where('year(tglmulai)',date('Y'));
        $this->db->where('month(tglmulai)',date('m'));
        $this->db->where('day(tglmulai)',date('d'));
        $this->db->where('konsumsi','YA');
        $this->db->where('status >', '2');
        $data['lembur_makan_malam'] = $this->db->get('lembur')->result_array();

        $this->db->where('year(tglmulai)',date('Y'));
        $this->db->where('month(tglmulai)',date('m'));
        $this->db->where('day(tglmulai)',date('d'));
        $this->db->where('status >', '2');
        $data['listlembur'] = $this->db->get('lembur')->result_array();
        $data['listclaim'] = $this->dashboard_model->get_claim();
        $data['listkaryawan'] = $this->dashboard_model->get_karyawan();

        // Halaman dashboard
        $data['sidemenu'] = 'Dashboard';
        $data['sidesubmenu'] = '';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['pendapatan'] = $this->db->get('pendapatan')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }

    public function informasi($id)
    {
        $data['sidemenu'] = 'Dashboard';
        $data['sidesubmenu'] = '';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['info'] = $this->db->get_where('informasi', ['id' =>  $id])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('dashboard/informasi', $data);
        $this->load->view('templates/footer');
    }

    public function medical($action)
    {
        if ($action=='add'){
            foreach ($this->input->post('karyawan') as $k) :
                $karyawan = $this->db->get_where('karyawan', ['npk' => $k])->row_array();
                $data = [
                    'npk' => $k,
                    'nama' => $karyawan['nama'],
                    'transfer_at' => date('Y-m-d', strtotime($this->input->post('tgltransfer')))
                ];
                $this->db->insert('medical_claim', $data);
            endforeach;
            redirect('dashboard');
        }elseif ($action=='delete'){
            $this->dashboard_model->delete_claim($this->input->post('id'));
            redirect('dashboard');
        }elseif ($action=='empty'){
            $this->dashboard_model->empty_claim();
            redirect('dashboard');
        }
    }
}
