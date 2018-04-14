<?php

Class Sort extends CI_Model {

 
    public function getnotadded($pid,$oid) {

         $query ="SELECT * FROM donar_organs D 
                INNER JOIN personal_details PD on PD.user_id = D.user_id
                LEFT JOIN 
                (SELECT * FROM requested_donar WHERE request_id = '$pid' ) RD ON RD.donar_id = D.user_id
                WHERE D.status = '1' AND  D.organ_id='$oid' AND RD.id IS NULL
                GROUP BY D.user_id";
        return $this->db->query($query);
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
