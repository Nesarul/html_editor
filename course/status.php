<?php
    require_once('../admin/db/db.php');
    $response = array( 
        'status' => 0, 
        'message' => 'Form submission failed, please try again.' 
    ); 
    $res = db::getInstance()->get('unit',array('unit_id','=',$_POST['id']))->getResults();
    
    $response['message'] = $res[0]->unit_status != "0" ? '1': '0';
    echo json_encode($response);