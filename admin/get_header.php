<?php
require_once('./function.php');
$response = array(
    'message' => 'blank',
    'status' => '0'
);
if(isset($_POST["cid"]) && !empty($_POST['cid']))
{
    $x = course::getInstance()->getCourse($_POST['cid']);
    $response['message'] = $x[0]->c_title;
    
}
echo json_encode($response);