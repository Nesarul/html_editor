<?php
    require_once('../admin/function.php');
    if(isset($_POST["course"]) && trim($_POST["course"]) != "")
    {
        // $res = db::getInstance()->query("SELECT * FROM unit WHERE course_id = ?",$params = array($_POST["course"]))->getResults();
        // $sql = "SELECT s.s_id,u.unit_id,u.unit_name,u.unit_title,u.unit_author,u.unit_created, c.course_name 
        // FROM sort_unit AS s 
        // INNER JOIN unit AS u ON u.unit_id = s.u_id 
        // INNER JOIN course AS c ON c.course_id = s.c_id 
        // WHERE s.c_id = ? ORDER BY s.s_ord ASC";
        $res = unit::getInstance()->getUnits($_POST['course']);
        echo json_encode($res);
    }