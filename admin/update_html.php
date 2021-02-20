<?php
require_once('./db/db.php');
//require_once('./function.php');

// if(isset($_POST['cont']) && !empty($_POST['cont']))
// {
//     $contents = $_POST['cont'];
//     $id = $_POST['fileid'];

//     $sql = "UPDATE files SET file_contents = '".$contents."' WHERE id_no = ?";
//     $x = db::getInstance()->query($sql,$param = array($id));
    
// }

if(isset($_POST['cont']) && !empty($_POST['cont']))
{
    $contents = $_POST['cont'];
    $id = $_POST['id'];
    $course = $_POST['course'];

    $sql = "UPDATE unit SET unit_contents = '".$contents."' WHERE unit_id = ? AND course_id = ?";
    $x = db::getInstance()->query($sql,$param = array($id,$course));
    
}