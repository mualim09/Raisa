<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Depthead extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'LemburKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['npk' =>  $this->session->userdata('npk')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/index', $data);
        $this->load->view('templates/footer');
    }

    public function presensi()
    {
        date_default_timezone_set('asia/jakarta');
        $fr  = date('Y-m-d 00:00:00', strtotime($this->input->post('datefr')));
        $to = date('Y-m-d 23:59:59', strtotime($this->input->post('dateto')));
        if ($fr != null and $to != null) {
            $this->db->where('time >=', $fr);
            $this->db->where('time <=', $to);
            // $this->db->where('dept_id', $this->session->userdata('dept_id'));
            $data['presensi'] = $this->db->get('presensi')->result_array();
            $data['fr']  = date('d M Y', strtotime($this->input->post('datefr')));
            $data['to'] = date('d M Y', strtotime($this->input->post('dateto')));
        } else {
            $this->db->where('time >=', date('Y-m-d 00:00:00'));
            $this->db->where('time <=', date('Y-m-d 00:00:00'));
            $this->db->where('dept_id', $this->session->userdata('dept_id'));
            $data['presensi'] = $this->db->get('presensi')->result_array();
            $data['fr']  = date('d M Y');
            $data['to'] = date('d M Y');
        }
        // if (empty($this->input->post('month'))) {
        //     $data['bulan'] = date('m');
        // } else {
        //     $data['bulan'] = $this->input->post('month');
        // }
        // $data['tahun'] = date('Y');
        $data['sidemenu'] = 'Kepala Departemen';
        $data['sidesubmenu'] = 'Laporan Kehadiran';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('depthead/presensi', $data);
        $this->load->view('templates/footer');
    }
}
