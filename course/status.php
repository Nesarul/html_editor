<?php
    require_once('../admin/function.php');
    $response = array( 
        'status' => 0, 
        'message' => 'Form submission failed, please try again.' 
    ); 
    $res = unit::getInstance()->getStatus($_POST['id']);
    $response['message'] = $res[0]->unit_status != "0" ? '1': '0';
    echo json_encode($response);