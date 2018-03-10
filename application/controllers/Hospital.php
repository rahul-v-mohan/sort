<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hospital extends CI_Controller {

    var $menu,$menutop;

    function __construct() {
        parent::__construct();
        $this->output->enable_profiler(TRUE);
        $this->load->model('common');
        
        $this->load->helper('rolemenu');
        $temp = getmenu();
        $this->menu = $temp['menu'];
        $this->menutop = $temp['menutop'];
        
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('msg', 'Please Login');
            redirect('home', 'refresh');
        }

    }

    public function index() {
//        $data['profile'] = $this->session->userdata('USER'); 

        $this->load->view('header_site.php', ['menu' => $this->menu,'top_menu'=>$this->menutop]);
//        $this->load->view('profile.php',$data);
        $this->load->view('footer.php');
    }

    public function patient_registration($id = 0) {
         $user_data = $this->session->userdata('USER');
         $hopital_id = 0;
         /////////////////////////////////////
         $data['hospital_datas']=[];
         if($user_data['role'] == 'hospital'){
         $data['hospital_datas'] = [$user_data['id'] => $user_data['hospital_name'] ];
         }
         if($user_data['role'] == 'admin'){
                $fields = array(
            'table1' => 'user u',
            'table2' => 'hospital h',
            'condition2' => 'u.id = h.user_id',
            'join2' => 'inner', 
            'select' => 'u.id,h.hospital_name', 
            'where' => ['u.status'=>1],
            'where_in' => [], 'like' => [], 'group_by' => '',
            'order_by' => '', 'limit' => array());
        $data['hospital_datas'] = $this->common->table_details_join($fields)->result_array();
        $data['hospital_datas'] = (!empty($data['hospital_datas']))?array_column($data['hospital_datas'], 'hospital_name','id'):[];
         }
         ////////////////////////////////////
        $foot = [
            'js_files' => [],
        ];
        $data['form_method'] = 'insert';
        $data['form_data'] = [
            'patient_name' => '','dob' => '','mobile' => '',
            'health_conditon' => '','gender' => '','hospital_id' => '',
            'patient_id' => '','id' => '0',
        ];

                $fields = array(
            'table1' => 'hosital_patient p',
            'table2' => 'hospital h',
            'condition2' => 'p.hospital_id = h.user_id',
            'join2' => 'inner', 
            'select' => 'p.*,h.hospital_name', 
            'where' => [],
            'where_in' => [], 'like' => [], 'group_by' => '',
            'order_by' => '', 'limit' => array());
            $fields['where'] = ($user_data['role'] == 'hospital')?[]:[];
        $data['patient_datas'] = $this->common->table_details_join($fields)->result_array();
        if (!empty($id)) {
            $fields = [
                'table' => 'hosital_patient',
                'select' => '*','where' => ['id' => $id],
                'where_in' => [], 'like' => [],
                'group_by' => '','order_by' => '',
                'limit' => [],];
            
            $result = $this->common->table_details($fields);
            if ($result->num_rows() == 1) {
                $data['form_data'] = $result->row_array();
                $data['form_method'] = 'update';
            }
        }


        $this->load->view('header_site.php', ['menu' => $this->menu, 'top_menu'=>$this->menutop]);
        $this->load->view('patient_registration.php', $data);
        $this->load->view('footer.php', $foot);
    }

    public function patient_reg_save() {
        $id = $this->input->post('id');


        $this->form_validation->set_rules('patient_name', 'Patient Name', 'required');
        $this->form_validation->set_rules('patient_id', 'Patient ID', 'required');
        $this->form_validation->set_rules('hospital_id', 'Hospital id', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|exact_length[10]|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->patient_registration($id);
            return;
        } else {


            $data = array(
                'patient_id' => $this->input->post('patient_id'),
                'patient_name' => $this->input->post('patient_name'),
                'mobile' => $this->input->post('mobile'),
                'gender' => $this->input->post('gender'),
                'dob' => $this->input->post('dob'),
                'health_conditon' => $this->input->post('health_conditon'),
                'hospital_id' => $this->input->post('hospital_id'),
            );
            if ($this->input->post('method') == 'insert') {
                $response = $this->common->save_table_details('hosital_patient', $data);
                $msg = (empty($response)) ? 'Not able to insert try again' : 'Successfully Inserted';
                $this->session->set_flashdata('msg', $msg);
            } else if ($this->input->post('method') == 'update') {
                $where = ['id' => $id];
                $response = $this->common->update_table_details('hosital_patient', $data, ['id' => $id]);
                $msg = (empty($response)) ? 'Not able to update try again' : 'Successfully Updated';
                $this->session->set_flashdata('msg', $msg);
            }
        }
        redirect('hospital/patient_registration');
    }

    public function patient_delete() {

        $id = $this->input->post('id');
        $where = ['id' => $id];
        $this->common->delete_table_details('user', $where);
        redirect('hospital/patient_registration');
    }



}
