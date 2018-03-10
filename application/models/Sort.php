<?php

Class Sort extends CI_Model {

 
    public function ajax_request($data) {
        $query ="
            SELECT * FROM patient_request PR
INNER JOIN donar_organs D ON D.organ_id = PR.organ_id
LEFT JOIN requested_donar RD ON RD.request_id = PR.id
WHERE RD.id IS NULL
GROUP BY D.id";
        return;  $this->db->query($query);
    }
    
   
}

?>
