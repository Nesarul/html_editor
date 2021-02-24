<?php
    require_once('function.php');
    if(isset($_POST['id']) && !empty($_POST['id']))
    {
        sort_unit::getInstance()->delete(array('u_id',"=",$_POST['id']));
        unit::getInstance()->delete(array('unit_id','=',$_POST['id']));
        echo json_encode("Record deleted Successfuly");
    }