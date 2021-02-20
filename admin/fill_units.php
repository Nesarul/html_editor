<?php

require_once('./db/db.php');

    if(isset($_POST["course"]) && !empty($_POST['course']))
    {
        $courseID = $_POST['course'];
        
        $sql = "SELECT * FROM unit WHERE course_id = ?";
        $x = db::getInstance()->query($sql,$param = array($courseID))->getResults();
        
        // echo $unit_name;
        echo json_encode($x);
    }