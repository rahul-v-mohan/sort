<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    var $menu,$menutop;

    function __construct() {
        parent::__construct();
//        $this->output->enable_profiler(TRUE);
        $this->load->model('common');
        
        $this->load->helper('rolemenu');
        $temp = getmenu();
        $this->menu = $temp['menu'];
        $this->menutop = $temp['menutop'];
        
        if ($this->session->userdata('logged_in')) {
            $user_data = $this->session->userdata('USER');
            $access = ($user_data['role'] == 'admin') ? 1 : 0;
        }

        if (empty($access)) {
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

    public function hospital_registration($id = 0) {
        $foot = [
            'js_files' => ['JS/form/hospital_registration.js'],
        ];
        $data['form_method'] = 'insert';
        $data['form_data'] = [
            'email' => '','hospital_name' => '','email_hospital' => '',
            'mobile' => '','website_url' => '','status' => '1',
            'location' => '','district' => '','state' => '',
            'id' => '0',
        ];

                $fields = array(
            'table1' => 'user u',
            'table2' => 'hospital h',
            'condition2' => 'u.id = h.user_id',
            'join2' => 'inner', 
            'select' => 'u.id,u.email,u.status,h.hospital_name,h.email_hospital,h.website_url,h.mobile', 
            'where' => [],
            'where_in' => [], 'like' => [], 'group_by' => '',
            'order_by' => '', 'limit' => array());
        $data['hospital_datas'] = $this->common->table_details_join($fields)->result_array();
        if (!empty($id)) {
            $fields = array(
                'table1' => 'user u',
                'table2' => 'hospital h',
                'condition2' => 'u.id = h.user_id',
                'join2' => 'inner',
                'select' => 'u.id,u.email,u.status,h.hospital_name,h.email_hospital,h.website_url,h.location,h.district,h.state,h.mobile',
                'where' => ['u.id' => $id],
                'where_in' => [], 'like' => [], 'group_by' => '',
                'order_by' => '', 'limit' => array());
            
            $result = $this->common->table_details_join($fields);
            if ($result->num_rows() == 1) {
                $data['form_data'] = $result->row_array();
                $data['form_method'] = 'update';
            }
        }


        $this->load->view('header_site.php', ['menu' => $this->menu, 'top_menu'=>$this->menutop]);
        $this->load->view('hospital_registration.php', $data);
        $this->load->view('footer.php', $foot);
    }

    public function hospital_reg_save() {
        $this->load->helper('mailrahul');   // Extended helper created for mail sending purpose    
        $id = $this->input->post('id');


        if ($this->input->post('method') == 'insert') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        } else {
            $original_value = $this->db->query("SELECT email FROM user WHERE id = " . $id)->row()->email;
            if ($this->input->post('email') != $original_value) {
                $is_unique = '|is_unique[user.email]';
            } else {
                $is_unique = '';
            }
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email' . $is_unique);
        }
        $this->form_validation->set_rules('hospital_name', 'Hospital Name', 'required');
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
                'status' => $this->input->post('status'),
                'role' => 'hospital',
            );
            $hospital_data = array(
                'email_hospital' => $this->input->post('email_hospital'),
                'hospital_name' => $this->input->post('hospital_name'),
                'website_url' => $this->input->post('website_url'),
                'mobile' => $this->input->post('mobile'),
                'location' => $this->input->post('location'),
                'district' => $this->input->post('district'),
                'state' => $this->input->post('state'),
            );
            if ($this->input->post('method') == 'insert') {
                //password creation
                $data['password'] = '';
                $alphabets = range('A', 'Z');
                for ($inc = 1; $inc <= 8; $inc++) {
                    $temp = rand(0, 25);
                    $data['password'] .= $alphabets[$temp];
                }
                ///////////////////////////////   
                $insert_id = $this->common->save_table_details('user', $data);
                $hospital_data['user_id'] = $insert_id;
                $response = $this->common->save_table_details('hospital', $hospital_data);
                $msg = (empty($response)) ? 'Not able to insert try again' : 'Successfully Inserted';
                if (!empty($response)) {
                    $html = <<<rahul
                 <h4> Account Created</h4>         
                  Username: {$data['email']} </br>
                  Password: {$data['password']} </br>
rahul;
                    getemail($data['email'], 'Login Credentials', $html);
                }
                $this->session->set_flashdata('msg', $msg);
            } else if ($this->input->post('method') == 'update') {
                $where = ['id' => $id];
                $this->common->update_table_details('user', $data, $where);
                $response = $this->common->update_table_details('hospital', $hospital_data, ['user_id' => $id]);
                $msg = (empty($response)) ? 'Not able to update try again' : 'Successfully Updated';
                $this->session->set_flashdata('msg', $msg);
            }
        }
        redirect('admin/hospital_registration');
    }

    public function hospital_delete() {

        $id = $this->input->post('id');
        $where = ['id' => $id];
        $this->common->delete_table_details('user', $where);
        redirect('admin/hospital_registration');
    }


    public function change_password() {
        $this->load->view('header_site.php', ['menu' => $this->menu,'top_menu'=>$this->menutop]);
        $this->load->view('change_password.php',['action_url' => 'admin/change_password_check']);
        $this->load->view('footer.php');
    }

    public function change_password_check() {
        $user = $this->session->userdata('USER');
        $data_check = array(
            'id' => $user['id'],
            'password' => $this->input->post('current_password'),
        );
        $data_reg = array(
            'password' => $this->input->post('new_password'),
        );

        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
        if ($this->form_validation->run() == FALSE) {
            $this->change_password();
            return;
        } else {
            $fields = [
                'table' => 'user',
                'select' => 'id',
                'where' => $data_check,
                'where_in' => [],
                'like' => [],
                'group_by' => '',
                'order_by' => '',
                'limit' => [],];
            $response = $this->common->table_details($fields);

            if ($response->num_rows() == 1) {
                $where = ['id' => $user['id']];
                $responseuser = $this->common->update_table_details('user', $data_reg, $where);
            } else {
                $msg = 'Enter Correct Password';
                $this->session->set_flashdata('msg', $msg);
                redirect('admin/change_password', 'refresh');
            }
            if (empty($responseuser)) {
                $msg = 'Not Able to Update Password!! Try Again';
                $this->session->set_flashdata('msg', $msg);
                redirect('admin/change_password', 'refresh');
            } else {
                $msg = 'Password is Update!!login With New Password';
                $this->session->set_flashdata('msg', $msg);
                redirect('home/logout', 'refresh');
            }
        }
    }

}
