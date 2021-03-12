<?php
require_once('../admin/db/db.php');

if(isset($_POST['contents']))
{
    db::getInstance()->update('pages',array('page_id'=>$_POST['idno']),array('page_contents'=>$_POST['contents'],'page_status'=>'0'));
    header("Location: read_course.php?page=$_POST[idno]");
}