<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    var $menu;

    function __construct() {
        parent::__construct();

        $this->load->model('common');
        $this->menu = [
            'Home' => [ 'class' => 'nc-atom', 'url' => ''],
            'About Us' => [ 'class' => 'nc-attach-87', 'url' => 'home/about_us'],
            'Login' => [ 'class' => 'nc-lock-circle-open', 'url' => 'home/login'],
            'Donar Registration' => [ 'class' => 'nc-paper-2', 'url' => 'home/donar_registration'],
            'Contact Us' => [ 'class' => 'nc-pin-3', 'url' => 'home/contact'],
        ];
    }

    public function index() {
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('login.php');
        $this->load->view('footer.php');
    }

    public function about_us() {
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('aboutus.php');
        $this->load->view('footer.php');
    }
/*
 * Login
 */
    public function login() {
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('login.php');
        $this->load->view('footer.php');
    }
    public function logincheck() {
        $data = array(
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'status' =>'1',
        );
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->login;
        } else {
            $fields = [
                'table' => 'user',
                'select' => '*', 
                'where' => $data, 
                'where_in' => [], 
                'like' =>  [], 
                'group_by' => '', 
                'order_by' => '', 
                'limit' =>  [],];
            $result = $this->common->table_details($fields);
             if ($result->num_rows() == 1) {
                 $data['USER'] = $result->row_array();
                 $this->session->set_userdata($data);
                 
                 if($data['USER']['role'] == 'admin'){
                     redirect('admin', 'refresh');
                 }elseif($data['USER']['role'] == 'donar'){
                     redirect('donar', 'refresh');
                 }elseif($data['USER']['role'] == 'hospital'){
                     redirect('hospital', 'refresh'); 
                 }else{
                     $this->session->unset_userdata('USER');
                      $this->session->set_flashdata('msg', 'Something Went wrong'); 
                     redirect('home/login', 'refresh');
                 }
                 
             }else{
                $this->session->set_flashdata('msg', 'Enter Valid Username or Password'); 
             }
        }
        
    }
    ///////////////////////////////////////////////////////////////////////////////
    public function donar_registration($id =0) {
        $foot=[
            'js_files' => ['JS/form/donar_registration.js'],
        ];
        $data['action_page'] = 'home/donar_reg_save';
        $data['form_method'] = 'insert';
        $data['record_view'] = '0';
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
                'where' => ['role' =>'donar'], 
                'where_in' => [], 
                'like' =>  [], 
                'group_by' => '', 
                'order_by' => '', 
                'limit' =>  [],];
            $data['donar_datas'] = $this->common->table_details($fields)->result_array();
            
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('donar_registration.php', $data);
        $this->load->view('footer.php',$foot);
    }
        public function donar_reg_save() {
        $this->load->helper('mailrahul');   // Extended helper created for mail sending purpose 
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
            $this->donar_registration($id);
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
            'role' =>'donar',
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
                              if(!empty($response)){
                   $html =<<<rahul
                 <h4> Account Created</h4>         
                  Username: {$data['email']} </br>
                  Password: {$data['password']} </br>
rahul;
                getemail($data['email'],'Login Credentials',$html);
               }
               $this->session->set_flashdata('msg', $msg);
            }else if($this->input->post('method') == 'update'){
                $where =['id' => $id];
                $response = $this->common->update_table_details('user', $data, $where);
               $msg = (empty($response))?'Not able to update try again':'Successfully Updated';
               $this->session->set_flashdata('msg', $msg);
            }
        }
                       redirect('home/donar_registration');
    }
/*
 * Forget Password
 */
    public function forget_password() {
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('forget_password.php');
        $this->load->view('footer.php');
    }
    public function forget_password_check() {
                $data = array(
            'email' => $this->input->post('email'),
        );
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('forget_password.php');
        $this->load->view('footer.php');
    }
    
/////////////////////////////////////////////////////////////
    public function contact() {
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('contact.php');
        $this->load->view('footer.php');
    }

    public function logout() {

        $this->session->sess_destroy();
        redirect('home/login', 'refresh');
    }

}
