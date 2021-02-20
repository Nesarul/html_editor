<?php
    require_once('../admin/function.php');
    require_once('../admin/db/db.php');
    if($data->logStatus != "logged")
        header("Location: ../index.php");
    require_once('../assets/inc/header.php');        
?>
<!-- leftbar -->
<div class="left-bar">
<p class="text-center"><img src="../assets/images/logo.png" alt="" width="50%"></p>
    <img src="../assets/images/upload/<?php echo($data->image); ?>" alt="" class="mx-auto d-block rounded-circle" width="50">
    <h6>Welcome<br/><?php echo $data->user; ?></h6>
    <hr>
    <!-- Menu -->
    <ul class="list-unstyled menu">
        <?php foreach($menu_data->item as $key => $rec):?>
            <li>
                <a class="main-menu" href="<?php echo $rec->link; ?>">
                    <?php echo '<i class="'.$rec->image.'"></i> &nbsp;'. $rec->caption; ?>
                </a>
            </li>   
        <?php endforeach; ?>
    </ul>
</div>
<div class="right-bar">
    <div class="container-fluid">
        <div class="row py-3">
            <div class="col-12">
                <style>
                    .unit-info-window{
                        width:100%;
                        margin-bottom:20px;
                        background-color:#066;
                        padding:15px;
                        color: white;
                    }
                    .table{
                        margin-bottom:0;
                    }
                    th,td{
                        color:white;
                        padding:2px 5px !important;
                    }
                </style>
                <?php 
                    $sql = "SELECT u.unit_id,u.unit_name,u.unit_author,u.unit_created,u.unit_contents,u.unit_status,u.unit_approved_by, c.course_name,c.author,us.user_first_name,us.user_last_name FROM unit AS u LEFT JOIN course AS c ON u.course_id = c.course_id LEFT JOIN users AS us ON us.user_id = u.unit_approved_by WHERE u.course_id = ? AND u.unit_id = ?";
                    $res = db::getInstance()->query($sql,array($_GET['course'],$_GET['unit']))->getResults();
                    if($res != NULL):
                ?>      
                <div class="unit-info-window">
                    <table class="table table-borderless table-sm">
                        <tbody>
                            <tr>
                                <th width="150">Course Name</th>
                                <td>: <?php echo $res[0]->course_name;?></td>
                            </tr>
                            <tr>
                                <th>Course Author</th>
                                <td>: <?php echo $res[0]->author;?></td>
                            </tr>
                            <tr>
                                <th>Unit Name</th>
                                <td>: <?php echo $res[0]->unit_name;?></td>
                            </tr>
                            <tr>
                                <th>Unit Author</th>
                                <td>: <?php echo $res[0]->unit_author;?></td>
                            </tr>
                            <tr>
                                <th>Unit Create At</th>
                                <td>: <?php echo $res[0]->unit_created;?></td>
                            </tr>
                            <tr>
                                <th>Unit Approved By</th>
                                <td>: 
                                    <?php 
                                        if($res[0]->user_first_name != NULL)
                                            echo $res[0]->user_first_name.' '.$res[0]->user_last_name;
                                        else   echo "In progress, Havent approved by anyone.";
                                    ?> 
                                </td>
                            </tr>
                        </tbody>
                    </table>   
                </div>
                <?php echo $res[0]->unit_contents; endif;?>
            </div>
        </div>
    </div>
</div>


<?php
    require_once("../assets/inc/footer.php");
?>