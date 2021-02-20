<?php
class config{
    static function configGet($param){
        $data = parse_ini_file('config.ini',true);
        $path = explode('/',$param);
        foreach($path as $code){
            if(array_key_exists($code,$data))
                $data = $data[$code];
            else{
                $data = "Key not found!";
                break;
            }
        }
       return $data; 
    }
}