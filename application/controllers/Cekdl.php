<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Cekdl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        $data['sidemenu'] = 'Security';
        $data['sidesubmenu'] = 'Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get('perjalanan')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/index', $data);
        $this->load->view('templates/footer');
    }

    public function berangkat()
    {
        $data['sidemenu'] = 'Security';
        $data['sidesubmenu'] = 'Keberangkatan / Keluar';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->where('status', '1');
        $data['perjalanan'] = $this->db->or_where('status', '11');
        $data['perjalanan'] = $this->db->get('perjalanan')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/berangkat', $data);
        $this->load->view('templates/footer');
    }

    public function cekberangkat($dl)
    {
        date_default_timezone_set('asia/jakarta');
        //auto batalkan perjalanan
        $queryPerjalanan = "SELECT *
        FROM `perjalanan`
        WHERE `tglberangkat` <= CURDATE() AND `status` = 1
        ";
        $perjalanan = $this->db->query($queryPerjalanan)->result_array();
        foreach ($perjalanan as $p) :
            // cari selisih
            $mulai = strtotime($p['jamberangkat']);
            $selesai = time();
            $durasi = $selesai - $mulai;
            $jam   = floor($durasi / (60 * 60));

            if ($jam >= 2) {
                $this->db->set('status', '0');
                $this->db->set('catatan_ga', "Waktu keberangkatan perjalanan kamu telah selesai. - Dibatalkan oleh RAISA pada " . date('d-m-Y H:i'));
                $this->db->where('id', $p['id']);
                $this->db->update('perjalanan');

                $this->db->set('status', '9');
                $this->db->where('id', $p['reservasi_id']);
                $this->db->update('reservasi');

                $this->db->where('npk', $p['npk']);
                $karyawan = $this->db->get('karyawan')->row_array();
                $my_apikey = "NQXJ3HED5LW2XV440HCG";
                $destination = $karyawan['phone'];
                $message = "*PERJALANAN DINAS DIBATALKAN*\r\n \r\n No. PERJALANAN : *" . $p['id'] . "*" .
                    "\r\n Nama : *" . $p['nama'] . "*" .
                    "\r\n Tujuan : *" . $p['tujuan'] . "*" .
                    "\r\n Keperluan : *" . $p['keperluan'] . "*" .
                    "\r\n Peserta : *" . $p['anggota'] . "*" .
                    "\r\n Berangkat : *" . $p['tglberangkat'] . "* *" . $p['jamberangkat'] . "* _estimasi_" .
                    "\r\n Kembali : *" . $p['tglkembali'] . "* *" . $p['jamkembali'] . "* _estimasi_" .
                    "\r\n Kendaraan : *" . $p['nopol'] . "* ( *" . $p['kepemilikan'] . "* )" .
                    "\r\n Catatan : *" . $p['catatan_ga'] .  "*" .
                    "\r\n \r\nWaktu keberangkatan perjalanan kamu melebihi 2 Jam / batas waktu keberangkatan. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
                $api_url = "http://panel.apiwha.com/send_message.php";
                $api_url .= "?apikey=" . urlencode($my_apikey);
                $api_url .= "&number=" . urlencode($destination);
                $api_url .= "&text=" . urlencode($message);
                json_decode(file_get_contents($api_url, false));
            }
        endforeach;

        $cekperjalanan = $this->db->get_where('perjalanan', ['id' => $dl])->row_array();
        if ($cekperjalanan['status'] == 0) {
            redirect('cekdl/berangkat');
        } else {
            $data['sidemenu'] = 'Security';
            $data['sidesubmenu'] = 'Keberangkatan / Keluar';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $dl])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('cekdl/cekberangkat', $data);
            $this->load->view('templates/footer');
        }
    }

    public function cekberangkat_proses()
    {
        date_default_timezone_set('asia/jakarta');

        $kmberangkat = $this->input->post('kmberangkat');
        $this->db->set('tglberangkat', date("Y-m-d"));
        $this->db->set('jamberangkat', date("H:i:s"));
        $this->db->set('cekberangkat', $this->session->userdata('inisial'));
        $this->db->set('kmberangkat', $kmberangkat);
        $this->db->set('supirberangkat', $this->input->post('supirberangkat'));
        $this->db->set('catatan_security', $this->input->post('catatan'));
        $this->db->set('status', '2');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        // $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        // if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um1']) {
        //     $this->db->set('um1', 'YA');
        //     $this->db->where('id', $this->input->post('id'));
        //     $this->db->update('perjalanan');
        // };
        // if ($this->input->post('jenis') == 'TAPP' and $this->input->post('jamberangkat') <= $um['um2']) {
        //     $this->db->set('um2', 'YA');
        //     $this->db->where('id', $this->input->post('id'));
        //     $this->db->update('perjalanan');
        // };

        $this->session->set_flashdata('message', 'berangkat');
        redirect('cekdl/berangkat');
    }

    public function kembali()
    {
        $data['sidemenu'] = 'Security';
        $data['sidesubmenu'] = 'Kembali / Masuk';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['status' => '2'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/kembali', $data);
        $this->load->view('templates/footer');
    }

    public function cekkembali($dl)
    {
        $data['sidemenu'] = 'Security';
        $data['sidesubmenu'] = 'Kembali / Masuk';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $dl])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/cekkembali', $data);
        $this->load->view('templates/footer');
    }

    public function cekkembali_proses()
    {
        date_default_timezone_set('asia/jakarta');

        // $kmkembali = substr($this->input->post('kmkembali'), -4);
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
        $kmkembali = $this->input->post('kmkembali');
        $kmtotal = $kmkembali - $this->input->post('kmberangkat');
        if ($perjalanan['jenis_perjalanan'] == 'DLPP' or $perjalanan['jenis_perjalanan'] == 'TAPP') {
            $stat = '3';
        } else {
            $stat = '9';
        }

        //Tidak untuk jensi perjalanan TA
        // $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        // if ($perjalanan['jenis_perjalanan'] != 'TA') {
            //Insentif pagi
            // if ($perjalanan['jamberangkat'] <= $um['um1']) {
            //     $this->db->select_sum('insentif_pagi');
            //     $this->db->where('perjalanan_id', $this->input->post('id'));
            //     $query = $this->db->get('perjalanan_anggota');
            //     $insentif_pagi = $query->row()->insentif_pagi;

            //     $this->db->set('um1', 'YA');
            //     $this->db->set('insentif_pagi', $insentif_pagi);
            //     $this->db->where('id', $this->input->post('id'));
            //     $this->db->update('perjalanan');
            // } else {
            //     $this->db->set('um1', 'TIDAK');
            //     $this->db->set('insentif_pagi', 0);
            //     $this->db->where('id', $this->input->post('id'));
            //     $this->db->update('perjalanan');
            // };
            //Makan Pagi
            // if ($perjalanan['jenis_perjalanan'] == 'TAPP' and $perjalanan['jamberangkat'] <= $um['um2']) {
            //     $this->db->select_sum('um_pagi');
            //     $this->db->where('perjalanan_id', $this->input->post('id'));
            //     $query = $this->db->get('perjalanan_anggota');
            //     $um_pagi = $query->row()->um_pagi;

            //     $this->db->set('um2', 'YA');
            //     $this->db->set('um_pagi', $um_pagi);
            //     $this->db->where('id', $this->input->post('id'));
            //     $this->db->update('perjalanan');
            // } else {
            //     $this->db->set('um2', 'TIDAK');
            //     $this->db->set('um_pagi', 0);
            //     $this->db->where('id', $this->input->post('id'));
            //     $this->db->update('perjalanan');
            // };
            //Makan Siang
            // if ($this->input->post('jamberangkat') <= $um['um3'] and $this->input->post('jamkembali') >= $um['um3']) {
            //     $this->db->select_sum('um_siang');
            //     $this->db->where('perjalanan_id', $this->input->post('id'));
            //     $query = $this->db->get('perjalanan_anggota');
            //     $um_siang = $query->row()->um_siang;

            //     $this->db->set('um3', 'YA');
            //     $this->db->set('um_siang', $um_siang);
            //     $this->db->where('id', $this->input->post('id'));
            //     $this->db->update('perjalanan');
            // } else {
            //     $this->db->set('um3', 'TIDAK');
            //     $this->db->set('um_siang', 0);
            //     $this->db->where('id', $this->input->post('id'));
            //     $this->db->update('perjalanan');
            // };
            //Makan Malam
        //     if ($this->input->post('jamkembali') >= $um['um4']) {
        //         $this->db->select_sum('um_malam');
        //         $this->db->where('perjalanan_id', $this->input->post('id'));
        //         $query = $this->db->get('perjalanan_anggota');
        //         $um_malam = $query->row()->um_malam;

        //         $this->db->set('um4', 'YA');
        //         $this->db->set('um_malam', $um_malam);
        //         $this->db->where('id', $this->input->post('id'));
        //         $this->db->update('perjalanan');
        //     } else {
        //         $this->db->set('um4', 'TIDAK');
        //         $this->db->set('um_malam', 0);
        //         $this->db->where('id', $this->input->post('id'));
        //         $this->db->update('perjalanan');
        //     };
        //     $total = $perjalanan['uang_saku'] + $insentif_pagi + $um_pagi + $um_siang + $um_malam + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];
        // } else {
        //     $total = 0;
        // }

        $this->db->set('tglkembali', date("Y-m-d"));
        $this->db->set('jamkembali', date("H:i:s"));
        $this->db->set('cekkembali', $this->session->userdata('inisial'));
        $this->db->set('kmkembali', $kmkembali);
        $this->db->set('supirkembali', $this->input->post('supirkembali'));
        $this->db->set('kmtotal', $kmtotal);
        $this->db->set('catatan_security', $this->input->post('catatan'));
        // $this->db->set('total', $total);
        $this->db->set('status', $stat);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        // $perjalanan_update = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
        // $peserta = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' => $this->input->post('id')])->result_array();
        // foreach ($peserta as $p) :
        //     if ($perjalanan_update['uang_saku'] > 0) {
        //         $uangsaku = $p['uang_saku'];
        //     } else {
        //         $uangsaku = 0;
        //     }
        //     if ($perjalanan_update['insentif_pagi'] > 0) {
        //         $insentif = $p['insentif_pagi'];
        //     } else {
        //         $insentif = 0;
        //     }
        //     if ($perjalanan_update['um_pagi'] > 0) {
        //         $um_pagi = $p['um_pagi'];
        //     } else {
        //         $um_pagi = 0;
        //     }
        //     if ($perjalanan_update['um_siang'] > 0) {
        //         $um_siang = $p['um_siang'];
        //     } else {
        //         $um_siang = 0;
        //     }
        //     if ($perjalanan_update['um_malam'] > 0) {
        //         $um_malam = $p['um_malam'];
        //     } else {
        //         $um_malam = 0;
        //     }

        //     $total = $uangsaku + $insentif + $um_pagi + $um_siang + $um_malam;
        //     $this->db->set('total', $total);
        //     $this->db->where('npk', $p['npk']);
        //     $this->db->where('perjalanan_id', $this->input->post('id'));
        //     $this->db->update('perjalanan_anggota');
        // endforeach;

        $this->db->set('status', '9');
        $this->db->where('id', $perjalanan['reservasi_id']);
        $this->db->update('reservasi');

        if ($perjalanan['jenis_perjalanan'] == 'DLPP' or $perjalanan['jenis_perjalanan'] == 'TAPP') {
            $user = $this->db->get_where('karyawan', ['npk' => $perjalanan['npk']])->row_array();
            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                'https://region01.krmpesan.com/api/v2/message/send-text',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
                    ],
                    'json' => [
                        'phone' => $user['phone'],
                        'message' => "*PERJALANAN DINAS DLPP TELAH KEMBALI*". 
                        "\r\n \r\n No. Perjalanan : *" . $perjalanan['id'] . "*" .
                        "\r\n Nama : *" . $perjalanan['nama'] . "*" .
                        "\r\n Tujuan : *" . $perjalanan['tujuan'] . "*" .
                        "\r\n Keperluan : *" . $perjalanan['keperluan'] . "*" .
                        "\r\n Peserta : *" . $perjalanan['anggota'] . "*" .
                        "\r\n Berangkat : *" . $perjalanan['tglberangkat'] . "* *" . $perjalanan['jamberangkat'] . "*" .
                        "\r\n Kembali : *" . $perjalanan['tglkembali'] . "* *" . $perjalanan['jamkembali'] . "*" .
                        "\r\n Kendaraan : *" . $perjalanan['nopol'] . "* ( *" . $perjalanan['kepemilikan'] . "* )" .
                        "\r\n \r\nPerjalanan ini telah kembali, JANGAN LUPA UNTUK SEGERA MELAKUKAN PENYELESAIAN.".
                        "\r\n \r\nPenyelesaian sudah di verifikasi oleh GA pada pukul 07:00-09:00 (dibayarkan hari yang sama).".
                        "\r\n \r\nPenyelesaian sudah di verifikasi oleh GA pada pukul lewat 09:01 (dibayarkan hari berikutnya).".
                        "\r\n \r\nklik link berikut : https://raisa.winteq-astra.com/perjalanan/penyelesaian/".$perjalanan['id'].
                        "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                    ],
                ]
            );
            $body = $response->getBody();
        }

        redirect('cekdl/kembali');
    }
    public function tambahpeserta()
    {
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
        foreach ($this->input->post('anggota') as $a) :
            $karyawan = $this->db->get_where('karyawan', ['inisial' => $a])->row_array();
            $dept = $this->db->get_where('karyawan_dept', ['id' => $karyawan['dept_id']])->row_array();
            $posisi = $this->db->get_where('karyawan_posisi', ['id' => $karyawan['posisi_id']])->row_array();
            $this->db->where('jenis_perjalanan', $perjalanan['jenis_perjalanan']);
            $this->db->where('gol_id', $karyawan['gol_id']);
            $tunjangan = $this->db->get('perjalanan_tunjangan')->row_array();
            //Cek Peserta
            $this->db->where('perjalanan_id', $this->input->post('id'));
            $this->db->where('karyawan_inisial', $a);
            $exist_peserta = $this->db->get('perjalanan_anggota')->row_array();
            if (empty($exist_peserta)) {
                $peserta = [
                    'perjalanan_id' => $this->input->post('id'),
                    'reservasi_id' => $perjalanan['reservasi_id'],
                    'npk' => $karyawan['npk'],
                    'karyawan_inisial' => $karyawan['inisial'],
                    'karyawan_nama' => $karyawan['nama'],
                    'karyawan_dept' => $dept['nama'],
                    'karyawan_posisi' => $posisi['nama'],
                    'karyawan_gol' => $karyawan['gol_id'],
                    'uang_saku' => $tunjangan['uang_saku'],
                    'insentif_pagi' => $tunjangan['insentif_pagi'],
                    'um_pagi' => $tunjangan['um_pagi'],
                    'um_siang' => $tunjangan['um_siang'],
                    'um_malam' => $tunjangan['um_malam'],
                    'total' => '0',
                    'status_pembayaran' => 'BELUM DIBAYAR',
                    'status' => '1'
                ];
                $this->db->insert('perjalanan_anggota', $peserta);
            }
        endforeach;

        $anggota = $this->db->where('perjalanan_id', $perjalanan['id']);
        $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        //Uang Saku
        if ($perjalanan['jenis_perjalanan'] == 'TAPP') {
            $this->db->select_sum('uang_saku');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $uang_saku = $query->row()->uang_saku;
        } else {
            $uang_saku = 0;
        }

        //Insentif pagi
        if ($perjalanan['jamberangkat'] <= $um['um1']) {
            $this->db->select_sum('insentif_pagi');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $insentif_pagi = $query->row()->insentif_pagi;
        } else {
            $insentif_pagi = 0;
        }

        //Makan Pagi
        if ($perjalanan['jenis_perjalanan'] == 'TAPP' and $perjalanan['jamberangkat'] <= $um['um2']) {
            $this->db->select_sum('um_pagi');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_pagi = $query->row()->um_pagi;
        } else {
            $um_pagi = 0;
        }

        //Makan Siang
        if ($perjalanan['jamberangkat'] <= $um['um3'] and $perjalanan['jamkembali'] >= $um['um3']) {
            $this->db->select_sum('um_siang');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_siang = $query->row()->um_siang;
        } else {
            $um_siang = 0;
        }

        //Makan Malam
        if ($perjalanan['jamkembali'] >= $um['um4']) {
            $this->db->select_sum('um_malam');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_malam = $query->row()->um_malam;
        } else {
            $um_malam = 0;
        }
        $total = $uang_saku + $insentif_pagi + $um_pagi + $um_siang + $um_malam + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];
        $this->db->set('uang_saku', $uang_saku);
        $this->db->set('insentif_pagi', $insentif_pagi);
        $this->db->set('um_pagi', $um_pagi);
        $this->db->set('um_siang', $um_siang);
        $this->db->set('um_malam', $um_malam);
        $this->db->set('total', $total);
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $perjalanan['id']);
        $this->db->update('perjalanan');

        $this->db->set('uang_saku', $uang_saku);
        $this->db->set('insentif_pagi', $insentif_pagi);
        $this->db->set('um_pagi', $um_pagi);
        $this->db->set('um_siang', $um_siang);
        $this->db->set('um_malam', $um_malam);
        $this->db->set('total', $total);
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $perjalanan['reservasi_id']);
        $this->db->update('reservasi');

        redirect('cekdl/cekberangkat/' . $perjalanan['id']);
    }

    public function hapus_anggota($id, $inisial)
    {
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $id])->row_array();

        $this->db->where('perjalanan_id', $id);
        $this->db->where('karyawan_inisial', $inisial);
        $this->db->delete('perjalanan_anggota');

        $anggota = $this->db->where('perjalanan_id', $perjalanan['id']);
        $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        //Uang Saku
        if ($perjalanan['jenis_perjalanan'] == 'TAPP') {
            $this->db->select_sum('uang_saku');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $uang_saku = $query->row()->uang_saku;
        } else {
            $uang_saku = 0;
        }

        //Insentif pagi
        if ($perjalanan['jamberangkat'] <= $um['um1']) {
            $this->db->select_sum('insentif_pagi');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $insentif_pagi = $query->row()->insentif_pagi;
        } else {
            $insentif_pagi = 0;
        }

        //Makan Pagi
        if ($perjalanan['jenis_perjalanan'] == 'TAPP' and $perjalanan['jamberangkat'] <= $um['um2']) {
            $this->db->select_sum('um_pagi');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_pagi = $query->row()->um_pagi;
        } else {
            $um_pagi = 0;
        }

        //Makan Siang
        if ($perjalanan['jamberangkat'] <= $um['um3'] and $perjalanan['jamkembali'] >= $um['um3']) {
            $this->db->select_sum('um_siang');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_siang = $query->row()->um_siang;
        } else {
            $um_siang = 0;
        }

        //Makan Malam
        if ($perjalanan['jamkembali'] >= $um['um4']) {
            $this->db->select_sum('um_malam');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_malam = $query->row()->um_malam;
        } else {
            $um_malam = 0;
        }
        $total = $uang_saku + $insentif_pagi + $um_pagi + $um_siang + $um_malam + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];
        $this->db->set('uang_saku', $uang_saku);
        $this->db->set('insentif_pagi', $insentif_pagi);
        $this->db->set('um_pagi', $um_pagi);
        $this->db->set('um_siang', $um_siang);
        $this->db->set('um_malam', $um_malam);
        $this->db->set('total', $total);
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $perjalanan['id']);
        $this->db->update('perjalanan');

        $this->db->set('uang_saku', $uang_saku);
        $this->db->set('insentif_pagi', $insentif_pagi);
        $this->db->set('um_pagi', $um_pagi);
        $this->db->set('um_siang', $um_siang);
        $this->db->set('um_malam', $um_malam);
        $this->db->set('total', $total);
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $perjalanan['reservasi_id']);
        $this->db->update('reservasi');

        redirect('cekdl/cekberangkat/' . $id);
    }

    public function revisi()
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->set('catatan_security', $this->input->post('catatan') . ' - Direvisi oleh ' . $this->session->userdata('inisial') . ' pada ' . date('d-m-Y H:i'));
        $this->db->set('status', '8');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $dl = $this->db->get_where('perjalanan', ['id' =>  $this->input->post('id')])->row_array();
        $ga_admin = $this->db->get_where('karyawan_admin', ['sect_id' => '214'])->row_array();
        $postData = array(
            'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
            'number' => $ga_admin['phone'],
            'message' => "*REVISI PERJALANAN DINAS*\r\n \r\n No. Perjalanan : *" . $dl['id'] . "*" .
                "\r\n Nama Pemohon: *" . $dl['nama'] . "*" .
                "\r\n Tujuan : *" . $dl['tujuan'] . "*" .
                "\r\n Keperluan : *" . $dl['keperluan'] . "*" .
                "\r\n Peserta : *" . $dl['anggota'] . "*" .
                "\r\n Berangkat : *" . $dl['tglberangkat'] . "* *" . $dl['jamberangkat'] . "* _estimasi_" .
                "\r\n Kembali : *" . $dl['tglkembali'] . "* *" . $dl['jamkembali'] . "* _estimasi_" .
                "\r\n Kendaraan : *" . $dl['nopol'] . "* ( *" . $dl['kepemilikan'] . "*" .
                "\r\n Catatan : *" . $dl['catatan_security'] . "*" .
                "\r\n Direvisi Oleh " . $this->session->userdata('inisial') . ' pada ' . date('d-m-Y H:i') .
                " ) \r\n \r\nPerjalanan ini membutuhkan revisi dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
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

        redirect('cekdl/berangkat');
    }

    // public function edit()
    // {
    //     $this->db->set('tglberangkat', $this->input->post('tglberangkat'));
    //     $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
    //     $this->db->set('tglkembali', $this->input->post('tglkembali'));
    //     $this->db->set('jamkembali', $this->input->post('jamkembali'));
    //     $this->db->where('id', $this->input->post('id'));
    //     $this->db->update('perjalanan');

    //     $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
    //     if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um1']) {
    //         $this->db->set('um1', 'YA');
    //         $this->db->where('id', $this->input->post('id'));
    //         $this->db->update('perjalanan');
    //     };
    //     if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um2']) {
    //         $this->db->set('um2', 'YA');
    //         $this->db->where('id', $this->input->post('id'));
    //         $this->db->update('perjalanan');
    //     };
    //     if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um3'] and $this->input->post('jamkembali') >= $um['um3']) {
    //         $this->db->set('um3', 'YA');
    //         $this->db->where('id', $this->input->post('id'));
    //         $this->db->update('perjalanan');
    //     };
    //     if ($this->input->post('jenis') != 'TA' and $this->input->post('jamkembali') >= $um['um4']) {
    //         $this->db->set('um4', 'YA');
    //         $this->db->where('id', $this->input->post('id'));
    //         $this->db->update('perjalanan');
    //     };

    //     redirect('cekdl/index');
    // }
}
