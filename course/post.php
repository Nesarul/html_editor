<?php
require_once('../admin/db/db.php');

if(isset($_POST['contents']))
{
    db::getInstance()->update('unit',array('unit_id'=>$_POST['idno']),array('unit_contents'=>$_POST['contents'],'unit_status'=>'0'));
    header("Location: read_course.php?id=$_POST[idno]&&course=$_POST[course]");
}