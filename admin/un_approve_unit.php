<?php
    require_once('./db/db.php');
    require_once('function.php');
    if(isset($_POST['id']) && !empty($_POST['id']))
    {
        $unitId = $_POST['id'];
        $sql = "UPDATE unit SET unit_status=0, unit_approved_by=1 WHERE unit_id=?";
        db::getInstance()->query($sql,array($unitId));
        echo json_encode("Success");
    }