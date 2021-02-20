<?php
    require_once('./db/db.php');
    require_once('function.php');
    if(isset($_POST['id']) && !empty($_POST['id']))
    {
        db::getInstance()->delete(sort_unit,array('u_id',"=",$_POST['id']));
        db::getInstance()->delete(unit,array('unit_id','=',$_POST['id']));
        echo json_encode("Record deleted Successfuly");
    }