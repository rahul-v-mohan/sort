<?php

Class Sort extends CI_Model {

 
    public function getnotadded($oid) {

        $this->db->select(" UR.*");
        $this->db->from("patient_request PR ");
        $this->db->join('donar_organs D', 'PR.organ_id  = D.organ_id ','inner');
        $this->db->join('personal_details UR', 'UR.user_id = D.user_id ','inner');
        $this->db->join('requested_donar RD', 'RD.request_id = PR.id ','left');
        $this->db->where('D.status = "1" AND PR.organ_id = "'.$oid.'" AND RD.id IS null', NULL, FALSE);
        $this->db->group_by('D.user_id'); 
        return $this->db->get();
    }
    public function getadded($pid) {

        $this->db->select(" UR.*, RD.status ,RD.id as requesteddonar_id");
        $this->db->from("patient_request PR ");
        $this->db->join('requested_donar RD', 'RD.request_id = PR.id ','inner');
        $this->db->join('personal_details UR', 'UR.user_id = RD.donar_id ','inner');
        $this->db->where(['PR.id' => $pid]);
        return $this->db->get();
    }
    
   
}
