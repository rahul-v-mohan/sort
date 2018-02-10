<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    var $menu;

    function __construct() {
        parent::__construct();

        $this->load->model('common');
        $this->menu = [
            'Profile' => ['class' => '', 'url' => 'admin/index'],
            'Profile Edit' => ['class' => '', 'url' => 'admin/profile_edit'],
        ];
    }

    public function index() {
        $this->load->view('header_user.php', ['menu' => $this->menu]);
        $this->load->view('login.php');
        $this->load->view('footer.php');
    }

   


}
