<?php
include 'process_common.php';
$table_name = 'parking_slots';
$where['id'] = trim($_POST['id']);
$field_values['slot_name'] = trim($_POST['slot_name']);
$field_values['vehicle_type'] = trim($_POST['vehicle_type']);
$field_values['parking_area_id'] = trim($_POST['parking_area_id']);
$field_values['status'] = (isset($_POST['status'])) ? $_POST['status'] : 0;

$method = $_POST['method'];



// INSERT
if ($method == 'insert') {

    $result = $query->insert($table_name, $field_values);    
    if (!empty($result)) {
            $_SESSION['MSG'] = 'Successfully inserted ';
 
    } else {
        $_SESSION['MSG'] = 'Not Inserted!!! Please try again';
    }
}



// Update
if ($method == 'update') {

    $result = $query->update($table_name, $field_values, $where);
    if (!empty($result)) {
        $_SESSION['MSG'] = 'Successfully Updated';
    } else {
        $_SESSION['MSG'] = 'Somethng went wrong!!! Please try again';
    }
}

//Delete
if ($method == 'delete') {

    $result = $query->delete($table_name,$where);
    if (!empty($result)) {
        $_SESSION['MSG'] = 'Successfully Record Deleted';
    } else {
        $_SESSION['MSG'] = 'Somethng went wrong!!! Please try again';
    }
}
        header("location:../slot_management.php");