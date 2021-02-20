<?php
    require_once('../admin/db/db.php');
    if(isset($_POST["id"]) && trim($_POST["val"]) != "")
    {
        $res = db::getInstance()->update('unit',array('unit_id'=>$_POST["id"]),array($_POST['type'] == 'n' ? 'unit_name' : 'unit_title'=>$_POST["val"]));
        echo json_encode($res);
    }