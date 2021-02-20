<?php
require_once('config/config.php');

class db{
    private static $_instance = null;
    private $_pdo = null,
            $_query = null,
            $_results = null,
            $_counts = 0;

    public static function getInstance(){
        if(!isset(self::$_instance))
            self::$_instance = new db();
        return self::$_instance;
    }

    private function __construct(){
        $dsn = "mysql:dbname=".config::configGet('mysql/dbName').";host=".config::configGet('mysql/dbHost').";charset=utf8mb4";
        try{
            $this->_pdo = new PDO($dsn,config::configGet('mysql/dbUser'),config::configGet('mysql/dbPass'));
        }catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function query($sql,$params = array()){
        if($this->_query = $this->_pdo->prepare($sql)){
            $x=0;
            if(count($params))
                foreach($params as $param)
                    $this->_query->bindValue(++$x,$param);

            if($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_counts = $this->_query->rowCount();
            }
            else
            {
                return 0;
            }
        }
        return $this;
    }

    public function getResults(){
        return $this->_results;
    }
    public function getCounts(){
        return $this->_counts;
    }
}