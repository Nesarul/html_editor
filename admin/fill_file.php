<?php
    require_once('./db/db.php');

    if(isset($_POST["course"]) && !empty($_POST['course']))
    {
        $fileCourse = $_POST['course'];
        $fileUnit = $_POST['unit'];
       
        $sql = "SELECT id_no,file_name FROM files WHERE unit_id = ? AND course_id = ?";
        $x = db::getInstance()->query($sql,$params = array($fileUnit,$fileCourse))->getResults();
        
        echo json_encode($x);
    }