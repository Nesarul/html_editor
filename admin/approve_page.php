<?php
    require_once('function.php');
    if(isset($_POST['id']) && !empty($_POST['id']))
    {
        pages::getInstance()->approvePage($_POST['id']);
        echo json_encode("Success");
    }