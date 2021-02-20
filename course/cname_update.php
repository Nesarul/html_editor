<?php
    require_once('../admin/db/db.php');
    //id:newID,val:newText
    if(isset($_POST["id"]) && trim($_POST["val"]) != "")
    {
        $res = db::getInstance()->query("UPDATE	course SET course_name = ? WHERE course_id = ?",$params = array($_POST["val"],$_POST['id']))->getResults();
        echo json_encode($res);
    }