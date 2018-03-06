<?php
     function getmenu() {
         $ci=& get_instance();
         $ci->load->library('session');
         $user = $ci->session->userdata('USER');
         $response['menu']=[];
         $response['menutop']=[];
    if(empty($user['role'])){
                $response['menu'] = [
            'Home' => [ 'class' => 'nc-atom', 'url' => ''],
            'About Us' => [ 'class' => 'nc-attach-87', 'url' => 'home/about_us'],
            'Login' => [ 'class' => 'nc-lock-circle-open', 'url' => 'home/login'],
            'Donar Registration' => [ 'class' => 'nc-paper-2', 'url' => 'home/donar_registration'],
            'Contact Us' => [ 'class' => 'nc-pin-3', 'url' => 'home/contact'],
        ];
                $response['menutop']=[];
    }else{
        if($user['role'] == 'admin'){
         $response['menu'] = [
            'Home' => ['class' => '', 'url' => 'admin'],
            'Donar Registration' => ['class' => '', 'url' => 'home/donar_registration'],
            'Hospital Registration' => ['class' => '', 'url' => 'admin/hospital_registration'],
            'Site Home' => [ 'class' => '', 'url' => ''],
            'About Us' => [ 'class' => '', 'url' => 'home/about_us'],
            'Contact Us' => [ 'class' => '', 'url' => 'home/contact'],
        ];
        $response['menutop'] = [
            'Change Password' => ['class' => '', 'url' => 'admin/change_password'],
            'Logout' => ['class' => '', 'url' => 'home/logout'],
        ];
        }elseif($user[role] == 'donar'){
         $response['menu'] = [
            'Home' => ['class' => '', 'url' => 'donar'],
            'Donar Registration' => ['class' => '', 'url' => 'home/donar_registration'],
        ];
        $response['menutop'] = [
            'Change Password' => ['class' => '', 'url' => 'admin/change_password'],
            'Logout' => ['class' => '', 'url' => 'home/logout'],
        ];
        }
    }
        return $response;
    }