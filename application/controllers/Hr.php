<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hr extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function karyawan()
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Data Karyawan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['datakaryawan'] = $this->db->get('karyawan')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('karyawan/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data = [
            'npk' => $this->input->post('npk'),
            'inisial' => $this->input->post('inisial'),
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'posisi_id' => $this->input->post('posisi'),
            'div_id' => $this->input->post('div'),
            'dept_id' => $this->input->post('dept'),
            'sect_id' => $this->input->post('sect'),
            'gol_id' => $this->input->post('gol'),
            'fasilitas_id' => $this->input->post('fasilitas'),
            'atasan1' => $this->input->post('atasan1'),
            'atasan2' => $this->input->post('atasan2'),
            'password' => password_hash("winteq", PASSWORD_DEFAULT),
            'role_id' => $this->input->post('role'),
            'is_active' => 1
        ];
        $this->db->insert('karyawan', $data);
        redirect('hr/karyawan');
    }
}
