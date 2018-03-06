<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    var $menu;

    function __construct() {
        parent::__construct();

        $this->load->model('common');
        $this->load->helper('rolemenu');
        $temp = getmenu();
        $this->menu = $temp['menu'];
        $this->menutop = $temp['menutop'];
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
            'status' => '1',
        );
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->login();
        } else {
            $fields = [
                'table' => 'user',
                'select' => '*',
                'where' => $data,
                'where_in' => [],
                'like' => [],
                'group_by' => '',
                'order_by' => '',
                'limit' => [],];
            $result = $this->common->table_details($fields);
            if ($result->num_rows() == 1) {
                $data['USER'] = $result->row_array();
                $this->session->set_userdata($data);
                $this->session->set_userdata(['logged_in' => true]);
                if ($data['USER']['role'] == 'admin') {
                    redirect('admin', 'refresh');
                } elseif ($data['USER']['role'] == 'donar') {
                    redirect('donar', 'refresh');
                } elseif ($data['USER']['role'] == 'hospital') {
                    redirect('hospital', 'refresh');
                } else {
                    $this->session->unset_userdata('USER');
                    $this->session->set_flashdata('msg', 'Something Went wrong');
                    redirect('home/login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('msg', 'Enter Valid Username or Password');
                $this->login();
            }
        }
    }

    ///////////////////////////////////////////////////////////////////////////////
    public function donar_registration($id = 0) {
//        $this->output->enable_profiler(TRUE);
        $foot = [
            'js_files' => ['JS/form/donar_registration.js'],
        ];
        $data['action_page'] = 'home/donar_reg_save';
        $data['form_method'] = 'insert';
        /////// View permission
        $user_data = $this->session->userdata('USER');
        $data['record_view'] = ($user_data['role'] == 'admin') ? 1 : 0;
        if($data['record_view'] == 1){
                        $fields = array(
                'table1' => 'user u',
                'table2' => 'personal_details p',
                'condition2' => 'u.id = p.user_id',
                'join2' => 'inner', 'select' => 'u.*,p.name,p.gender,p.mobile', 'where' => [],
                'where_in' => [], 'like' => [], 'group_by' => '',
                'order_by' => '', 'limit' => array());
            $data['donar_datas'] = $this->common->table_details_join($fields)->result_array();
        }
        ///////////////////////
        $data['form_data'] = [
            'name' => '','dob' => '','email' => '',
            'mobile' => '','gender' => '','status' => '1',
            'house_name' => '','location' => '','district' => '',
            'state' => '','height' => '','weight' => '',
            'blood_group' => '','health_remark' => '','organ' => '',
            'organ_avail' => '',
            'user_id' => '0',
        ];
        $fields = [
            'table' => 'organs', 'select' => '*',
            'where' => [], 'where_in' => [], 'like' => [],
            'group_by' => '', 'order_by' => 'organ', 'limit' => [],];

        $data['organs'] = $this->common->table_details($fields)->result_array();
        if (!empty($id)) {
            $fields = array(
                'table1' => 'user u',
                'table2' => 'personal_details p',
                'condition2' => 'u.id = p.user_id',
                'join2' => 'inner', 'select' => '*', 'where' => ['u.id' => $id],
                'where_in' => [], 'like' => [], 'group_by' => '',
                'order_by' => '', 'limit' => array());
            $result = $this->common->table_details_join($fields);
            if ($result->num_rows() == 1) {
                $data['form_data'] = $result->row_array();
                ///////// organ /////////
                $fields = [
                    'table' => 'donar_organs', 'select' => '*',
                    'where' => ['user_id' => $id], 'where_in' => [], 'like' => [],
                    'group_by' => '', 'order_by' => '', 'limit' => [],];

                $temp = $this->common->table_details($fields)->result_array();
                $data['form_data']['organs'] = (!empty($temp)) ? array_column($temp, 'organ_id', 'id') : [];
                $data['form_data']['organs_avail'] = (!empty($temp)) ? array_column($temp, 'status', 'id') : [];
                ///////////////////////
                $data['form_method'] = 'update';
            }
        }

        $this->load->view('header_site.php', ['menu' => $this->menu]);
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
                'health_remark' => $this->input->post('health_remark'),
            );
            $organs = $this->input->post('organ');
            $organ_avail = $this->input->post('organ_avail');

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

                //Organ Management
                foreach ($organs as $organ_id) {
                    $aviltemp = (!empty($organ_avail[$organ_id])) ? '1' : '0';
                    $organ_details = array(
                        'user_id' => $data_personal['user_id'],
                        'organ_id' => $organ_id,
                        'status' => $aviltemp,
                    );
                    $this->common->save_table_details('donar_organs', $organ_details);
                }
                ////////////////////////////////
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
                // Organ      
                $organ_ids=[];
                foreach ($organs as $organ_id) {
                                    $fields = [
                    'table' => 'donar_organs', 'select' => 'id',
                    'where' => ['user_id' => $id,'organ_id'=>$organ_id], 'where_in' => [], 'like' => [],
                    'group_by' => '', 'order_by' => '', 'limit' => [],];

                $temp_donar_organ = $this->common->table_details($fields)->row_array();
                
                /////////////////////////
                    $aviltemp = (!empty($organ_avail[$organ_id])) ? '1' : '0';
                    $organ_details = array(
                        'user_id' => $id,
                        'organ_id' => $organ_id,
                        'status' => $aviltemp,
                    );
                    if(empty($temp_donar_organ['id'])){
                    $organ_ids[]=$this->common->save_table_details('donar_organs', $organ_details);
                    }else{
                        $organ_ids[] = $temp_donar_organ['id'];
                     $this->common->update_table_details('donar_organs', $organ_details, ['id' => $temp_donar_organ['id']]);   
                    }
                }
                if(!empty($organ_ids)){
                    $where =['id' => '1'];
                   $this->common->delete_table_details('donar_organs', $where); 
                }
                /////////////////////
                $msg = (empty($responseuser) && empty($responsepersonal)) ? 'Not able to update try again' : 'Successfully Updated';
                $this->session->set_flashdata('msg', $msg);
            }
        }
        redirect('home/donar_registration');
    }

    public function donar_delete() {

        $id = $this->input->post('id');
        $where = ['id' => $id];
        $response = $this->common->delete_table_details('user', $where);
        $msg = (empty($response)) ? 'Not able to delete try again' : 'Successfully Deleted';
        $this->session->set_flashdata('msg', $msg);
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
        $this->load->helper('mailrahul');
        $data = array(
            'email' => $this->input->post('email'),
        );
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->forget_password();
            return;
        } else {
            $fields = [
                'table' => 'user',
                'select' => 'id',
                'where' => $data,
                'where_in' => [],
                'like' => [],
                'group_by' => '',
                'order_by' => '',
                'limit' => [],];
            $response = $this->common->table_details($fields);

            if ($response->num_rows() == 1) {
                $user = $response->row_array();
                //password creation
                $data_reg['password'] = '';
                $alphabets = range('A', 'Z');
                for ($inc = 1; $inc <= 8; $inc++) {
                    $temp = rand(0, 25);
                    $data_reg['password'] .= $alphabets[$temp];
                }
                ///////////////////////////////   
                $where = ['id' => $user['id']];
                $responseuser = $this->common->update_table_details('user', $data_reg, $where);
                if ($responseuser) {
                    $html = <<<rahul
                 <h4> Password Reset </h4>         
                  Username: {$data['email']} </br>
                  Password: {$data_reg['password']} </br>
rahul;
                    getemail($data['email'], 'Password Reset', $html);
                }
            }
            $msg = (empty($responseuser)) ? 'Not Able to Reset Password!! Try Again' : 'Password is updated!!! Check Your Mail';
            $this->session->set_flashdata('msg', $msg);
            redirect('home/forget_password', 'refresh');
        }
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
