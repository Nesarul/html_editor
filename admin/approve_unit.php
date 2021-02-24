<?php
    require_once('function.php');
    if(isset($_POST['id']) && !empty($_POST['id']))
    {
        $unitId = $_POST['id'];
        unit::getInstance()->approveUnit($unitId);
        echo json_encode("Success");
    }