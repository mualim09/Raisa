<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Projectbudget extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }
    public function index()
    {   
    	$data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Project Budget';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['project'] = $this->db->get_where('project', ['status' =>  'OPEN'])->result_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        if($karyawan['posisi_id'] < 7 AND $karyawan['dept_id'] == 11 )
        {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/projecteng', $data);
        $this->load->view('templates/footer');
        }elseif ($karyawan['sect_id'] == 222) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/projectaktual', $data);
        $this->load->view('templates/footer');
        }elseif ($karyawan['sect_id'] == 223) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/project', $data);
        $this->load->view('templates/footer');
        }else{
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/projecteng', $data);
        $this->load->view('templates/footer');
        }
        
    }
    public function budget($copro)
    {	
    	$data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Project Budget';
    	$data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->get_where('project_budget', ['copro' =>  $copro])->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        $data['query'] = $this->db->query("SELECT part_project.nama from part_project where not exists (SELECT project_budget.part from project_budget where part_project.nama = project_budget.part AND copro ='$copro')")->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budget', $data);
        $this->load->view('templates/footer');
    }
    public function budgeteng($copro)
    {   
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Project Budget';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->get_where('project_budget', ['copro' =>  $copro])->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budgeteng', $data);
        $this->load->view('templates/footer');
    }
    public function budgetpch($copro){   
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Project Budget';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->get_where('project_budget', ['copro' =>  $copro])->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        $data['query'] = $this->db->query("SELECT part_project.nama from part_project where not exists (SELECT project_budget.part from project_budget where part_project.nama = project_budget.part AND copro ='$copro')")->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budgetaktual', $data);
        $this->load->view('templates/footer');
    }
    public function budgetpchdetail($copro,$part){   
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Project Budget';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->query("SELECT * from project_budget_detail where copro = '$copro' and part ='$part'")->result_array(); 
        $data['budget'] = $this->db->query("SELECT * from project_budget where copro = '$copro' and part ='$part'")->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        $data['query'] = $this->db->query("SELECT part_project.nama from part_project where not exists (SELECT project_budget.part from project_budget where part_project.nama = project_budget.part AND copro ='$copro')")->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budgetaktualdetail', $data);
        $this->load->view('templates/footer');
    }
    public function estimasicost(){
        $copro = $this->input->post('copro');
        $part = $this->input->post('part');
        $kategori = $this->input->post('kategori');
        $data = [
            'copro' => $this->input->post('copro'),
            'part' => $this->input->post('part'),
            'kategori'=> $this->input->post('kategori'),
            'biaya_est' => $this->input->post('biaya'),
            'biaya_act' => 0,
            'keterangan' => $this->input->post('keterangan')];
            $this->db->insert('project_budget_detail', $data);

            $pp = $this->db->query("SELECT sum(biaya_est) from project_budget_detail where part = '$part' and kategori = 'pp' and copro =".$copro)->result_array();
            $exprod = $this->db->query("SELECT sum(biaya_est) from project_budget_detail where part = '$part' and kategori = 'exprod' and copro =".$copro)->result_array();
            $total = $pp[0]['sum(biaya_est)'] + $exprod[0]['sum(biaya_est)'] ;
            $selisih = $this->input->post('budget') - $total;
            $persen = $total / ($this->input->post('budget')/100);
            $persens = $selisih / ($this->input->post('budget')/100);

            $this->db->set('est_cost', $pp[0]['sum(biaya_est)']);
            $this->db->set('est_exprod', $exprod[0]['sum(biaya_est)']);
            $this->db->set('est_total',  $total);
            $this->db->set('est_selisih',  $selisih);
            $this->db->set('est_persen',  $persen);
            $this->db->set('est_selisihpersen',  $persens);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('project_budget');
            // echo $this->db->last_query();
        

      redirect('projectbudget/budgeteng/'.$this->input->post('copro'));
    }
    public function aktualcost()
    {   
        $copro = $this->input->post('copro');
        $part = $this->input->post('part');
        $kategori = $this->input->post('kategori');
        $budget = $this->db->query("SELECT budget from project_budget where copro = '$copro' and part ='$part'")->result_array();
        $this->db->set('biaya_act', $this->input->post('biaya_act'));
        $this->db->set('keterangan', $this->input->post('keterangan'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('project_budget_detail');

        $pp = $this->db->query("SELECT sum(biaya_act) from project_budget_detail where part = '$part' and kategori = 'pp' and copro =".$copro)->result_array();
        $exprod = $this->db->query("SELECT sum(biaya_act) from project_budget_detail where part = '$part' and kategori = 'exprod' and copro =".$copro)->result_array();
        $total = $pp[0]['sum(biaya_act)'] + $exprod[0]['sum(biaya_act)'] ;
        $selisih = $budget[0]['budget'] - $total;
        $persen = $total / ($budget[0]['budget']/100);
        $persens = $selisih / ($budget[0]['budget']/100);
            
        $this->db->set('act_cost', $pp[0]['sum(biaya_act)']);
        $this->db->set('act_exprod', $exprod[0]['sum(biaya_act)']);
        $this->db->set('act_total',  $total);
        $this->db->set('act_selisih',  $selisih);
        $this->db->set('act_persen',  $persen);
        $this->db->set('act_selisihpersen',  $persens);
        $this->db->where('copro', $this->input->post('copro'));
        $this->db->where('part', $this->input->post('part'));
        $this->db->update('project_budget');

        redirect("projectbudget/budgetpchdetail/$copro/$part");
    }
    public function tmbhbudget()
    {	   
    	$data = [
                'copro' => $this->input->post('copro'),
                'part' => $this->input->post('part'),
                'budget' => $this->input->post('budget'),
                'est_cost' => '0',
                'est_exprod'=> '0',
                'est_total' =>'0',
                'est_persen' => '0',
                'est_selisih'=> '0',
                'est_selisihpersen'=>'0',
                'act_cost' => '0',
                'act_exprod'=> '0',
                'act_total' =>'0',
                'act_persen' => '0',
                'act_selisih'=> '0',
                'act_selisihpersen'=> '0'
                ];
            $this->db->insert('project_budget', $data);
           

        redirect('projectbudget/budget/'.$data['copro']);
    }
    public function hapus_project($id)
    {
        $query = "delete from project_budget where id='$id'";
        $this->db->query($query);
    }
}