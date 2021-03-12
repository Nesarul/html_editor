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

class htmlEditor{
    private $_dt,
            $_ssn,
            $_db;

    private function __construct() {
        $this->_ssn = Session::getInstance();
    }
    
    static function getTime(){
        $_dt = new DateTime();
        return $_dt->format("Y-m-d H:i:s");
    }
    static function getDb(){
        return db::getInstance();
    }
    static function getSSN(){
        return Session::getInstance();
    }
}

class course{
    private static $_instance = null;
    private $_unit,
            $_su,
            $_results;
    private $_message = array(
        'error' => "1",
        'Message' => "Something Wrong Happen"
    );

    private function __construct() {
        $this->_unit = unit::getInstance();
        $this->_su = sort_unit::getInstance();
        self::$_instance = $this;
    }

    public static function getInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function getTable(){
        return get_class($this);
    }
    public function getAll(){
        $this->_results = htmlEditor::getDb()->query("SELECT * FROM ".$this->getTable())->getResults();
        return $this;
    }
    public function getCourse($id){
        return htmlEditor::getDb()->get($this->getTable(),array('course_id','=',$id))->getResults();
    }
    public function create($course,$sme,$title,$css_path,$js_path){
        if(htmlEditor::getDb()->insert($this->getTable(),array('course_name' => $course,'date_created' => htmlEditor::getTime(),'author' => htmlEditor::getSSN()->user,'sme' => $sme,'c_title'=>$title,'c_css'=>$css_path,'c_js'=>$js_path))){
            $message['error']="0";
            $message['Message']="Record Inserted Successfully";
        }
        return $this->_message;
    }

    function delete($id){
        htmlEditor::getDb()->delete($this->getTable(),array('course_id',"=",$id));
        return true;
    }
    public function getResults(){
        return $this->_results;
    }
};

class unit{
    private static $_instance = null;
    private $_message = array(
        'error' => "1",
        'Message' => "Something Wrong Happen"
    );
    
    private function __construct() {
        self::$_instance = $this;
    }

    public static function getInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    private function getTable(){
        return get_class($this);
    }
    
    function delete($params){
        htmlEditor::getDb()->delete($this->getTable(),$params);
    }

    public function createUnit($unit,$course,$sme,$title){
        htmlEditor::getDb()->insert($this->getTable(),array('unit_name' => $unit,'course_id' => $course,'unit_author' => htmlEditor::getSSN()->user,'unit_created' => htmlEditor::getTime(),'unit_contents' => '','unit_status' => '0','unit_approved_by' => '0','unit_sme' => $sme,'unit_title'=>$title));
        $res = htmlEditor::getDb()->query('SELECT LAST_INSERT_ID() as pk')->getResults();
        db::getInstance()->insert('sort_unit',array('c_id' => $course,'u_id' => $res[0]->pk,'s_u_id'=>$sme,'s_ord' => '0'));
        $response['Message']="Success";
    }
    public function getUnits($courseID){
        $sql = "SELECT s.s_id,u.unit_id,u.unit_name,u.unit_author,u.unit_created, c.course_name 
        FROM sort_unit AS s 
        INNER JOIN unit AS u ON u.unit_id = s.u_id 
        INNER JOIN course AS c ON c.course_id = s.c_id 
        WHERE s.c_id = ? ORDER BY s.s_ord ASC";
        return htmlEditor::getDb()->query($sql,$params = array($courseID))->getResults();     
    }
    
    public function getStatus($unitID){
        return htmlEditor::getDb()->get('unit',array('unit_id','=',$unitID))->getResults();
    }
};
class sort_unit{
    private static $_instance = null;
    private $_message = array(
        'error' => "1",
        'Message' => "Something Wrong Happen"
    );
    
    private function __construct() {
        self::$_instance = $this;
    }

    public static function getInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    private function getTable(){
        return get_class($this);
    }
    function delete($params){
        htmlEditor::getDb()->delete($this->getTable(),$params);
    }
};

class users{
    private static $_instance = null;
    private $_message = array(
        'error' => "1",
        'Message' => "Something Wrong Happen"
    );
    
    private function __construct() {
        self::$_instance = $this;
    }

    public static function getInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    private function getTable(){
        return get_class($this);
    }
    
    function delete($params){
        htmlEditor::getDb()->delete($this->getTable(),$params);
    }    
}

class pages{
    private static $_instance = null;
    private $_message = array(
        'error' => "1",
        'Message' => "Something Wrong Happen"
    );
    
    private function __construct() {
        self::$_instance = $this;
    }

    public static function getInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    private function getTable(){
        return get_class($this);
    }
    
    function delete($params){
        htmlEditor::getDb()->delete($this->getTable(),$params);
    }
    function getPages($unitID){
        
        $sql = "SELECT * FROM pages WHERE unit_id";
        return htmlEditor::getDb()->get('pages',array('unit_id','=',$unitID))->getResults();
    }
    function getPageContents($pageID){
        $sql = "SELECT u.unit_id,u.unit_name,p.page_id,p.page_name,p.page_caption,p.page_contents,p.page_status 
        FROM pages AS p 
        INNER JOIN unit AS u 
        ON u.unit_id = p.unit_id WHERE p.page_id = ?";
        return htmlEditor::getDb()->query($sql,$params = array($pageID))->getResults();     
    }
    function getPageStatus($pageID){
        return htmlEditor::getDb()->get('pages',array('page_id','=',$pageID))->getResults();
    }
    public function approvePage($pageID){
        htmlEditor::getDb()->update($this->getTable(),array('page_id'=>$pageID),array('page_status'=>1,'page_approved_by'=>htmlEditor::getSSN()->user_id));
    }
    public function rollbackPage($pageID){
        htmlEditor::getDb()->update($this->getTable(),array('page_id'=>$pageID),array('page_status'=>0,'page_approved_by'=>0));
    }
    public function pageCreate($page_course_id,$page_unit_id,$page_name,$page_caption,$status,$approved){
        htmlEditor::getDb()->insert($this->getTable(),array('course_id'=>$page_course_id,'unit_id'=>$page_unit_id,'page_name'=>$page_name,'page_caption'=>$page_caption,'page_contents'=>'','page_status'=>$status,'page_approved_by'=>$approved));
    }
}