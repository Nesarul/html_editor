<?php
require_once('./db/db.php');
$response = array(
    'message' => 'blank',
    'status' => '0'
);
if(isset($_POST["footerText"]) && !empty($_POST['footerText']))
{
    // $x = db::getInstance()->get('course',array('course_id','=',$_POST['cid']))->getResults();
    db::getInstance()->update('course',array('course_id'=>$_POST['id']),array('c_footer'=>$_POST['footerText']));
    $response['message'] = "Record Update Successfully";
    
}
echo json_encode($response);