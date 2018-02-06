<?php

Class Common extends CI_Model {

    function save_table_details($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function table_details($data) {
        $this->db->select($data['select'], FALSE);
        $this->db->where($data['where']);
        $this->db->where($data['where_in']);
        $this->db->like($data['like']);
        $this->db->group_by($data['group_by']);
        if ($data['order_by'])
            $this->db->order_by($data['order_by']);
        if (!empty($data['limit']))
            $this->db->limit($data['limit']['count'], $data['limit']['start']);
        return $this->db->get($data['table']);
    }

    function update_table_details($table, $data, $where) {
        return $this->db->update($table, $data, $where);
    }

    function delete_table_details($table, $where) {
        $this->db->where($where);
        return $this->db->delete($table);
    }

    function delete_table_multiple($table, $where) {
        $this->db->where_in($where);
        return $this->db->delete('$table');
    }

    public function table_details_join($data) {
        $this->db->select($data['select'], FALSE);
        $this->db->where($data['where']);
        $this->db->where($data['where_in']);
        $this->db->like($data['like']);
        $this->db->group_by($data['group_by']);
        if ($data['order_by'])
            $this->db->order_by($data['order_by']);
        if (!empty($data['limit']))
            $this->db->limit($data['limit']['count'], $data['limit']['start']);
        $this->db->from($data['table1']);
        $this->db->join($data['table2'], $data['condition2'], $data['join2']);
        return $this->db->get();
    }

    public function table_details_join_four($data) {
        $this->db->select($data['select'], FALSE);
        $this->db->where($data['where']);
        $this->db->where($data['where_in']);
        $this->db->like($data['like']);
        $this->db->group_by($data['group_by']);
        if ($data['order_by'])
            $this->db->order_by($data['order_by']);
        if (!empty($data['limit']))
            $this->db->limit($data['limit']['count'], $data['limit']['start']);
        $this->db->from($data['table1']);
        $this->db->join($data['table2'], $data['condition2'], $data['join2']);
        $this->db->join($data['table3'], $data['condition3'], $data['join3']);
        $this->db->join($data['table4'], $data['condition4'], $data['join4']);
        return $this->db->get();
    }
    
    public function table_details_join_five($data) {
        $this->db->select($data['select'], FALSE);
        $this->db->where($data['where']);
        $this->db->where($data['where_in']);
        $this->db->like($data['like']);
        $this->db->group_by($data['group_by']);
        if ($data['order_by'])
            $this->db->order_by($data['order_by']);
        if (!empty($data['limit']))
            $this->db->limit($data['limit']['count'], $data['limit']['start']);
        $this->db->from($data['table1']);
        $this->db->join($data['table2'], $data['condition2'], $data['join2']);
        $this->db->join($data['table3'], $data['condition3'], $data['join3']);
        $this->db->join($data['table4'], $data['condition4'], $data['join4']);
        $this->db->join($data['table5'], $data['condition5'], $data['join5']);
        return $this->db->get();
    }

    public function table_details_join_three($data) {
        $this->db->select($data['select'], FALSE);
        $this->db->where($data['where']);
        $this->db->where($data['where_in']);
        $this->db->like($data['like']);
        $this->db->group_by($data['group_by']);
        if ($data['order_by'])
            $this->db->order_by($data['order_by']);
        if (!empty($data['limit']))
            $this->db->limit($data['limit']['count'], $data['limit']['start']);
        $this->db->from($data['table1']);
        $this->db->join($data['table2'], $data['condition2'], $data['join2']);
        $this->db->join($data['table3'], $data['condition3'], $data['join3']);
        return $this->db->get();
    }
    
   
}

?>
