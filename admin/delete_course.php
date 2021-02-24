<?php
    require_once('function.php');
    if(isset($_POST['id']) && !empty($_POST['id']))
    {
        sort_unit::getInstance()->delete(array('c_id','=',$_POST['id']));
        unit::getInstance()->delete(array('course_id','=',$_POST['id']));
        course::getInstance()->delete($_POST['id']);
        echo json_encode("Record deleted Successfuly");
    }