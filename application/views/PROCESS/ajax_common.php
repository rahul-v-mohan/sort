<?php

include 'process_common.php';

(!empty($_REQUEST['request'])) or die('Sorry');

switch ($_REQUEST['request']) {
    case 'search_slot':
        search_slot();
        break;
    default:
        echo json_encode(array());
        exit(0);
        break;
}

function search_slot() {
    global $query;
    $response['result']='0';
    
    $location = $_POST['location'];
    $vehicle_type = $_POST['vehicle_type'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    
    $result = $query->search_slot($location,$vehicle_type,$date,$start_time,$end_time);
    while ($row = mysqli_fetch_assoc($result)) {
        $response['data'][] = $row;
    }
    if(!empty($result)){
        $response['result']='1';
    }
    echo json_encode($response);
}
