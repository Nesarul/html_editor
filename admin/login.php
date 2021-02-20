<?php
require_once('./db/db.php');
require_once('./function.php');

if(isset($_POST["log_id"]) && trim($_POST["log_id"]) != "")
{
    $res = db::getInstance()->get('users',array('user_login_name','=',$_POST["log_id"]))->getResults();
    if(!$res)
    {
        header("Location: ../index.php?l=i"); 
        exit();
    }else{      // User ID found
        $hash = $res[0]->user_pass;
        if(password_verify($_POST['pass'], $hash)) {
            if($res[0]->user_permission != 0){
                $data->user     = $res[0]->user_first_name." ".$res[0]->user_last_name;
                $data->user_id  = $res[0]->user_id;
                $data->perm     = $res[0]->user_permission;
                $data->email    = $res[0]->user_email;
                $data->image    = $res[0]->user_image;
                $data->type     = $res[0]->user_type;
                $data->logStatus = "logged";
                header("Location: ../dashboard/index.php");
            }else{
                header("Location: ../index.php?l=v");
                exit(0);
            }
        } else {
            header("Location: ../index.php?l=i");
            exit();
        }
    }

    $data->log_id = $_POST["log_id"];
    $data->pass = $_POST["pass"];
}else{
    header("Location: ../index.php?l=i");
    exit();
}