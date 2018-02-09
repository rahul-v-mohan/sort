<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    var $menu;

    function __construct() {
        parent::__construct();

        $this->load->model('common');
        $this->menu = [
            'Profile' => [ 'class' => '', 'url' => 'admin/index'],
            'Profile Edit' => [ 'class' => '', 'url' => 'admin/profile_edit'],
        ];
    }

    public function index() {
        $this->load->view('header_user.php', ['menu' => $this->menu]);
        $this->load->view('login.php');
        $this->load->view('footer.php');
    }

    public function about_us() {
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('aboutus.php');
        $this->load->view('footer.php');
    }

    public function login() {
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('login.php');
        $this->load->view('footer.php');
    }

    public function donar_registration() {
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('donar_registration.php', ['menu' => $this->menu]);
        $this->load->view('footer.php');
    }

    public function contact() {
        $this->load->view('header_site.php', ['menu' => $this->menu]);
        $this->load->view('contact.php');
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
            $this->load->view('header_site.php', ['menu' => $this->menu]);
            $this->load->view('login.php');
            $this->load->view('footer.php');
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
             if ($result->num_rows() == 0) {
                 $data['USER'] = $result->row_array();
                 $this->session->set_userdata($data);
                 
                 if($data['USER']['role'] == 'admin'){
                     redirect('home/login', 'refresh');
                 }elseif($data['USER']['role'] == 'donar'){
                     redirect('home/login', 'refresh');
                 }elseif($data['USER']['role'] == 'hospital'){
                     redirect('home/login', 'refresh'); 
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

    public function logout() {

        $this->session->sess_destroy();
        redirect('home/login', 'refresh');
    }

}
