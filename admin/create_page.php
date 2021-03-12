<?php
    require_once('./db/db.php');
    require_once('./function.php');
    setTimezone();
    $response = array(
        'Status' => 0,
        'Message' => ''
    );
    if(isset($_POST['page_name']) && !empty($_POST['page_name'])){
        pages::getInstance()->pageCreate($_POST['page_course_id'],$_POST['page_unit_id'],$_POST['page_name'],$_POST['page_caption'],$_POST['status'],$_POST['approved']);
        $response['Message'] = "Successful";
    }    
    echo json_encode($response);