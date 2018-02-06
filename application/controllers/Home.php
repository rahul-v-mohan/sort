<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    var $menu;
    function __construct() {
        parent::__construct();
 
        $this->load->model('common');
        $this->menu = [
                'Home'=>[ 'class'=> 'nc-atom','url' => ''],
                'About Us'=>[ 'class'=> 'nc-attach-87','url' => 'home/about_us'],
                'Login'=>[ 'class'=> 'nc-lock-circle-open','url' => 'home/login'],
                'Donar Registration'=>[ 'class'=> 'nc-paper-2','url' => 'home/donar_registration'],
                'Contact Us'=>[ 'class'=> 'nc-pin-3','url' => 'home/contact'],
                ];
    }

    public function index() {
        $this->load->view('header_site.php',['menu'=>$this->menu]);
        $this->load->view('login.php');
        $this->load->view('footer.php');
    }
    public function about_us() {
        $this->load->view('header_site.php',['menu'=>$this->menu]);
        $this->load->view('aboutus.php');
        $this->load->view('footer.php');
    }
    public function login() {
        $this->load->view('header_site.php',['menu'=>$this->menu]);
        $this->load->view('login.php');
        $this->load->view('footer.php');
    }
    public function donar_registration() {
        $this->load->view('header_site.php',['menu'=>$this->menu]);
        $this->load->view('donar_registration.php',['menu'=>$this->menu]);
        $this->load->view('footer.php');
    }
    public function contact() {
        $this->load->view('header_site.php',['menu'=>$this->menu]);
        $this->load->view('contact.php');
        $this->load->view('footer.php');
    }
    

}
