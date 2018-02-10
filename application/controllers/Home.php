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
    public function getemail() {

        		error_reporting(-1);
		ini_set('display_errors', 1);
                
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'rahul.mohan@ipsrsolutions.com',
            'smtp_pass' => 'ipsr@rahulvm',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        
        $this->load->library('email', $config);
        
        $this->email->set_newline("\r\n");

        $this->email->from('rahul.mohan@ipsrsolutions.com', 'Rahul');
        $this->email->to('rahul.vmohan@gmail.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');  
        $result = $this->email->send();
        echo $this->email->print_debugger();
    }
}
