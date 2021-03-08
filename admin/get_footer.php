<?php
require_once('./function.php');
$response = array(
    'message' => 'blank',
    'footer' => 'blank',
    'status' => '0'
);
if(isset($_POST["cid"]) && !empty($_POST['cid']))
{
    $x = course::getInstance()->getCourse($_POST['cid']);
    $response['message'] = $x[0]->c_footer;
    $response['footer'] = $x[0]->footer_caption;
}
echo json_encode($response);