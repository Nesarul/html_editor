<?php
    require_once('./db/db.php');
    if(isset($_POST["uid"]) && trim($_POST["uid"]) != "")
    {

        $res = db::getInstance()->query("SELECT * FROM users WHERE user_id = ? ",$params=array($_POST['uid']))->getResults();
        echo json_encode($res);
    }
    else
        echo "Error!";