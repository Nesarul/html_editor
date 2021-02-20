<?php
require_once('./db/db.php');

if(isset($_POST["uid"]) && trim($_POST["uid"]) != "")
{
    $uid = $_POST['uid'];
    $sql = $_POST['val'];

    $first_name         = $_POST['first_name'];
    $last_name          = $_POST['last_name'];
    $login_id           = $_POST['login_id'];
    $user_email         = $_POST['user_email'];
    $pass               = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $phone              = $_POST['phone'];
    $user_type          = $_POST['user_type'];
    $user_permission    = $_POST['user_permission'];
    $conf_pass          = $_POST['conf_pass'];
  
    db::getInstance()->update('users',array('user_id'=>$uid),array('user_first_name'=> $first_name,'user_last_name'=> $last_name,'user_login_name'=> $login_id,'user_email'=> $user_email,'user_pass'=> $pass,'user_phone'=> $phone,'user_type'=> $user_type,'user_permission'=> $user_permission));
}