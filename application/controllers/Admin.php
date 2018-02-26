<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    var $menu;

    function __construct() {
        parent::__construct();
        $this->load->model('common');
        $this->menu = [
            'Home' => ['class' => '', 'url' => 'admin'],
            'Donar Registration' => ['class' => '', 'url' => 'admin/donar_registration'],
            'Hospital Registration' => ['class' => '', 'url' => 'admin/hospital_registration'],
        ];
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

        $this->load->view('header_site.php', ['menu' => $this->menu, 'logged_in' => '1','change_password_url' =>'admin/change_password']);
//        $this->load->view('profile.php',$data);
        $this->load->view('footer.php');
    }

    public function hospital_registration($id = 0) {
        $foot = [
            'js_files' => ['JS/form/hospital_registration.js'],
        ];
        $data['form_method'] = 'insert';
        $data['form_data'] = [
            'name' => '',
            'dob' => '',
            'email' => '',
            'mobile' => '',
            'gender' => '',
            'status' => '1',
            'house_name' => '',
            'location' => '',
            'district' => '',
            'state' => '',
            'id' => '0',
        ];

        if (!empty($id)) {
            $fields = [
                'table' => 'user',
                'select' => array_keys($data['form_data']),
                'where' => ['id' => $id],
                'where_in' => [],
                'like' => [],
                'group_by' => '',
                'order_by' => '',
                'limit' => [],];
            $result = $this->common->table_details($fields);
            if ($result->num_rows() == 1) {
                $data['form_data'] = $result->row_array();
                $data['form_method'] = 'update';
            }
        }

        $fields = [
            'table' => 'user',
            'select' => array_keys($data['form_data']),
            'where' => ['role' => 'hospital'],
            'where_in' => [],
            'like' => [],
            'group_by' => '',
            'order_by' => '',
            'limit' => [],];
        $data['hospital_datas'] = $this->common->table_details($fields)->result_array();

        $this->load->view('header_site.php', ['menu' => $this->menu, 'logged_in' => '1','change_password_url' =>'admin/change_password']);
        $this->load->view('hospital_registration.php', $data);
        $this->load->view('footer.php', $foot);
    }

    public function hospital_reg_save() {
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
            $this->hospital_registration($id);
            return;
        } else {


            $data = array(
                'email' => $this->input->post('email'),
                'name' => $this->input->post('name'),
                'dob' => $this->input->post('dob'),
                'gender' => $this->input->post('gender'),
                'mobile' => $this->input->post('mobile'),
                'house_name' => $this->input->post('house_name'),
                'location' => $this->input->post('location'),
                'district' => $this->input->post('district'),
                'state' => $this->input->post('state'),
                'status' => $this->input->post('status'),
                'role' => 'hospital',
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
                $response = $this->common->save_table_details('user', $data);
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

///// Donar Management ////////////
    public function donar_registration($id = 0) {
        $foot = [
            'js_files' => ['JS/form/donar_registration.js'],
        ];
        $data['action_page'] = 'admin/donar_reg_save';
        $data['form_method'] = 'insert';
        $data['record_view'] = '1';
        $data['form_data'] = [
            'name' => '',
            'dob' => '',
            'email' => '',
            'mobile' => '',
            'gender' => '',
            'status' => '1',
            'house_name' => '',
            'location' => '',
            'district' => '',
            'state' => '',
            'height' => '',
            'weight' => '',
            'blood_group' => '',
            'blood_donatewilling' => '',
            'health_remark' => '',
            'user_id' => '0',
        ];

        if (!empty($id)) {
            $fields = array(
                'table1' => 'user u',
                'table2' => 'personal_details p',
                'condition2' => 'u.id = p.user_id',
                'join2' => 'inner',
                'select' => '*',
                'where' => ['u.id' => $id],
                'where_in' => [],
                'like' => [],
                'group_by' => '',
                'order_by' => '',
                'limit' => array());
            $result = $this->common->table_details_join($fields);
            if ($result->num_rows() == 1) {
                $data['form_data'] = $result->row_array();
                $data['form_method'] = 'update';
            }
        }

        $fields = [
            'table1' => 'user u',
            'table2' => 'personal_details p',
            'condition2' => 'u.id = p.user_id',
            'join2' => 'inner',
            'select' => ['u.id as id', 'name', 'mobile', 'email', 'gender', 'status'],
            'where' => ['u.role' => 'donar'],
            'where_in' => [],
            'like' => [],
            'group_by' => '',
            'order_by' => '',
            'limit' => []];
        $data['donar_datas'] = $this->common->table_details_join($fields)->result_array();

        $this->load->view('header_site.php', ['menu' => $this->menu, 'logged_in' => '1','change_password_url' =>'admin/change_password']);
        $this->load->view('donar_registration.php', $data);
        $this->load->view('footer.php', $foot);
    }

    public function donar_reg_save() {
        $this->load->helper('mailrahul');   // Extended helper created for mail sending purpose 
        $id = $this->input->post('id');


        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('dob', 'Date Of Birth', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|exact_length[10]|integer');
        $this->form_validation->set_rules('house_name', 'House name', 'required');
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('district', 'District', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('blood_group', 'Blood Group', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->donar_registration($id);
            return;
        } else {


            $data_reg = array(
                'email' => $this->input->post('email'),
                'status' => $this->input->post('status'),
                'role' => 'donar',
            );
            $data_personal = array(
                'name' => $this->input->post('name'),
                'dob' => $this->input->post('dob'),
                'gender' => $this->input->post('gender'),
                'mobile' => $this->input->post('mobile'),
                'house_name' => $this->input->post('house_name'),
                'location' => $this->input->post('location'),
                'district' => $this->input->post('district'),
                'state' => $this->input->post('state'),
                'weight' => $this->input->post('weight'),
                'height' => $this->input->post('height'),
                'blood_group' => $this->input->post('blood_group'),
                'blood_donatewilling' => $this->input->post('blood_donatewilling'),
                'health_remark' => $this->input->post('health_remark'),
            );
            if ($this->input->post('method') == 'insert') {
                //password creation
                $data_reg['password'] = '';
                $alphabets = range('A', 'Z');
                for ($inc = 1; $inc <= 8; $inc++) {
                    $temp = rand(0, 25);
                    $data_reg['password'] .= $alphabets[$temp];
                }
                ///////////////////////////////   
                $insert_id = $this->common->save_table_details('user', $data_reg);
                $data_personal['user_id'] = $insert_id;
                $response = $this->common->save_table_details('personal_details', $data_personal);
                $msg = (empty($response)) ? 'Not able to insert try again' : 'Successfully Inserted';
                if (!empty($response)) {
                    $html = <<<rahul
                 <h4> Account Created</h4>         
                  Username: {$data_reg['email']} </br>
                  Password: {$data_reg['password']} </br>
rahul;
                    getemail($data_reg['email'], 'Login Credentials', $html);
                }
                $this->session->set_flashdata('msg', $msg);
            } else if ($this->input->post('method') == 'update') {
                $where = ['id' => $id];
                $responseuser = $this->common->update_table_details('user', $data_reg, $where);
                $responsepersonal = $this->common->update_table_details('personal_details', $data_personal, ['user_id' => $id]);
                $msg = (empty($responseuser) && empty($responsepersonal)) ? 'Not able to update try again' : 'Successfully Updated';
                $this->session->set_flashdata('msg', $msg);
            }
        }
        redirect('admin/donar_registration');
    }

    public function donar_delete() {

        $id = $this->input->post('id');
        $where = ['id' => $id];
        $response = $this->common->delete_table_details('user', $where);
        $msg = (empty($response)) ? 'Not able to delete try again' : 'Successfully Deleted';
        $this->session->set_flashdata('msg', $msg);
        redirect('admin/donar_registration');
    }

    public function change_password() {
        $this->load->view('header_site.php', ['menu' => $this->menu]);
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
