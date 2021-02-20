<?php
    require_once('./db/db.php');
    require_once('./function.php');

    if(isset($_POST["parent"]) && !empty($_POST['parent']))
    {
        $parent_id = $_POST['parent'];
        $unit_name = $_POST['unit'];
        
        $sql = "INSERT INTO unit(unit_name,course_id) VALUE('$unit_name',$parent_id)";
        $x = db::getInstance()->query($sql);
        
        $sql = "SELECT * FROM course WHERE course_id = ?";
        $x = db::getInstance()->query($sql,$param = array($parent_id))->getResults();
    
        // Create Folder
        $dirName = dirname($root,1).'/work/'.$x[0]->course_name.'/In Progress/Modules/'.$unit_name;
        mkdir("$dirName",0777);
        
        echo $unit_name;
    }
    
    