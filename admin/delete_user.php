<?php
    require_once('function.php');
    if(isset($_POST['id']) && !empty($_POST['id']))
    {
        // First of all check The commander is an Administrator. 
        if($data->type != 1)
            exit(0);
        sort_unit::getInstance()->delete(array('s_u_id','=',$_POST['id']));
        unit::getInstance()->delete(array('unit_sme','=',$_POST['id']));
        couorse::getInstance()->delete(array('sme','=',$_POST['id']));
        users::getInstance()->delete(array('user_id','=',$_POST['id']));
        echo json_encode("User deleted Successfuly");
    }