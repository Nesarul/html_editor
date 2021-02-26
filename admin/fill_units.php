<?php
    require_once('function.php');
    if(isset($_POST["course"]) && !empty($_POST['course']))
    {
        $x = unit::getInstance()->getUnits( $_POST['course']);
        echo json_encode($x);
    }