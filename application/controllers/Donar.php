<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Donar extends CI_Controller {

    var $menu, $menutop;

    function __construct() {
        parent::__construct();
//        $this->output->enable_profiler(TRUE);
        $this->load->model('common');

        $this->load->helper('rolemenu');
        $temp = getmenu();
        $this->menu = $temp['menu'];
        $this->menutop = $temp['menutop'];

        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('msg', 'Please Login');
            redirect('home', 'refresh');
        }
    }

    public function index() {
        $data['form_data'] = [
            'name' => '','dob' => '','email' => '',
            'mobile' => '','gender' => '','status' => '1',
            'house_name' => '','location' => '','district' => '',
            'state' => '','height' => '','weight' => '',
            'blood_group' => '','health_remark' => '','organs' => [],
            'organ_avail' => [],
            'user_id' => '0',
        ];
        $userdata = $this->session->userdata('USER'); 
        $id = $userdata['id']; 
        
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
               
                $data['form_data']['organs'] = (!empty($temp)) ? array_column($temp,'organ_id') : [];
//                print_r($data['form_data']['organs']);die();
                $data['form_data']['organs_avail'] = (!empty($temp)) ? array_column($temp, 'status', 'organ_id') : [];
                ///////////////////////
                $data['form_method'] = 'update';
            }    
            
        $this->load->view('header_site.php', ['menu' => $this->menu, 'menutop' => $this->menutop]);
        $this->load->view('profile_donar.php',$data);
        $this->load->view('footer.php');
    }
   public function profile_update() {
//                $this->output->enable_profiler(TRUE);
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
            $this->index();
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
            
                $where = ['id' => $id];
                $responseuser = $this->common->update_table_details('user', $data_reg, $where);
                $responsepersonal = $this->common->update_table_details('personal_details', $data_personal, ['user_id' => $id]);
                // Organ      
                $fields = [
                    'table' => 'donar_organs', 'select' => '*',
                    'where' => ['user_id' => $id], 'where_in' => [], 'like' => [],
                    'group_by' => '', 'order_by' => '', 'limit' => [],];

                $all_donororgan = $this->common->table_details($fields)->result_array();
                $all_donororgan = (!empty($all_donororgan)) ? array_column($all_donororgan, "id", "organ_id") : [];

                foreach ($organs as $organ_id => $val) {

                    /////////////////////////
                    $aviltemp = (isset($organ_avail[$organ_id])) ? '1' : '0';
                    $organ_details = array(
                        'user_id' => $id,
                        'organ_id' => $organ_id,
                        'status' => $aviltemp,
                    );
                    if (array_key_exists($organ_id, $all_donororgan)) {
                        $this->common->update_table_details('donar_organs', $organ_details, ['id' => $all_donororgan[$organ_id]]);
                        unset($all_donororgan[$organ_id]);
                    } else {
                        $this->common->save_table_details('donar_organs', $organ_details);
                    }
                }
                if (!empty($all_donororgan)) {
                    foreach ($all_donororgan as $organ_id) {
                        $where = ['id' => $organ_id];
                        $this->common->delete_table_details('donar_organs', $where);
                    }
                }
                /////////////////////
                $msg = (empty($responseuser) && empty($responsepersonal)) ? 'Not able to update try again' : 'Successfully Updated';
                $this->session->set_flashdata('msg', $msg);
        }
        redirect('donar/index');
    }
}
