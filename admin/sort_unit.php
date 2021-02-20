<?php
require_once('./db/db.php');
$response = array(
    'status' => '0',
    'message' => 'successful'
);
if(isset($_POST['srt'])){
    $pk = $_POST['srt'];
    $id = 0;
    $data = "";
    foreach($pk as $key=>$rec){
        $id = $key;
        $data = $rec['unit_id'];
        db::getInstance()->update('sort_unit',array('u_id'=>$data),array('s_ord'=>$id));
    }
}
echo json_encode($response);