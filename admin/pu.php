<?php
    require_once('./db/db.php');
    require_once('./function.php');

    if(isset($_POST['old_pass']) && trim($_POST['old_pass']))
    {
        if(isset($_POST['new_pass']) && trim($_POST['new_pass']) 
            && isset($_POST['conf_new_pass']) && trim($_POST['conf_new_pass']))
        { 
            $res = db::getInstance()->get('users',array('user_id','=',$data->user_id))->getResults();

            // first check both new Password is correct; 
            if(0 != strcmp($_POST['new_pass'],$_POST['conf_new_pass']))
            {
                echo "Password & Confirm Password not matched. ";
                exit(0);
            }
            else
            {
                // Verify Old Password.
                if(password_verify($_POST['old_pass'], $res[0]->user_pass))
                {
                    db::getInstance()->update('users',array('user_id'=>$data->user_id),array('user_pass'=>password_hash($_POST['new_pass'], PASSWORD_DEFAULT)));
                    session_destroy();
                    $data->logStatus = "logout";
                    header("Location: ../index.php");
                    exit;
                }
                else
                {
                    echo "Old Password is not correct!";
                    exit(0);
                }
            }
        }
    }