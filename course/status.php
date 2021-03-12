<?php
    require_once('../admin/function.php');
    $response = array( 
        'status' => 0, 
        'message' => 'Form submission failed, please try again.' 
    ); 
    $res = pages::getInstance()->getPageStatus($_POST['id']);
    $response['message'] = $res[0]->page_status != "0" ? '1': '0';
    echo json_encode($response);