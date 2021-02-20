<?php
    require_once('./db/db.php');
    $response = array(
        'message'           => "Success",
        'user_id'           => null,
        'user_first_name'   => null,
        'user_last_name'    => null,
        'user_email'        => null,
        'user_login_name'   => null,
        'user_phone'        => null,
        'user_permission'   => null,
        'user_type'         => null,
        'date_join'         => null,
        'info_user_image'   => null
    );
    if(isset($_POST['id']) && $_POST['id'] != null)
    {
        $res = db::getInstance()->get('users',array('user_id','=',$_POST['id']))->getResults();
        $response['user_id']            = $res[0]->user_id; 
        $response['user_first_name']    = $res[0]->user_first_name; 
        $response['user_last_name']     = $res[0]->user_last_name; 
        $response['user_email']         = $res[0]->user_email; 
        $response['user_login_name']    = $res[0]->user_login_name; 
        $response['user_phone']         = $res[0]->user_phone; 
        $response['user_permission']    = $res[0]->user_permission; 
        $response['user_type']          = $res[0]->user_type; 
        $response['date_join']          = $res[0]->date_join; 
        $response['info_user_image']    = $res[0]->user_image; 
    }
    echo json_encode($response);