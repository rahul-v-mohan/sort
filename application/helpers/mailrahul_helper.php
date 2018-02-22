<?php
     function getemail($to,$subject,$message) {
         $ci=& get_instance();
         $ci->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'rahul.mohan@ipsrsolutions.com',
            'smtp_pass' => 'xxxxx',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        
        $ci->load->library('email', $config);
        
        $ci->email->set_newline("\r\n");

        $ci->email->from('rahul.mohan@ipsrsolutions.com', 'Rahul');
        $ci->email->to($to);

        $ci->email->subject($subject);
        $ci->email->message($message);  
        $ci->email->send();
        return;
//        echo $ci->email->print_debugger();
    }