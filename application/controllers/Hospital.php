<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hospital extends CI_Controller {

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
//        $data['profile'] = $this->session->userdata('USER'); 

        $this->load->view('header_site.php', ['menu' => $this->menu, 'top_menu' => $this->menutop]);
//        $this->load->view('profile.php',$data);
        $this->load->view('footer.php');
    }

    public function patient_registration($id = 0) {
        $user_data = $this->session->userdata('USER');
        $hopital_id = 0;
        /////////////////////////////////////
        $data['hospital_datas'] = [];
        $data['organ_allstatus'] = [1 => 'requested', 2 => 'closed'];
        if ($user_data['role'] == 'hospital') {
            $data['hospital_datas'] = [$user_data['id'] => $user_data['hospital_name']];
        }
        if ($user_data['role'] == 'admin') {
            $fields = array(
                'table1' => 'user u',
                'table2' => 'hospital h',
                'condition2' => 'u.id = h.user_id',
                'join2' => 'inner',
                'select' => 'u.id,h.hospital_name',
                'where' => ['u.status' => 1],
                'where_in' => [], 'like' => [], 'group_by' => '',
                'order_by' => '', 'limit' => array());
            $data['hospital_datas'] = $this->common->table_details_join($fields)->result_array();
            $data['hospital_datas'] = (!empty($data['hospital_datas'])) ? array_column($data['hospital_datas'], 'hospital_name', 'id') : [];
        }
        ////////////////////////////////////
        ////////////////Organ////////////////////
        $fields = [
            'table' => 'organs', 'select' => '*',
            'where' => [], 'where_in' => [], 'like' => [],
            'group_by' => '', 'order_by' => 'organ', 'limit' => [],];

        $data['organs'] = $this->common->table_details($fields)->result_array();
        ////////////////////////////////////
        $foot = [
            'js_files' => [],
        ];
        $data['form_method'] = 'insert';
        $data['form_data'] = [
            'patient_name' => '', 'dob' => '', 'mobile' => '',
            'health_conditon' => '', 'gender' => '', 'hospital_id' => '',
            'patient_id' => '', 'organs' => [], 'organ_status' => [],
            'id' => '0',
        ];

        $fields = array(
            'table1' => 'hosital_patient p',
            'table2' => 'hospital h',
            'condition2' => 'p.hospital_id = h.user_id',
            'join2' => 'inner',
            'select' => 'p.*,h.hospital_name',
            'where' => [],
            'where_in' => [], 'like' => [], 'group_by' => '',
            'order_by' => '', 'limit' => array());
        $fields['where'] = ($user_data['role'] == 'hospital') ? [] : [];
        $data['patient_datas'] = $this->common->table_details_join($fields)->result_array();
        if (!empty($id)) {
            $fields = [
                'table' => 'hosital_patient',
                'select' => '*', 'where' => ['id' => $id],
                'where_in' => [], 'like' => [],
                'group_by' => '', 'order_by' => '',
                'limit' => [],];

            $result = $this->common->table_details($fields);
            if ($result->num_rows() == 1) {
                $data['form_data'] = $result->row_array();
                ///////// organ /////////
                $fields = [
                    'table' => 'patient_request', 'select' => '*',
                    'where' => ['patient_id' => $id], 'where_in' => [], 'like' => [],
                    'group_by' => '', 'order_by' => '', 'limit' => [],];

                $temp = $this->common->table_details($fields)->result_array();

                $data['form_data']['organs'] = (!empty($temp)) ? array_column($temp, 'organ_id') : [];
                $data['form_data']['organ_status'] = (!empty($temp)) ? array_column($temp, 'status', 'organ_id') : [];

                $data['form_method'] = 'update';
            }
        }


        $this->load->view('header_site.php', ['menu' => $this->menu, 'top_menu' => $this->menutop]);
        $this->load->view('patient_registration.php', $data);
        $this->load->view('footer.php', $foot);
    }

    public function patient_reg_save() {
        $id = $this->input->post('id');


        $this->form_validation->set_rules('patient_name', 'Patient Name', 'required');
        $this->form_validation->set_rules('patient_id', 'Patient ID', 'required');
        $this->form_validation->set_rules('hospital_id', 'Hospital id', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|exact_length[10]|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->patient_registration($id);
            return;
        } else {


            $data = array(
                'patient_id' => $this->input->post('patient_id'),
                'patient_name' => $this->input->post('patient_name'),
                'mobile' => $this->input->post('mobile'),
                'gender' => $this->input->post('gender'),
                'dob' => $this->input->post('dob'),
                'health_conditon' => $this->input->post('health_conditon'),
                'hospital_id' => $this->input->post('hospital_id'),
            );
            $organs = $this->input->post('organ');
            $organ_status = $this->input->post('organ_status');


            if ($this->input->post('method') == 'insert') {
                $insert_id = $this->common->save_table_details('hosital_patient', $data);
                //Organ Management
                foreach ($organs as $organ_id => $val) {
                    $aviltemp = (!empty($organ_status[$organ_id])) ? $organ_status[$organ_id] : '0';
                    $organ_details = array(
                        'patient_id' => $insert_id,
                        'organ_id' => $organ_id,
                        'status' => $aviltemp,
                    );
                    $this->common->save_table_details('patient_request', $organ_details);
                }
                ////////////////////////////////

                $msg = (empty($insert_id)) ? 'Not able to insert try again' : 'Successfully Inserted';
                $this->session->set_flashdata('msg', $msg);
            } else if ($this->input->post('method') == 'update') {
                $where = ['id' => $id];
                $response = $this->common->update_table_details('hosital_patient', $data, ['id' => $id]);
                // Organ      
                $fields = [
                    'table' => 'patient_request', 'select' => '*',
                    'where' => ['patient_id' => $id], 'where_in' => [], 'like' => [],
                    'group_by' => '', 'order_by' => '', 'limit' => [],];

                $all_donororgan = $this->common->table_details($fields)->result_array();
                $all_donororgan = (!empty($all_donororgan)) ? array_column($all_donororgan, "id", "organ_id") : [];

                foreach ($organs as $organ_id => $val) {

                    /////////////////////////
                    $aviltemp = (isset($organ_status[$organ_id])) ? $organ_status[$organ_id] : '0';
                    $organ_details = array(
                        'patient_id' => $id,
                        'organ_id' => $organ_id,
                        'status' => $aviltemp,
                    );
                    if (array_key_exists($organ_id, $all_donororgan)) {
                        $this->common->update_table_details('patient_request', $organ_details, ['id' => $all_donororgan[$organ_id]]);
                        unset($all_donororgan[$organ_id]);
                    } else {
                        $this->common->save_table_details('patient_request', $organ_details);
                    }
                }
                if (!empty($all_donororgan)) {
                    foreach ($all_donororgan as $organ_id) {
                        $where = ['id' => $organ_id];
                        $this->common->delete_table_details('patient_request', $where);
                    }
                }
                /////////////////////
                $msg = (empty($response)) ? 'Not able to update try again' : 'Successfully Updated';
                $this->session->set_flashdata('msg', $msg);
            }
        }
        redirect('hospital/patient_registration');
    }

    public function patient_delete() {

        $id = $this->input->post('id');
        $where = ['id' => $id];
        $this->common->delete_table_details('user', $where);
        redirect('hospital/patient_registration');
    }

///////////////// Request Management ///////////////////////////////////
    public function request_interface($id = 0) {
        $foot = [
            'js_files' => ['JS/form/request_interface.js'],
        ];
        $data['form_data']['id'] = $id;
        $fields = array(
            'table1' => 'hosital_patient p',
            'table2' => 'patient_request r',
            'table3' => 'organs o',
            'condition2' => 'r.patient_id = p.id',
            'condition3' => 'r.organ_id = o.id',
            'join2' => 'inner',
            'join3' => 'inner',
            'select' => 'p.patient_name,r.*,o.organ',
            'where' => ['r.status' => '1'],
            'where_in' => [], 'like' => [], 'group_by' => '',
            'order_by' => '', 'limit' => array());

        $data['patients'] = $this->common->table_details_join_three($fields)->result_array();

        $this->load->view('header_site.php', ['menu' => $this->menu, 'top_menu' => $this->menutop]);
        $this->load->view('request_interface.php', $data);
        $this->load->view('footer.php', $foot);
    }

    public function ajax_request() {
        $this->load->model('sort');
        $response = [];
        $request_id = $this->input->post('request_id');
        $organ_id = $this->input->post('organ_id');
        $response['notadded'] = $this->sort->getnotadded($organ_id)->result_array();
        $response['added'] = $this->sort->getadded($request_id)->result_array();
//        echo $this->db->last_query();
        echo json_encode($response);
    }

    public function request_process_add() {

        $patient_request_id = $this->input->post('patient_request_id');
        $patient_request_id = explode("-", $patient_request_id);
        $patient_request_id = $patient_request_id[0];

        $donar_request = $this->input->post('donar_request');
        $requested_date = $this->input->post('requested_date');
//        var_dump($requested_date); die();

        foreach ($donar_request as $donar =>$exist) {

            $data = array(
                'request_id' => $patient_request_id,
                'donar_id' => $donar,
                'requested_date' => $requested_date[$donar],
                'status' => 0,
            );
            $insert_id = $this->common->save_table_details('requested_donar', $data);
        }
        $msg = (empty($insert_id)) ? 'Not able to insert try again' : 'Successfully Inserted';
        $this->session->set_flashdata('msg', $msg);

        redirect('hospital/request_interface/'.$patient_request_id);
    }

}
