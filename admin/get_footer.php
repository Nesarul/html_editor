<?php
require_once('./db/db.php');
$response = array(
    'message' => 'blank',
    'status' => '0'
);
if(isset($_POST["cid"]) && !empty($_POST['cid']))
{
    $x = db::getInstance()->get('course',array('course_id','=',$_POST['cid']))->getResults();
    $response['message'] = $x[0]->c_footer;
    
}
echo json_encode($response);