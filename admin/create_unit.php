<?php
    require_once('./db/db.php');
    require_once('./function.php');
    setTimezone();
    $response = array(
        'status' => "0",
        'Message' => "Something Wrong Happen"
    );
    if(isset($_POST['course']))
    {
        $unit = $_POST['unit'];+
        $course = $_POST['course'];
        $sme = $_POST['sme'];
        $page_title = $_POST['pt'];
        $user = $data->user;
        $d = new DateTime();
        $now = $d->format("Y-m-d H:i:s");
        db::getInstance()->insert('unit', array('unit_name' => $unit,'course_id' => $course,'unit_author' => $user,'unit_created' => $now,'unit_contents' => '','unit_status' => '0','unit_approved_by' => '0','unit_sme' => $sme,'unit_title'=>$page_title));
        $res = db::getInstance()->query('SELECT LAST_INSERT_ID() as pk')->getResults();
        db::getInstance()->insert('sort_unit',array('c_id' => $course,'u_id' => $res[0]->pk,'s_u_id'=>$sme,'s_ord' => '0'));
        $response['Message']="Success";
    }
    echo json_encode($response);