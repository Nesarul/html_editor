<?php
require_once('./db/db.php');
require_once('function.php');
if(isset($_POST['id']) && !empty($_POST['id']))
{
    db::getInstance()->update('users',array('user_id'=>$_POST['id']),array('user_permission'=>$_POST['perm']));
    $x = "Record change Successfuly";
    echo json_encode($x);
}