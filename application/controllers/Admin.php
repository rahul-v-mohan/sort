<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    var $menu;

    function __construct() {
        parent::__construct();

        $this->load->model('common');
        $this->menu = [
            'Home' => ['class' => '', 'url' => 'admin/index'],
            'Hospital Registration' => ['class' => '', 'url' => 'admin/hospital_registration'],
        ];
    }

    public function index() {
        $this->load->view('header_user.php', ['menu' => $this->menu]);
        $this->load->view('login.php');
        $this->load->view('footer.php');
    }
    public function hospital_registration($id =0) {
        $data['form_method'] = 'insert';
        $data['form_data'] = [
                                'name' =>'',
                                'dob' =>'',
                                'email' => '',
                                'mobile' =>'',
                                'gender' =>'',
                                'status' => '1',
                                'house_name' =>'',            
                                'location' =>'',            
                                'district' =>'',            
                                'state' =>'',            
                                'id' => '0' ,
        ];
        
        if(!empty($id)){
            $fields = [
                'table' => 'user',
                'select' => array_keys($data['form_data']), 
                'where' => ['id' =>$id], 
                'where_in' => [], 
                'like' =>  [], 
                'group_by' => '', 
                'order_by' => '', 
                'limit' =>  [],];
            $result = $this->common->table_details($fields);
                         if ($result->num_rows() == 1) {
                 $data['form_data'] = $result->row_array();
                 $data['form_method'] = 'update';
                         }
        }
        
            $fields = [
                'table' => 'user',
                'select' => array_keys($data['form_data']), 
                'where' => [], 
                'where_in' => [], 
                'like' =>  [], 
                'group_by' => '', 
                'order_by' => '', 
                'limit' =>  [],];
            $data['hospital_datas'] = $this->common->table_details($fields)->result_array();
            
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('hospital_registration.php', $data);
        $this->load->view('footer.php');
    }
        public function hospital_reg_save() {
            
        $id = $this->input->post('id');
        

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('dob', 'Date Of Birth', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('mobile', 'mobile', 'required');
        $this->form_validation->set_rules('house_name', 'House name', 'required');
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('district', 'District', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|exact_length[10]|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->hospital_registration($id);
            return;
        } else {
                  
            
            $data = array(
            'email' => $this->input->post('email'),
            'name' => $this->input->post('name'),
            'dob' =>$this->input->post('dob'),
            'gender' =>$this->input->post('gender'),
            'mobile' =>$this->input->post('mobile'),
            'house_name' =>$this->input->post('house_name'),
            'location' =>$this->input->post('location'),
            'district' =>$this->input->post('district'),
            'state' =>$this->input->post('state'),
            'status' =>$this->input->post('status'),
        );
            if($this->input->post('method') == 'insert'){
                        //password creation
               $data['password'] = '';
               $alphabets = range('A', 'Z');
               for ($inc = 1; $inc <= 8; $inc++) {
                   $temp = rand(0, 25);
                   $data['password'] .= $alphabets[$temp];
               }
           ///////////////////////////////   
               $response = $this->common->save_table_details('user', $data);
               $msg = (empty($response))?'Not able to insert try again':'Successfully Inserted';
               $this->session->set_flashdata('msg', $msg);
            }else if($this->input->post('method') == 'update'){
                $where =['id' => $id];
                $this->common->update_table_details('user', $data, $where);
               $msg = (empty($response))?'Not able to update try again':'Successfully Updated';
               $this->session->set_flashdata('msg', $msg);
            }
        }
                       redirect('admin/hospital_registration');
    }
   


}
