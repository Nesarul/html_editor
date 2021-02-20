<?php
require_once('./db/db.php');
require_once('./function.php');
// course:courseId,unit:unitId,name:fileName;
if(isset($_POST['name']) && !empty($_POST['name']))
{
    $fileCourse = $_POST['course'];
    $fileUnit = $_POST['unit'];
    $fileName = $_POST['name'];
    $fileTitle = $_POST['title'];
    $fileHeader = $_POST['header'];
    
    $sql = "INSERT INTO files(course_id, unit_id, file_name, file_title, file_header) VALUE('$fileCourse','$fileUnit','$fileName','$fileTitle','$fileHeader')";
    db::getInstance()->query($sql);

    $dirName = dirname($root,1).'/work/'.$_POST['cn'].'/In Progress/Modules/'.$_POST['un'];
    copy(dirname($root,1).'/template/template1.html',$dirName."/".$fileName.".html");

    $sql = "SELECT file_name FROM files WHERE unit_id = ? AND course_id = ?";
    $x = db::getInstance()->query($sql,$params = array($fileUnit,$fileCourse))->getResults();
    echo json_encode($x);
    
}