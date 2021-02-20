<?php
    require_once('../admin/db/db.php');
    $response = array( 
        'status' => 0, 
        'message' => 'Form submission failed, please try again.' 
    ); 

    $sql = "SELECT unit_status FROM unit WHERE unit_id = ? AND course_id = ?";
    $res = db::getInstance()->query($sql,$params=array($_POST['id'],$_POST['course']))->getResults();

    $response['message'] = $res[0]->unit_status != "0" ? '1': '0';
    echo json_encode($response);