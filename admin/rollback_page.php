<?php
    require_once('function.php');
    $response = array(
        'status' => '0',
        'message' => "null"
    );
    if(isset($_POST['id']) && !empty($_POST['id']))
    {
        if($data->type == '1'){
            pages::getInstance()->rollbackPage($_POST['id']);
            $response['message'] = "Succssful";
        }else{
            $response['message'] = "Only Administrator can Rollback a course.";
        }
    }

    echo json_encode($response);