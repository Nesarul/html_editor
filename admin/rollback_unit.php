<?php
    require_once('./db/db.php');
    require_once('function.php');
    $response = array(
        'status' => '0',
        'message' => "null"
    );
    if(isset($_POST['id']) && !empty($_POST['id']))
    {
        if($data->type == '1'){
            db::getInstance()->update('unit',array('unit_id'=>$_POST['id']),array('unit_status'=>'0','unit_approved_by'=>'0'));
            $response['message'] = "Succssful";
        }else{
            $response['message'] = "Only Administrator can Rollback a course.";
        }
    }

    echo json_encode($response);