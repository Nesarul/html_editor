<?php
if(isset($_GET['logout']))
{
    require_once('../admin/function.php');
    require_once('../admin/db/db.php');
    session_destroy();
    $data->logStatus = "logout";
    header("Location: ../index.php");
	exit;
}
?>