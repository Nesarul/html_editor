<?php 
require_once('./db/db.php');

if(isset($_POST["id"]) && !empty($_POST['id']))
{
    $idID = $_POST['id'];
    
    $sql = "SELECT file_contents FROM files WHERE id_no = ?";
    $x = db::getInstance()->query($sql,$param = array($idID))->getResults();
    
    // echo $unit_name;
    echo json_encode($x);
}