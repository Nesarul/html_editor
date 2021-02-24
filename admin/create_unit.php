<?php
    require_once('./db/db.php');
    require_once('./function.php');
    setTimezone();
    $response = array(
        'status' => "0",
        'Message' => "Something Wrong Happen"
    );
    if(isset($_POST['course']))
    {
        unit::getInstance()->createUnit($_POST['unit'],$_POST['course'],$_POST['sme'],$_POST['pt']);
        $response['Message']="Success";
    }
    echo json_encode($response);