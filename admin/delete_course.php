<?php
    require_once('./db/db.php');
    require_once('function.php');
    if(isset($_POST['id']) && !empty($_POST['id']))
    {
        if(course::getInstance()->delete($_POST['id']))
            echo json_encode("Record deleted Successfuly");
    }