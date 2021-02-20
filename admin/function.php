<?php
require_once('../admin/session/session.php');
require_once('../admin/db/db.php');

$data = Session::getInstance();
$root = $_SERVER['DOCUMENT_ROOT'].'/drew/work/';
$menu_data = simplexml_load_file($data->type != "3" ? "../assets/xml/menu.xml" : "../assets/xml/menu-sme.xml") or die("Failed to load");
function setTimezone(){
    date_default_timezone_set("Canada/Eastern");
}
function getData(){
    return $data;
}
class course{
    private const t = 'course';
    private static $_instance = null;
    private $_dt,
            $_ssn,
            $_db,
            $_results;
    private $_message = array(
        'error' => "1",
        'Message' => "Something Wrong Happen"
    );

    private function __construct() {
        $this->_dt = new DateTime(); 
        $this->_db = db::getInstance();
        $this->_ssn = Session::getInstance();
        self::$_instance = $this;
    }

    public static function getInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function getTable(){
        return self::t;
    }
    public function getAll(){
        $this->_results = $this->_db->query("SELECT * FROM ".$this->getTable())->getResults();
        return $this;
    }
    public function create($course,$sme,$title,$css_path,$js_path){
        if($this->_db->insert($this->getTable(),array('course_name' => $course,'date_created' => $this->_dt->format("Y-m-d H:i:s"),'author' => $this->_ssn->user,'sme' => $sme,'c_title'=>$title,'c_css'=>$css_path,'c_js'=>$js_path))){
            $message['error']="0";
            $message['Message']="Record Inserted Successfully";
        }
        return $this->_message;
    }

    public function delete($id){
        $this->_db->delete('sort_unit',array('c_id',"=",$_POST['id']));
        $this->_db->delete('unit',array('course_id','=',$_POST['id']));
        $this->_db->delete($this->getTable(),array('course_id','=',$_POST['id']));
        return true;
    }
    public function getResults(){
        return $this->_results;
    }
};

class unit{
    private static $_instance = null;
    private $_dt,
            $_ssn,
            $_db;
    private $_message = array(
        'error' => "1",
        'Message' => "Something Wrong Happen"
    );

    private function __construct() {
        $this->_db = db::getInstance();
        self::$_instance = $this;
    }

    public static function getInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getUnits($courseID){
        $sql = "SELECT s.s_id,u.unit_id,u.unit_name,u.unit_title,u.unit_author,u.unit_created, c.course_name 
        FROM sort_unit AS s 
        INNER JOIN unit AS u ON u.unit_id = s.u_id 
        INNER JOIN course AS c ON c.course_id = s.c_id 
        WHERE s.c_id = ? ORDER BY s.s_ord ASC";
        return $this->_db->query($sql,$params = array($courseID))->getResults();     
    }
};