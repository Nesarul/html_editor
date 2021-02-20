<?php
    require_once('./db/db.php');
    require_once('function.php');
    if(isset($_POST['id']) && !empty($_POST['id']))
    {
        // First of all check The commander is an Administrator. 
        if($data->type != 1)
            exit(0);
       
        db::getInstance()->delete('sort_unit',array('s_u_id','=',$_POST['id']));
        db::getInstance()->delete('unit',array('unit_sme','=',$_POST['id']));
        db::getInstance()->delete('course',array('sme','=',$_POST['id']));
        db::getInstance()->delete('users',array('user_id','=',$_POST['id']));
        echo json_encode("User deleted Successfuly");
    }